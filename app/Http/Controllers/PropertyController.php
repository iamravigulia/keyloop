<?php

namespace App\Http\Controllers;

use App\Console\Commands\FetchProperties;
use App\Services\FetchPropertiesService;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    public function index(Request $request){
        $searchQuery = [
            'name' => $request->name ?? null,
            'bedrooms' => $request->bedrooms ?? null,
            'price' => $request->price ?? null,
            'typeid' => $request->typeid ?? null,
            'type' => $request->type ?? null,
        ];
        $propertyTypes = PropertyType::select('id', 'title')->get();
        // dd($searchQuery ?? $request->all());
        $propertiesQuery = Property::with('propertyType');
        if($searchQuery['name']){
            $propertiesQuery = $propertiesQuery->where('county', 'LIKE', '%'.$searchQuery['name'].'%')
            ->orWhere('country', 'LIKE', '%'.$searchQuery['name'].'%')
            ->orWhere('town', 'LIKE', '%'.$searchQuery['name'].'%');
        }
        if($searchQuery['bedrooms']){
            $propertiesQuery = $propertiesQuery->where('num_bedrooms', (int)$searchQuery['bedrooms']);
        }
        if($searchQuery['price']){
            $propertiesQuery = $propertiesQuery->where('price', (int)$searchQuery['price']);
        }
        if($searchQuery['typeid']){
            $propertiesQuery = $propertiesQuery->where('property_type_id', (int) $searchQuery['typeid']);
        }
        if($searchQuery['type']){
            $propertiesQuery = $propertiesQuery->where('type', $searchQuery['type']);
        }
        $properties = $propertiesQuery->paginate(10);
        return view('property.index', compact('properties', 'searchQuery', 'propertyTypes'));
    }

    public function edit($id){
        $propertyTypes = PropertyType::select('id', 'title')->get();
        $property = Property::findOrFail($id);
        return view('property.edit', compact('property', 'propertyTypes'));
    }
}
