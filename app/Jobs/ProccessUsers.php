<?php

namespace App\Jobs;

use App\Services\OccupationService;
use App\Services\OccupationUserService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $data,
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
        $occupaction = $occupationService->get_occupation_to_name($this->data[3]);
        
        $user = $userService->get_user_to_email($this->data[5]);

        if (empty($user)) {
            $userService->store_to_import($this->data);
        } else {
            $occupationUserService->occupation_action($occupaction->id, $user->id, ($this->data[4] * 100));
        }
    }
}
