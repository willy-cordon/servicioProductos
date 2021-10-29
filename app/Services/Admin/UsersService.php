<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Models\Account;
use App\Models\AccountServiceOrder;
use App\Models\Product;
use App\Models\ProductSync;
use App\Models\User;
use Broobe\Services\Service;
use Broobe\Services\Traits\{ DestroyModel };
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class UsersService
 * @package App\Services\Admin
 */
final class UsersService extends Service
{
    use DestroyModel;



    /**
     * Set model class name.
     *
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = User::class;
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
     * @param StoreUsersRequest $request
     * @return User
     */
    public function create(StoreUsersRequest $request): User
    {
        $user = $this->model::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
        $user->account()->associate(Account::find($request->account_id))->save();
        return  $user;
    }

    /**
     * @param UpdateUsersRequest $request
     * @param User $user
     * @return User
     */
    public function update(UpdateUsersRequest $request, User $user): User
    {
        $user->update($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);
        $user->tokens()->delete();
        $user->account()->associate(Account::find($request->account_id))->save();
        return $user;
    }

    public function destroy(Model $model): bool
    {
        $destroyAccount = Account::query();
        $destroyAccount->leftJoin('account_service','account_service.account_id','=','accounts.id');
        $destroyAccount->where('account_service.account_id','=',$model->account_id);
        $destroyAccount->select(['account_service.id']);
        $getDestroyAccount = $destroyAccount->get();

        $getDestroyAccount->each(function($accountService){
            ProductSync::where('account_service_id',$accountService->id)->delete();
            AccountServiceOrder::where('account_service_id',$accountService->id)->delete();
            DB::table('account_service')->delete($accountService->id);
        });
        $deleteProduct = Product::query();
        $deleteProduct->where('account_id',$model->account_id);
        $deleteProduct->delete();
        Account::destroy($model->account_id);
        return User::where('id',$model->id)->delete();

    }


    /**
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        $this->model::whereIn('id', request('ids'))->delete();
    }
}
