<?php

namespace App\Imports;

use App\DeviceSignal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithProgressBar;


class DeviceSignalsImport implements ToCollection, WithProgressBar
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

            $device_signal = DeviceSignal::query()
                ->UpdateOrCreate([
                    'signal_int' => $row[1],
                    ],[
                    'response' => $row[0],
                    'description' => $row[2],
                    ]);
        }
    }


    public function chunkSize(): int
    {
        return 100;
    }
}
