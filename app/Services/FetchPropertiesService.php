<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Http;

class FetchPropertiesService{

    protected $apiKey;
    protected $currentPage;
    protected $lastPage;
    protected $totalResult;
    protected $pageSize;

    public function __construct(){
        $this->apiKey = '2S7rhsaq9X1cnfkMCPHX64YsWYyfe1he';
        $this->currentPage = 0;
        $this->lastPage = null;
    }

    public function fetchProperties(){
        if($this->lastPage && $this->currentPage >= $this->lastPage){
            return true;
        }
        $this->currentPage++;
        $propertyCall = Http::get('https://trial.craig.mtcserver15.com/api/properties', [
            'api_key'       => $this->apiKey,
            'page[number]'  => $this->currentPage,
        ]);
        if($propertyCall->successful()){
            $data = $propertyCall->json();
            $this->currentPage = $data['current_page'];
            $this->lastPage = $data['last_page'];
            foreach($data['data'] as $propertyData){
                $ppTypeFound = PropertyType::select('id')->where('title', $propertyData['property_type']['title'])->first();
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
            // dd('success');
            return $this->fetchProperties();
        }else{
            return false;
        }
    }
    
}