<?php

namespace App\Jobs;

use App\Http\Controllers\ConfigController;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $backoff = 2;
    public $timeout = 60;

    public $url;
    public $config;
    public $options;
    public $controller;


    /**
     * Create a new job instance.
     */
    public function __construct(ConfigController $controller,$config,$url,array $options)
    {
 
        $this->url = $url;
        $this->options = $options;
        $this->config = $config;
        $this->controller = $controller;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $this->controller->getConfigTableInfo($this->config,$this->url,$this->options);
    }
}
