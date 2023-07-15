<?php

namespace App\Services;

use App\Jobs\ProccessUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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
            Log::info($th->getFile() . ' - ' . $th->getLine() . ' - ' . print_r($th->getMessage(), 1));
        }
    }

    public function get_user_to_email(string $email): ?object
    {
        return User::whereEmail($email)->first();
    }

    public function get_users(): array
    {
        $users = User::join('occupation_users', 'occupation_users.user_id', '=', 'users.id')
                        ->select(
                            'users.*',
                            DB::raw('occupation_users.salary / 100 as salary'),
                            DB::raw('DATEDIFF(COALESCE(termination_date, CURRENT_TIMESTAMP), hire_date) AS time_service')
                        )
                        ->hasOccupationUsers()
                        ->orderBy('occupation_users.salary')
                        ->get();

        return $users->load('occupations', 'occupation_actual')->toArray();
    }
}