<?php

namespace App\Jobs;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchPropertyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $apiKey;
    protected $currentPage;
    /**
     * Create a new job instance.
     */
    public function __construct($currentPage)
    {
        $this->apiKey = '2S7rhsaq9X1cnfkMCPHX64YsWYyfe1he';
        $this->currentPage = $currentPage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $propertyCall = Http::get('https://trial.craig.mtcserver15.com/api/properties', [
            'api_key' => $this->apiKey,
            'page[number]' => $this->currentPage,
        ]);
        if($propertyCall->successful()){
            $data = $propertyCall->json();
            $this->currentPage = $data['current_page'];
            foreach($data['data'] as $propertyData){
                $ppTypeFound = PropertyType::where('title', $propertyData['property_type']['title'])->first();
                if(!$ppTypeFound){
                    $new_pp_Type = PropertyType::create([
                        'title'         => $propertyData['property_type']['title'],
                        'description'   => $propertyData['property_type']['description'],
                    ]);
                }
                $propertyTypeId = $ppTypeFound ? $ppTypeFound->id : $new_pp_Type->id;
                Property::create([
                    'county' => $propertyData['county'],
                    'country' => $propertyData['country'],
                    'town' => $propertyData['town'],
                    'description' => $propertyData['description'],
                    'displayableAddress' => $propertyData['address'],
                    'image' => $propertyData['image_full'],
                    'thumnail' => $propertyData['image_thumbnail'],
                    'latitude' => $propertyData['latitude'],
                    'longitude' => $propertyData['longitude'],
                    'num_bedrooms' => $propertyData['num_bedrooms'],
                    'num_bathrooms' => $propertyData['num_bathrooms'],
                    'price' => $propertyData['price'],
                    'property_type_id' => $propertyTypeId,
                    'type' => $propertyData['type']
                ]);
            }
        }
    }
}
