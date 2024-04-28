<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function Deployer\get;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    // 必要項目
    protected $fillable = [
        'name',
        'user_id',
        'phone',
        'postcode',
        'address',
        'owner_name',
        'owner_mail',
        'sb_payment_no',
        'message_enabled'
    ];

    protected $hidden = [];

    protected $appends = ['created_at_date', 'created_at_time'];

    public function user()
    {
        return $this->hasOne(User::class, 'company_id');
    }

    public function getCreatedAtDateAttribute(){
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at'])->format('Y/m/d') : null;
    }

    public function getCreatedAtTimeAttribute(){
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at'])->format('H:i:s') : null;
    }

    public static function register($data)
    {
        try {
            $company = Company::create([
                'name' => $data['name'],
                'user_id' => $data['user_id'],
                'phone' => $data['phone'],
                'postcode' => $data['postcode'],
                'address' => $data['address'],
                'owner_name' => $data['owner_name'],
                'owner_mail' => $data['owner_mail'],
                'sb_payment_no' => $data['sb_payment_no'],
                'message_enabled' => 1,
            ]);

            $user = User::create([
                'name' => $data['name'],
                'login_id' => $data['login_id'],
                'company_id' => $company->id,
                'password' => Hash::make($data['password']),
                'user_role_id' => 3,
                'enabled' => 1,
            ]);

            return $company;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public static function updateWithUser($data, $password_changed)
    {
        try {
            $company_data = [
                'id' => $data['id'],
                'name' => $data['name'],
                'user_id' => $data['user_id'],
                'phone' => $data['phone'],
                'postcode' => $data['postcode'],
                'address' => $data['address'],
                'owner_name' => $data['owner_name'],
                'owner_mail' => $data['owner_mail'],
                'sb_payment_no' => $data['sb_payment_no'],
                'message_enabled' => $data['message_enabled'],
            ];

            $user_data = [
                'name' => $data['name'],
                'login_id' => $data['login_id'],
                'company_id' => $data['id'],
                'enabled' => 1,
            ];

            if ($password_changed) {
                $user_data['password'] = Hash::make($data['password']);
            }

            $company = Company::find($data['id']);
            $company->fill($company_data)->save();
            

            // if user related to company does not exist, create that user
            try {
                $user = $company->user;
                if (isset($user)){
                    $company->user->fill($user_data)->save();
                }
                else {
                    $user_data['user_role_id'] = 3;
                    $user = User::create($user_data);                    
                }
            } catch (Exception $e) {
                return "bad";
            }

            return ['company' => $company];
        } catch (\PDOException $e) {
//            Log::Debug('Transaction Error: ' . print_r($e, true));
            throw $e;
        }
    }

    public static function getCompanyList()
    {
        if (Auth::user()->isAdmin()) {
            $companyArray = Company::select('id')->get()->pluck('id')->all();
        // } elseif (Auth::user()->isBranchAdmin()) {
        //     $companyArray = Company::select('id')->where('user_id', Auth::user()->id)->get()->pluck('id')->all();
        // } else {
        //     $companyArray = array(Auth::user()->company_id);
        // }    
        } else {
            $companyID = Auth::user()->company_id;
            //var_dump($companyID);exit;
            $companyArray = Company::select('id')->where('user_id', Auth::user()->id)->get()->pluck('id')->all();
            if (!in_array($companyID, $companyArray)) {
                array_push($companyArray, $companyID);
            }
        }

        return $companyArray;
    }

    public static function getCompanyNames()
    {
        if (Auth::user()->isAdmin()) {
            $companyArray = Company::select('name')->get()->pluck('name')->all();
        } else {
            $companyID = Auth::user()->company_id;
            $companyArray = Company::select('name')
                ->where('user_id', Auth::user()->id)
                ->orWhere('id', $companyID)
                ->get()->pluck('name')->all();
        }

        return $companyArray;
    }
}
