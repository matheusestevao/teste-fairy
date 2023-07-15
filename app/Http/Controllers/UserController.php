<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserImportFileRequest;
use App\Services\UserService;

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
        
    }

    public function import(UserImportFileRequest $request)
    {
        $this->userService->read_file($request->file('file'));
        
        return redirect()
                ->route('users.import')
                ->with('success', 'Estamos processando o arquivo. Ao terminar, iremos lhe notificar por e-mail.');
    }
}
