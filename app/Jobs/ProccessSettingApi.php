<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessSettingApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $device_assignment_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($device_assignment_id)
    {
        $this->device_assignment_id = $device_assignment_id;
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
        $response = $client->request('post', 'setting',
            [
                'json' => [
                    'device_assignment_id' => $this->device_assignment_id,
                ]
            ]);
//        $response_body = (string)$response->getBody();
        if ($response->getStatusCode() == 200)
        {
        } else{
            $this->fail();
        }
    }
}
