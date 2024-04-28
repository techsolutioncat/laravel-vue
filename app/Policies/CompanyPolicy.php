<?php

namespace App\Policies;

use App\Company;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any companies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // If the user is higher than admin, he can view any company
        return $user->isBranchAdmin();
    }

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        //
        return $this->checkBranch($user, $company);
    }

    /**
     * Determine whether the user can create companies.
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
     * Determine whether the user can update the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        // 
        return $this->checkBranch($user, $company);
    }

    // public function updateID(User $user, $userID)
    // {
    //     $result = false;
    //     if ($user->isAdmin()) {
    //         $result = true;
    //     }
    //     $result = $user->id == $userID;
    //     return $result? Response::allow()
    //             : Response::deny('This action is unauthorized.');        
    // }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        //
        return $this->checkBranch($user, $company);
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
        return $this->checkBranch($user, $company);
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
        return $this->checkBranch($user, $company);
    }

    protected function checkBranch(User $user, Company $company)
    {
        $result = false;
        if ($user->isAdmin()) {
            $result = true;
        } else {
            $result = $user->id == $company->user_id;
        }
        return $result;
    }
}
