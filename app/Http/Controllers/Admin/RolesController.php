<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\RolesService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;

class RolesController extends Controller
{

    /**
     * @var RolesService
     */
    private $rolesService;

    public function __construct(RolesService $service)
    {
        $this->rolesService = $service;
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $roles = $this->rolesService->all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::get()->mapWithKeys(function($permission){return [$permission->id => $permission->name];});
        $action =  route("admin.roles.store");
        $method = 'POST';

        return view('admin.roles.create_edit', compact('permissions', 'action', 'method'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreRolesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRolesRequest $request)
    {
        $this->rolesService->create($request);
        return redirect()->route('admin.roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get()->mapWithKeys(function($permission){return [$permission->id => $permission->name];});
        $action =  route("admin.roles.update",[$role->id]);
        $method = 'PUT';
        return view('admin.roles.create_edit', compact('role', 'permissions', 'action', 'method'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRolesRequest $request, Role $role)
    {
        $this->rolesService->update($request, $role);
        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
       $this->rolesService->destroy($role);
        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
       $this->rolesService->massDestroy($request);
        return response()->noContent();
    }

}
