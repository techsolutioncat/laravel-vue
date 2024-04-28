<?php

namespace App\Imports;

use App\Company;
use App\Device;
use App\DeviceAssignment;
use App\DeviceState;
use App\DeviceType;
use App\Sim;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithProgressBar;

//use Maatwebsite\Excel\Concerns\ToModel;

class CompaniesImport implements ToCollection, WithProgressBar
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $count = 0;
        foreach($rows as $row) {
            $count++;
            if ($count<2) continue;

            try {
                $company = Company::query()->updateOrCreate([
                    'name' => $row[1],
                ],[
                    'phone' => $row[2],
                    'postcode' => $row[3],
                    'address' => $row[4],
                    'owner_name' => $row[5],
                    'owner_mail' => $row[6],
                    'sb_payment_no' => $row[7],
                    'message_enabled' => $row[8] == '有効'? 1 : 0,
                ]);

                User::query()->updateOrCreate([
                    'login_id' => $row[0],
                    'name' => $row[1],
                    'company_id' => $company->id,
                    'password' => Hash::make('password'),
                    'user_role_id' => 3,
                    'enabled' => 1,
                ]);
            } catch (\PDOException $e) {
            }
        }
    }


    public function chunkSize(): int
    {
        return 100;
    }
}
