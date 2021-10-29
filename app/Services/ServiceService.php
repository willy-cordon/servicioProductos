<?php

namespace App\Services;

use App\Models\Service as ServiceModel;
use Broobe\Services\Service;
use App\Models\Service as ServiceB;
use Broobe\Services\Traits\{CreateModel, DestroyModel, ReadModel, UpdateModel};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class ServiceService extends  Service
{
    use CreateModel, ReadModel, UpdateModel, DestroyModel;

    /**
     * Set model class name.
     *
     * @return void
     */
    private $accountServiceService;
    protected function setModel(): void
    {
        // TODO: Implement setModel() method.
        $this->model = ServiceB::class;
        $this->accountServiceService = new AccountServiceService();
    }

    public function all(): Collection
    {
        return $this->model::withTrashed()->get();
    }

    public function restore($id)
    {
        return $this->model::withTrashed()->find($id)->restore();
    }

    public function getServicesForAccount()
    {
        try {
            $userLogged = Auth::guard('sanctum')->user();
            $accountServiceData = $this->accountServiceService->getAllActiveForAccount($userLogged->account_id);
            $serviceId = [];
            $accountServiceData->each(function($AccountService) use (&$serviceId){$serviceId[] = $AccountService->service_id;});
            $servicesQuery = ServiceModel::query();
            $servicesQuery ->whereIn('id',$serviceId);
            $servicesQuery ->select(['id','name']);
            return $servicesQuery->get();

        }catch (Throwable $exception){
            report($exception);
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }

}
