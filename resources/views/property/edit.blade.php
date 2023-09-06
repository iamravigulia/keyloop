@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-semibold">Edit Property</h1>

        <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="county" class="block text-gray-700 font-bold">County:</label>
                <input type="text" name="county" id="county" value="{{ old('county', $property->county) }}" class="form-input">
            </div>

            <div class="mb-4">
                <label for="country" class="block text-gray-700 font-bold">Country:</label>
                <input type="text" name="country" id="country" value="{{ old('country', $property->country) }}" class="form-input">
            </div>

            <!-- Add more input fields for other property details -->

            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Property</button>
            </div>
        </form>
    </div>
@endsection
