<?php

namespace App\Exports;

use App\DeviceAssignment;
use App\Company;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Cell;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Protection;
use Illuminate\Support\Facades\Auth;

class DeviceExport implements FromCollection, WithEvents, WithColumnFormatting
{
    use Exportable, RegistersEventListeners;

    public function collection()
    {
        $started_at = $mount_no = $device_model = $sb_billing_number = $group_name = $company_name = $imei_number = $command_center = $msn = $receiver_number = $name = null;
        if (session('company_device_assignment_history')) {
            $started_at = session('company_device_assignment_history')['started_at'];
            $mount_no = session('company_device_assignment_history')['mount_no'];
            $device_model = session('company_device_assignment_history')['device_model'];
            $sb_billing_number = session('company_device_assignment_history')['sb_billing_number'];
            $group_name = session('company_device_assignment_history')['group_name'];
            $imei_number = session('company_device_assignment_history')['imei_number'];
            $command_center = session('company_device_assignment_history')['command_center'];
            $msn = session('company_device_assignment_history')['msn'];
            $receiver_number = session('company_device_assignment_history')['receiver_number'];
            $name = session('company_device_assignment_history')['name'] ?? null;
            $company_name = session('company_device_assignment_history')['company_name'] ?? null; 
        }
        $companyArray = Company::getCompanyList();
        $device_assignments = $this->search($companyArray, $started_at, $mount_no, $device_model, $sb_billing_number, $group_name, $company_name, $imei_number,
        $command_center, $msn, $receiver_number, $name);

        // $device_assignments = DeviceAssignment::all();
        //$device_assignments = DeviceAssignment::getAll();

        $titles = [
            '利用状況', '休止設定',
            '機種', 'IMEI番号', '架No', 'グループ名', '会社名',
            '端末電話番号', '端末電話番号名称', '端末発信設定番号', '端末発信設定番号名称',
            '着信可能設定01', '着信可能設定名称01', '着信可能設定02', '着信可能設定名称02',
            '着信可能設定03', '着信可能設定名称03', '着信可能設定04', '着信可能設定名称04',
            '着信可能設定05', '着信可能設定名称05', '着信可能設定06', '着信可能設定名称06',
            '着信可能設定07', '着信可能設定名称07', '着信可能設定08', '着信可能設定名称08',
            '着信可能設定09', '着信可能設定名称09', '着信可能設定10', '着信可能設定名称10',
            '定型文(緊急通報）', '定型文(緊急ブザー）', '定型文（バッテリー低下）', '定型文(電源OFF）',
        ];

        $device_assignments = $device_assignments->map(function($d){return $d->data();});

        $rows = $device_assignments->map(function($d) {
            $row []= ($d->ended_at == null) ? '利用中' : '利用停止';
            $row []= $d->rest ? '休止' : '-';
            $row []= $d->device_type->type;
            $row []= $d->device->imei;
            $row []= $d->mount_no;
            $row []= $d->device_group->name;
            $row []= $d->company->name;
            $row []= $d->sim->msn;
            $row []= $d->name;

            for($i=0; $i<=10; $i++)
            {
                if(is_object($d->device_phones[$i])){
                    $row []= $d->device_phones[$i]->phone;
                    $row []= $d->device_phones[$i]->name;
                }else{
                    $row []= '';
                    $row []= '';
                }
            }

            $row []= $d->emergency_call->message;
            $row []= $d->emergency_buzzer->message;
            $row []= $d->battery_low->message;
            $row []= $d->power_off->message;

            return $row;
        });

        $result = new Collection([
                $titles,
                $rows
            ]);

        return $result;
    }

    public static function afterSheet(AfterSheet $event)
    {
        $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
//        $event->sheet->protectCells('A1:ZZ100', 'password');
//        $event->sheet->getProtection()->setSheet(true);
//        $event->sheet->getStyle('A1:C100')->getProtection()->setLocked(false);
//        $event->sheet->getStyle('D1:D100')->getProtection()->setLocked(true);
//        $event->sheet->getStyle('E1:G100')->getProtection()->setLocked(false);
//        $event->sheet->getStyle('H1:H100')->getProtection()->setLocked(true);
//        $event->sheet->getStyle('I1:ZZ100')->getProtection()->setLocked(false);

        $event->sheet->styleCells(
            'A1:AI1',
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'ffcccccc']
                ],
            ]
        );
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'D' => '000000000000000',
            'E' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
            'T' => NumberFormat::FORMAT_TEXT,
            'V' => NumberFormat::FORMAT_TEXT,
            'X' => NumberFormat::FORMAT_TEXT,
            'Z' => NumberFormat::FORMAT_TEXT,
            'AB' => NumberFormat::FORMAT_TEXT,
            'AD' => NumberFormat::FORMAT_TEXT,
        ];
    }

    private function search($companyArray, $started_at, $mount_no, $device_model, $sb_billing_number, $group_name, $company_name, $imei_number,
                            $command_center, $msn, $receiver_number, $name, $garbage = null)
    {

        if ($garbage) {
            $query = DeviceAssignment::onlyTrashed();
        } else {
            $query = DeviceAssignment::query();
        }

        if (isset($started_at)) {
            $query->whereDate('started_at', $started_at);
        }

        if (isset($mount_no)) {
            $query->where('mount_no', 'LIKE', $mount_no);
        }

        if (isset($device_model)) {
            $query->whereHas('device.deviceType', function ($q) use ($device_model) {
                $q->where('type', $device_model);
            });
        }

        if (isset($sb_billing_number)) {
            $query->whereHas('company', function ($q) use ($sb_billing_number) {
                $q->where('sb_payment_no', $sb_billing_number);
            });
        }

        if (isset($companyArray))
            // $query->where('company_id', '=', $company_id);
            $query->whereIn('company_id', $companyArray);

        if (isset($group_name)) {
            $query->whereHas('deviceGroup', function ($q) use ($group_name) {
                $q->where('name', $group_name);
            });
        }

        if (isset($company_name)) {
            $query->whereHas('company', function ($q) use ($company_name) {
                $q->
                where('name', $company_name)->orWhere('name', "like", "%" . $company_name . "%");
            });
        }

        if (isset($imei_number)) {
            $query->whereHas('device', function ($q) use ($imei_number) {
                $q->where('imei', $imei_number);
            });
        }

        if (isset($msn)) {
            $query->whereHas('sim', function ($q) use ($msn) {
                $q->where('msn', $msn);
            });
        }

        if (isset($receiver_number)) {
            $query->whereHas('phones', function ($q) use ($receiver_number) {
                $q->where('phone', $receiver_number);
        });
        }

        if (isset($command_center)) {
            $query->whereHas('phones', function ($q) use ($command_center) {
                $q->where(['phone' => $command_center, 'auth_no' => 0]);
            });
        }

        if (isset($name)) {
            $query->where('name', '=', $name);
        }

        if(Auth::user()->userRole->role == 'user')
        {
            $query->where('company_id', '=', Auth::user()->company_id);
        }

        session(['company_device_assignment_history' => [
            'started_at' => $started_at,
            'mount_no' => $mount_no,
            'device_model' => $device_model,
            'sb_billing_number' => $sb_billing_number,
            'group_name' => $group_name,
            'imei_number' => $imei_number,
            'command_center' => $command_center,
            'msn' => $msn,
            'receiver_number' => $receiver_number,
            'name' => $name
        ]]);

        return $query->with(['sim', 'device.deviceType', 'deviceGroup', 'company', 'phones'])->get();
    }
}
