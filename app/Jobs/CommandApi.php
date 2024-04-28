<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CommandApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $msn;
    protected $command;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msn, $command)
    {
        $this->msn = $msn;
        $this->command = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = config('services.setting.url');
        $port = config('services.setting.port');

        $client = new Client([
            'base_uri' => $url.':'.$port,
        ]);
        $response = $client->request('post', 'sms/command',
            [
                'json' => [
                    'msn' => $this->msn,
                    'command' => $this->command,
                ]
            ]);
//        $response_body = (string)$response->getBody();
        if ($response->getStatusCode() == 200)
        {
        } else {
            $this->fail();
        }
    }
}
