<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Models\User;
use Broobe\Services\Service;
use Broobe\Services\Traits\{DestroyModel};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

final class RolesService extends Service
{
    use DestroyModel;

    /**
     * Set model class name.
     *
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Role::class;
    }

    /**
     * Get al Appointment types
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model::all();
    }

    /**
     * @param StoreRolesRequest $request
     * @return Role
     */
    public function create(StoreRolesRequest $request): Role
    {
        $role = $this->model::create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);
        return  $role;
    }

    /**
     * @param UpdateRolesRequest $request
     * @param Role $role
     * @return Role
     */
    public function update(UpdateRolesRequest $request, Role $role): Role
    {
        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);

        User::role($role)->each(function ($user){
            $user->tokens()->delete();
        });

        return $role;
    }


    /**
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        $this->model::whereIn('id', request('ids'))->delete();
    }
}
