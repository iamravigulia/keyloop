<?php

namespace App\Http\Controllers;

use App\Console\Commands\FetchProperties;
use App\Services\FetchPropertiesService;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image as Image;

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
        $propertiesQuery = Property::with('propertyType:title,id');
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

    public function edit($id = null){
        $propertyTypes = PropertyType::select('id', 'title')->get();
        $property = Property::with('propertyType:title,id')->where('id', $id)->first();
        if($property){
            return view('property.edit', compact('property', 'propertyTypes'));
        }
        return view('property.edit', compact('property', 'propertyTypes'));
    }

    public function destroy($id){
        $property = Property::findOrFail($id);
        $property->delete();
        return redirect('/properties/index')->with('alert', 'Property deleted successfully');
    }

    public function update(Request $request, $id = null){
        $property = Property::where('id', $id)->first();
        $validateBox = array();
        if(!$property){
            $property = new Property();
            $validateBox['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }else{
            $validateBox['image'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }
        
        $validateBox['county']                = 'required';
        $validateBox['country']               = 'required';
        $validateBox['town']                  = 'required';
        $validateBox['description']           = 'required';
        $validateBox['displayableAddress']    = 'required';
        $validateBox['latitude']              = 'required';
        $validateBox['longitude']             = 'required';
        $validateBox['num_bedrooms']          = 'required';
        $validateBox['num_bathrooms']         = 'required';
        $validateBox['price']                 = 'required';
        $validateBox['property_type_id']      = 'required';
        $validateBox['type']                  = 'required';

        $request->validate($validateBox);

        $uploadedImage = $request->file('image');
        if($uploadedImage){
            $path = public_path('storage');
            $filename = uniqid() . "." . $uploadedImage->extension();
            $thumb_filename = uniqid() . "." . $uploadedImage->extension();
    
            Image::make($uploadedImage)->save($path . '/' . $filename);
            Image::make($uploadedImage)->resize(100, 100)->save($path . '/' . $thumb_filename);
            $fullImage = URL('/storage') . '/' . $filename;
            $thumbnail = URL('/storage') . '/' . $thumb_filename;

            $property->image            = $fullImage ?? $property->image;
            $property->thumnail         = $thumbnail ?? $property->thumnail;

        }

        // dd($fullImage, $thumbnail);

        $property->county           = $request->county;
        $property->country          = $request->country;
        $property->town             = $request->town;
        $property->description      = $request->description;
        $property->displayableAddress = $request->displayableAddress;
        $property->latitude         = $request->latitude;
        $property->longitude        = $request->longitude;
        $property->num_bedrooms     = $request->num_bedrooms;
        $property->num_bathrooms    = $request->num_bathrooms;
        $property->price            = $request->price;
        $property->property_type_id = $request->property_type_id;
        $property->type             = $request->type;
        $property->save();

        if($id){
            return redirect('/properties/index')->with('success', 'Property updated successfully');
        }
        return redirect('/properties/index')->with('success', 'Property added successfully');
    }
}
