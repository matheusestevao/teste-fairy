<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserImportFileRequest;
use App\Services\OccupationService;
use App\Services\OccupationUserService;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected OccupationService $occupationService,
        protected OccupationUserService $occupationUserService
    )
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->get_users();

        $order_by_salary_asc = array_values(Arr::sortDesc($users, function (array $value) {
            return $value['salary'];
        }));

        return Inertia::render('User/Index', [
            'order_by_salary_asc' => $order_by_salary_asc
        ]);
    }

    public function import()
    {
        return Inertia::render('User/Import');
    }

    public function read_import(UserImportFileRequest $request)
    {
        $file = $request->file('file')->get();
        $lines = explode(PHP_EOL, $file);
        
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            
            if (count($data) !== 6) {
                continue;
            }
            if($data[0] !== 'Nome') {
                $occupaction = $this->occupationService->get_occupation_to_name($data[3]);
        
                $user = $this->userService->get_user_to_email($data[5]);

                if (empty($user)) {
                    $this->userService->store_to_import($data);
                } else {
                    $$this->occupationUserService->occupation_action($occupaction->id, $user->id, ($data[4] * 100));
                }
            }
        }
        
        return redirect()
                ->route('users.import')
                ->with('success', 'Estamos processando o arquivo. Ao terminar, iremos lhe notificar por e-mail.');
    }
}
