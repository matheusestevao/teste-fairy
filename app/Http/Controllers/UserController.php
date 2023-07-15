<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserImportFileRequest;
use App\Jobs\ProccessUsers;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
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
    }

    public function import(UserImportFileRequest $request)
    {
        $file = $request->file('file');
        $tempPath = $file->store('temp');

        ProccessUsers::dispatch($tempPath, Auth::user()->email)->onQueue('import');
        
        return redirect()
                ->route('users.import')
                ->with('success', 'Estamos processando o arquivo. Ao terminar, iremos lhe notificar por e-mail.');
    }
}
