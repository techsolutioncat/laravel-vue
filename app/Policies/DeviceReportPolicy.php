<?php

namespace App\Policies;

use App\DeviceReport;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DeviceReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any device reports.
     *
     * @param  \App\User  $user
     * @return mixed
     */

    ////   custom
    // Determine the ability to the app/Http/Api/TrackingController->polling
    public function polling(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    // Determine the ability to the app/Http/Api/TrackingController->initPositionRequest
    public function initPositionRequest(User $user, DeviceReport $deviceReport)
    {

        return $this->checkBranch($user, $deviceReport);
    }
    
    // Determine the ability to the app/Http/Api/TrackingController->checkPositionResult
    public function checkPositionResult(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }
    //// end of custom


    public function viewAny(User $user)
    {
        //
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the device report.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceReport  $deviceReport
     * @return mixed
     */
    public function view(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    /**
     * Determine whether the user can create device reports.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // If the user is higher than branch admin, he can create company
        return $user->isBranchAdmin();
    }

    /**
     * Determine whether the user can update the device report.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceReport  $deviceReport
     * @return mixed
     */
    public function update(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    /**
     * Determine whether the user can delete the device report.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceReport  $deviceReport
     * @return mixed
     */
    public function delete(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    /**
     * Determine whether the user can restore the device report.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceReport  $deviceReport
     * @return mixed
     */
    public function restore(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    /**
     * Determine whether the user can permanently delete the device report.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceReport  $deviceReport
     * @return mixed
     */
    public function forceDelete(User $user, DeviceReport $deviceReport)
    {
        //
        return $this->checkBranch($user, $deviceReport);
    }

    protected function checkBranch(User $user, DeviceReport $deviceReport)
    {
        if ($user->isAdmin()) {  // if client
            return true;
        } 
        
        $resultBranch = false;
        if (!empty($deviceReport->deviceAssignment->company->user_id)) {  // if branch
            $resultBranch = $user->id == $deviceReport->deviceAssignment->company->user_id;
        }

        $resultClient = false;
        if (!empty($user->company_id)) {
            $resultClient = $deviceReport->deviceAssignment->company_id == $user->company_id;
        }

        return $resultBranch || $resultClient;
    }
}
