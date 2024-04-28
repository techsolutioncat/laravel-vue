<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\CarbonImmutable;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class CompanyController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $registered_at = $request->get('registered_at', null);
        $sb_payment_no = $request->get('sb_payment_no', '%');
        $company_name = $request->get('company_name', '%');
        $company_phone = $request->get('company_phone', '%');



        $query = Company::query();
        $query->whereNotIn('id', [1]);

        if ($registered_at != null) {
            $start = (new CarbonImmutable())->setDateFrom($registered_at)->startOfDay();
            $end = $start->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $query->where('sb_payment_no', 'LIKE', $sb_payment_no);
        $query->where('name', 'LIKE', $company_name);
        $query->where('phone', 'LIKE', $company_phone);

        $companies = $query->paginate($perPage);
        $companies->data = $companies->map(function ($company) {
            return $company->data();
        });

        // 表示
        return response()->json($companies);
    }

    protected function validator(array $data)
    {
        try {
            return Validator::make($data, [
                'name' => ['required', 'string'],
                'phone' => ['required', 'numeric'],
                'postcode' => ['required', 'numeric'],
                'address' => ['required', 'string'],
                'owner_name' => ['required', 'string'],
                'owner_mail' => ['required', 'email'],
                'sb_payment_no' => ['required', 'digits:10'],
                'login_id' => ['required', 'string|min:4|max:18'],
                'password' => ['min:4|max:18'],
            ]);
        } catch( \InvalidArgumentException $e)
        {
            Log::Debug('Transaction Error: '. print_r($e, true));
            throw $e;
        }
    }

}
