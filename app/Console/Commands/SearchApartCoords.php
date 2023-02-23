<?php

namespace App\Console\Commands;

use App\Traits\Geocoder\HereGeocoder;
use Illuminate\Console\Command;

class SearchApartCoords extends Command
{
    use HereGeocoder;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocoder_here:search_coords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ищет координаты объекта на основе адреса';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->searchCoordsByAddress();
        return Command::SUCCESS;
    }
}
