<?php

namespace App\Services;

use App\Models\Occupation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OccupationService
{
    public function get_occupation_to_name(string $occupation): ?object
    {
        try {
            return Occupation::updateOrCreate([
                'name' => ucfirst(strtolower($occupation))
            ]);
        } catch (\Throwable $th) {            
            Log::info($th->getFile() . ' - ' . $th->getLine() . ' - ' . print_r($th->getMessage(), 1));
        }
    }

    public function average_salary(): array
    {
        return Occupation::select('occupations.name as profission', DB::raw('AVG(occupation_users.salary) / 100 as average_salary'))
                ->join('occupation_users', 'occupations.id', '=', 'occupation_users.occupation_id')
                ->whereNull('occupation_users.deleted_at')
                ->groupBy('occupations.id', 'occupations.name')
                ->get()
                ->toArray();
    }
}