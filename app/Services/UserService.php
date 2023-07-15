<?php

namespace App\Services;

use App\Jobs\ProccessUsers;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(
        protected OccupationUserService $occupationUserService,
        protected OccupationService $occupationService
    )
    {
        //
    }

    public function read_file($file)
    {
        $readFile = fopen($file, 'r');

        while (($data = fgetcsv($readFile, null, ',')) !== false) {
            if($data[0] !== 'Nome') {
                ProccessUsers::dispatch($data);
            }
        }

        fclose($readFile);
    }

    public function store_to_import(array $data): ?object
    {
        try {
            $user = User::create([
                'name' => $data[0],
                'email' => $data[5],
                'hire_date' => \DateTime::createFromFormat('d/m/Y', $data[1])->format('Y-m-d'),
                'termination_date' => !empty(trim($data[2])) ? \DateTime::createFromFormat('d/m/Y', $data[2])->format('Y-m-d') : NULL,
            ]);
    
            $occupation = $this->occupationService->get_occupation_to_name($data[3]);
    
            $this->occupationUserService->store(($data[4] * 100), $user->id, $occupation->id);
    
            return $user;
        } catch (\Throwable $th) {
            throw $th->getMessage();

            Log::info($th->getFile() . ' - ' . $th->getLine() . ' - ' . print_r($th->getMessage(), 1));
        }
    }

    public function get_user_to_email(string $email): ?object
    {
        return User::whereEmail($email)->first();
    }
}