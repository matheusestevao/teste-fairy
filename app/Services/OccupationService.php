<?php

namespace App\Services;

use App\Models\Occupation;
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
            throw new ($th->getMessage());
            
            Log::info($th->getFile() . ' - ' . $th->getLine() . ' - ' . print_r($th->getMessage(), 1));
        }
    }
}