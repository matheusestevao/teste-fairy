<?php

namespace App\Http\Controllers;

use App\Services\OccupationService;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected OccupationService $occupationService,
    )
    {
        
    }
    public function index()
    {
        $users = $this->userService->get_users();

        $veteram_employee = array_values(Arr::sortDesc($users, function (array $value) {
            return $value['time_service'];
        }));

        $average_salary = $this->occupationService->average_salary();
        
        return Inertia::render('Dashboard', [
            'veteram_employee' => Arr::first($veteram_employee),
            'average_salary' => $average_salary
        ]);
    }
}
