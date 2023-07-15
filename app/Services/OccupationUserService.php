<?php

namespace App\Services;

use App\Models\OccupationUser;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class OccupationUserService
{
    public function __construct(
        protected OccupationService $occupationService
    )
    {
        //
    }

    public function store(
        int $salary, 
        string $user,
        string $occupation
    ): void
    {
        try {
            OccupationUser::create([
                'user_id' => $user,
                'occupation_id' => $occupation,
                'salary' => $salary
            ]);
        } catch (\Throwable $th) {
            throw new ($th->getMessage());
            
            Log::info($th->getFile() . ' - ' . $th->getLine() . ' - ' . print_r($th->getMessage(), 1));
        }
    }

    public function occupation_action(
        string $occupation,
        string $user,
        int $salary
    ): void
    {
        $check = OccupationUser::whereOccupationId($occupation)
                                ->whereUserId($user)
                                ->first();

        if (empty($check)) {
            $this->store($salary, $user, $occupation);

            return;
        }

        if ($check->salary !== $salary) {
            $check->delete();

            $this->store($salary, $user, $occupation);

            return;
        }
    }
}