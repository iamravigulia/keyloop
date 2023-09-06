@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6 px-8">
        <h1 class="text-2xl font-semibold">{{ $property ? 'Edit' : 'Create' }} Property</h1>
        <a href="{{route('properties.index')}}" class="px-2 py-1 bg-blue-400 text-white rounded inline-block my-2">back</a>
        <form action="{{ route('properties.update', $property?->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="flex flex-wrap">
                <div class="w-full my-2" hidden>
                    @forelse ($errors->all() as $item)
                        <div class="text-sm my-2 px-2 py-1 text-white bg-red-400 rounded">{{$item}}</div>
                    @empty
                        
                    @endforelse
                </div>
                <div class="w-1/2">
                    <div class="px-2">
                        <div class="mb-4">
                            <label class="text-sm mb-1 block" for="typeid">Property Type</label>
                            <select name="property_type_id" id="" class="w-full border border-gray-400 px-4 py-1">
                                <option value="" disabled selected>All Property Type</option>
                                @forelse ($propertyTypes as $pType)
                                    <option value="{{$pType->id}}" {{ $property?->propertyType->id === $pType->id ? 'selected' : '' }}>{{$pType->title}}</option>
                                @empty
                                    <option value="0" selected>All Property Type</option>
                                @endforelse
                            </select>
                            @error('property_type_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="county" class="block text-gray-700 font-bold capitalize">county:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="county" id="county" placeholder="county" value="{{ old('county', $property?->county) }}">
                            @error('county')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="country" class="block text-gray-700 font-bold capitalize">country:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="country" id="country" placeholder="country" value="{{ old('country', $property?->country) }}">
                            @error('country')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="town" class="block text-gray-700 font-bold capitalize">town:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="town" id="town" placeholder="town" value="{{ old('town', $property?->town) }}">
                            @error('town')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror                            
                        </div>
                        <div class="mb-4">
                            <label for="displayableAddress" class="block text-gray-700 font-bold capitalize">displayableAddress:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="displayableAddress" id="displayableAddress" placeholder="displayableAddress" value="{{ old('displayableAddress', $property?->displayableAddress) }}">
                            @error('displayableAddress')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold capitalize">image:</label>
                            <input type="file" accept="image/*" class="border border-gray-600 py-1 px-1 w-full rounded" name="image" id="image">
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="px-2">
                        <div class="mb-4">
                            <label for="latitude" class="block text-gray-700 font-bold capitalize">latitude:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="latitude" id="latitude" placeholder="-75.5130430" value="{{ old('latitude', $property?->latitude) }}">
                            @error('latitude')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label for="longitude" class="block text-gray-700 font-bold capitalize">longitude:</label>
                            <input type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="longitude" id="longitude" placeholder="102.8216490" value="{{ old('longitude', $property?->longitude) }}">
                            @error('longitude')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label for="num_bedrooms" class="block text-gray-700 font-bold capitalize">num_bedrooms:</label>
                            {{-- <input type="number" class="border border-gray-600 py-1 px-1 w-full rounded" name="num_bedrooms" id="num_bedrooms" placeholder="3" value="{{ old('num_bedrooms', $property?->num_bedrooms) }}"> --}}
                            <select name="num_bedrooms" id="" class="border border-gray-600 py-1 px-1 w-full rounded">
                                @for ($i = 1; $i <= 15; $i++)
                                <option {{ $property?->num_bedrooms == $i ? 'selected' : '' }} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @error('num_bedrooms')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label for="num_bathrooms" class="block text-gray-700 font-bold capitalize">num_bathrooms:</label>
                            {{-- <input type="number" class="border border-gray-600 py-1 px-1 w-full rounded" name="num_bathrooms" id="num_bathrooms" placeholder="2" value="{{ old('num_bathrooms', $property?->num_bathrooms) }}"> --}}
                            <select name="num_bathrooms" id="" class="border border-gray-600 py-1 px-1 w-full rounded">
                                @for ($i = 1; $i < 15; $i++)
                                <option {{ $property?->num_bathrooms == $i ? 'selected' : '' }} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @error('num_bathrooms')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-bold capitalize">price:</label>
                            <input type="number" class="border border-gray-600 py-1 px-1 w-full rounded" name="price" id="price" placeholder="33433" value="{{ old('price', $property?->price) }}">
                            @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4">
                            <label class="text-sm mb-1 inline-flex items-center mx-2">Type</label>
                            <div class="flex">
                                <label class="text-sm mb-1 inline-flex items-center mx-2">
                                    <input type="radio" class="form-radio text-blue-500" name="type" value="rent" {{ $property?->type == 'rent' ? 'checked' : '' }}>
                                    <span class="ml-2">Rent</span>
                                </label>            
                                <label class="text-sm mb-1 inline-flex items-center mx-2">
                                    <input type="radio" class="form-radio text-blue-500" name="type" value="sale" {{ $property?->type == 'sale' ? 'checked' : '' }}>
                                    <span class="ml-2">Sale</span>
                                </label>
                            </div>
                            @error('type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold capitalize">description:</label>
                        <textarea type="text" class="border border-gray-600 py-1 px-1 w-full rounded" name="description" placeholder="write description here" id="description">{{ old('description', $property?->description) }}</textarea>
                        @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">{{ $property ? 'Update' : 'Save' }} Property</button>
            </div>
        </form>
    </div>
@endsection
