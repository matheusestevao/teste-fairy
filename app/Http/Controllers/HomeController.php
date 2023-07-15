<?php

namespace App\Http\Controllers;

use App\Services\OccupationService;
use App\Services\UserService;
use Illuminate\Support\Arr;

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
        
    }
}
