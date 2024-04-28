<?php

namespace App\Console\Commands;

use App\DeviceAssignment;
use App\DeviceSetting;
use App\Imports\CompaniesImport;
use App\Imports\DeviceSignalsImport;
use App\Imports\SimsImport;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendCommand extends Command
{
    protected $signature = 'send:command';

    protected $description = 'send command';

    public function handle()
    {
        $this->output->title('Starting send command');

        //deviceassignmentsに変更
        $devices = DeviceAssignment::query()
            ->whereNULL('applied_at')
            ->get();

        foreach ($devices as $device) {
            $this->SendPhoneCommands($device);
        }

        $this->output->success('Sending successful');
    }

    public function SendPhoneCommands($device_assignment)
    {
        $imei = $device_assignment->device->imei;
        $iccid = $device_assignment->sim->iccid;
        $phones = $device_assignment->phones;
        for($i=0; $i<11; $i++) {
            $command = GetPhoneCommand($i, $phones[$i]->phone);
            if ($this->send($imei, $iccid, $command)) {
                $device_assignment->applied_at = Carbon::now();
                $device_assignment->save();
            } else {
                // 電話番号の割り当てに失敗
            }
            sleep(5);
        }
    }

    public function GetPhoneCommand($no, $phone)
    {
        $no = $no == 0 ? 11 : $no;
        $command = ':123456A'.$no.','.$phone;
        return $command;
    }

    public function send($imei, $iccid, $command)
    {
        $url = "http://gps.cspemerge.mobi:51600";
        $data = [
            'iccid'=> $iccid,
            'imei' => $imei,
            'command' => $command
        ];

        $headers = array(
            'Content-type: Application/json; charset=UTF8',
        );

        if ( !function_exists( 'curl_version' ) ) {
            return false;
        }

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $data = curl_exec( $ch );

        $response = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

        curl_close( $ch );

        if ( $response === 200 ) {
            $this->output->writeln($response);
            return true;
        } else {
            $this->output->writeln($response);
            return false;
        };
    }
}
