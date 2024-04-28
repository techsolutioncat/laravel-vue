<?php

namespace App\Imports;

use App\Device;
use App\DeviceAssignment;
use App\DeviceState;
use App\DeviceType;
use App\Sim;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithProgressBar;


class SimsImport implements ToCollection, WithProgressBar
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

            $sim = Sim::query()
                ->UpdateOrCreate([
                    'iccid' => $row[1],
                    ],[
                    'msn' => $row[2],
                    ]);
        }
    }


    public function chunkSize(): int
    {
        return 100;
    }
}
