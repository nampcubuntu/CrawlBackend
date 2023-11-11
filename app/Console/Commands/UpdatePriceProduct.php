<?php

namespace App\Console\Commands;

use App\Http\Controllers\ConfigController;
use Illuminate\Console\Command;

class UpdatePriceProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-price-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

}
