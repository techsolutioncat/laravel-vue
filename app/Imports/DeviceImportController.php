<?php

namespace App\Imports;

use App\Company;
use App\Device;
use App\DeviceAssignment;
use App\DeviceGroup;
use App\DeviceType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DeviceAssignmentController;
use App\Sim;
use App\Exceptions\ImportException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class DeviceImportController extends Controller implements ToCollection
{
    use Importable;

    protected $deviceAssignmentController;

    public function __construct(DeviceAssignmentController $deviceAssignmentController)
    {
        $this->deviceAssignmentController = $deviceAssignmentController;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        try {
            foreach($rows as $key => $row) {

                if($row[0] == '') break;

                $data['row'] = $key;
                $data['state'] = $row[0];
                $data['rest'] = $row[1] === '休止中';
                $data['type'] = $row[2];
                $data['imei'] = '' . $row[3];
                $data['mount_no'] = '' . $row[4];
                $data['group_name'] = $row[5];
                $data['company_name'] = $row[6];
                $data['msn'] = '' . $row[7];
                $data['name'] = $row[8];
                $data['phones'] = [];
                for ($i = 0; $i <= 10; $i++) {
                    $data['phones'][] = ['phone' => '', 'name' => '', 'auth_no' => ''];
                    $data['phones'][$i]['phone'] = '' . $row[9 + $i * 2];
                    $data['phones'][$i]['name'] = $row[10 + $i * 2];
                    $data['phones'][$i]['auth_no'] = $i;
                }
                $data['emergency_call'] = $row[31];
                $data['emergency_buzzer'] = $row[32];
                $data['battery_low'] = $row[33];
                $data['power_off'] = $row[34];

                $this->updateOrCreate($data, $row);
            }
        }
        catch(ModelNotFoundException $e)
        {
            throw $e;
        }
        catch(ImportException $e)
        {
            throw $e;
        }
    }

    function updateOrCreate($data, $row){
        $indexJp = '';
        try {
            if ($data['imei'] == "IMEI番号")
                return;
            $indexJp = '端末タイプ';
            $device_type = DeviceType::query()
                ->firstOrCreate(['type' => $data['type']], []);

            $device_type_id = $device_type->id;
            //new requirement 0215;

            if ($data['msn'] == "") {
                $data['sim_id'] = null;
            } else {
                $indexJp = '端末電話番号';
                $sim = Sim::query()
                ->where('msn', $data['msn'])
                ->firstOrFail();
                $data['sim_id'] = $sim->id;
            }
            //dd($data);
            $indexJp = "端末IMEI";
            $device = Device::query()
                ->where('imei', $data['imei'])
                ->firstOrFail();
            $data['device_id'] = $device->id;

            Device::query()->where('imei', $data['imei'])->update(['device_type_id' => $device_type_id]);

            // $indexJp = '端末IMEIと端末電話番号の組み合わせ';
            // $device_sim = DeviceSim::query()
            //     ->where('device_imei', $device->imei)
            //     ->where('sim_iccid', $sim->iccid)
            //     ->firstOrFail();


            // $indexJp = '端末IMEIと端末電話番号の組み合わせ';
            // $device_sim = DeviceSim::query()
            //         ->where('device_imei', $device->imei)
            //         ->firstOrFail();
            //dd($data);
            $indexJp = '会社名';
            $company = Company::query()
                ->where('name',  $data['company_name'])
                ->firstOrFail();

            $indexJp = 'グループ名';
            $device_group = DeviceGroup::query()
                ->firstOrCreate(['name' => $data['group_name'], 'company_id' => $company->id],[]);


            //$data['device_sim_id'] = $device_sim->id;
            $data['device_group_id'] = $device_group->id;
            $data['company_id'] = $company->id;

            // check if the current info is under current user's control
            $companyIDArray = Company::getCompanyList();

            if (Auth::user()->isAdmin()) {

            } elseif (in_array($data['company_id'], $companyIDArray)) {
            } elseif (Auth::user()->company_id == $data['company_id']) {
            } else {
                $indexJp = "権限外の会社をインポートすることができません。";
                throw new ModelNotFoundException;
            }

            $device_assignment = DeviceAssignment::query()
                ->whereHas('device', function ($q)use($data){
                    $q->where('imei', $data['imei']);
                })
                ->first();

            // if device status is using now then update
            // else if that device is not exist then create
            //dd($device_assignment);
            if ($device_assignment == null){

                $this->deviceAssignmentController->create($data);
            }
            else {

                $this->deviceAssignmentController->update($device_assignment->id, $data);
            }
        } catch (ModelNotFoundException $e) {
            throw new ImportException($indexJp, $data['row'], $row);
        } catch (ImportException $e)
        {

        }
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
