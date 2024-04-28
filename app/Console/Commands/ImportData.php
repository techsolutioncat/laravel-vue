<?php

namespace App\Console\Commands;

use App\Imports\CompaniesImport;
use App\Imports\DeviceSignalsImport;
use App\Imports\SimsImport;
use Illuminate\Console\Command;

class ImportData extends Command
{
    protected $signature = 'import:data';

    protected $description = 'excel importer';

    public function handle()
    {
        $this->output->title('Starting import');
//        (new CompaniesImport)->withOutput($this->output)->import('companies.xlsx');
        (new SimsImport)->withOutput($this->output)->import('sims.xlsx');
//        (new DeviceSignalsImport())->withOutput($this->output)->import('device_signals.xlsx');
        $this->output->success('Import successful');
    }
}
