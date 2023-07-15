<?php

namespace App\Jobs;

use App\Mail\FinishImportUser;
use App\Services\OccupationService;
use App\Services\OccupationUserService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProccessUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $file,
        protected string $email
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        UserService $userService,
        OccupationService $occupationService,
        OccupationUserService $occupationUserService
    ): void
    {
        $lines = explode(PHP_EOL, $this->file);
        
        foreach ($lines as $line) {
            $data = str_getcsv($line);

            if (count($data) !== 6) {
                continue;
            }
            
            if($data[0] !== 'Nome') {
                $occupaction = $occupationService->get_occupation_to_name($data[3]);
        
                $user = $userService->get_user_to_email($data[5]);

                if (empty($user)) {
                    $userService->store_to_import($data);
                } else {
                    $occupationUserService->occupation_action($occupaction->id, $user->id, ($data[4] * 100));
                }
            }
        }

        Mail::to($this->email)->send(new FinishImportUser());

        Storage::delete($this->file);
    }
}
