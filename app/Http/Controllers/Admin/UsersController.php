<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\User;
use App\Services\Admin\UsersService;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UsersController extends Controller
{

    /**
     * @var UsersService
     */
    private $usersService;

    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->usersService->all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::get()->mapWithKeys(function($rol){return [$rol->id => $rol->name];});
        $accounts = Account::all();
        $action =  route("admin.users.store");
        $method = 'POST';
        return view('admin.users.create_edit', compact('roles', 'action', 'method','accounts'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreUsersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUsersRequest $request)
    {
        Log::debug($request);
        $this->usersService->create($request);
        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::get()->mapWithKeys(function($rol){return [$rol->id => $rol->name];});
        Log::debug($roles);
        $accounts = Account::all();
        $action = route("admin.users.update",[$user->id]);
        $method = 'PUT';
        return view('admin.users.create_edit', compact('user', 'roles', 'action', 'method','accounts'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUsersRequest $request, User $user)
    {
         $this->usersService->update($request, $user);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {

        $this->usersService->destroy($user);
        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {

        $this->usersService->massDestroy($request);
        return response()->noContent();
    }

}
