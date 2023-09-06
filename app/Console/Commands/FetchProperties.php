<?php

namespace App\Console\Commands;

use App\Services\FetchPropertiesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:properties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch properites';

    /**
     * Execute the console command.
     */
    public function handle(FetchPropertiesService $fetchPropertiesService){
        $callFetchApi = $fetchPropertiesService->fetchProperties();
        if($callFetchApi){
            $this->info('properites fetched successfully');
        }else{
            $this->error('Failed to fetched successfully');
        }
    }
}
