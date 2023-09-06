@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6 px-4">
        <h1 class="text-2xl font-semibold">Property List</h1>
        @if(session('alert'))
            <div id="alertmsg" class="w-full bg-red-300 my-2 py-2 px-2 rounded">{{session('alert')}}</div>
        @endif
        

        <form action="{{ route('properties.index') }}" method="GET" class="mt-4">
            <div class="flex flex-wrap">
                <div class="w-1/6">
                    <div class="px-2">
                        <label class="text-sm mb-1 block" for="name">Name</label>
                        <input type="text" name="name" value="{{$searchQuery['name']}}" class="w-full border border-gray-400 px-4 py-1" placeholder="Search by Country Name, Town,">
                    </div>
                </div>
                <div class="w-1/6">
                    <div class="px-2">
                        <label class="text-sm mb-1 block" for="bedrooms">Number of Bedrooms</label>
                        <input type="number" name="bedrooms" value="{{$searchQuery['bedrooms']}}" class="w-full border border-gray-400 px-4 py-1" placeholder="5">
                    </div>
                </div>
                <div class="w-1/6">
                    <div class="px-2">
                        <label class="text-sm mb-1 block" for="price">Price</label>
                        <input type="number" name="price" value="{{$searchQuery['price']}}" class="w-full border border-gray-400 px-4 py-1" placeholder="5000">
                    </div>
                </div>
                <div class="w-1/6">
                    <div class="px-2">
                        <label class="text-sm mb-1 inline-flex items-center mx-2">Type</label>
                        <div class="flex">
                            <label class="text-sm mb-1 inline-flex items-center mx-2">
                                <input type="radio" class="form-radio text-blue-500" name="type" value="" checked>
                                <span class="ml-2">Any</span>
                            </label>
                            <label class="text-sm mb-1 inline-flex items-center mx-2">
                                <input type="radio" class="form-radio text-blue-500" name="type" value="rent" {{ $searchQuery['type'] == 'rent' ? 'checked' : '' }}>
                                <span class="ml-2">Rent</span>
                            </label>            
                            <label class="text-sm mb-1 inline-flex items-center mx-2">
                                <input type="radio" class="form-radio text-blue-500" name="type" value="sale" {{ $searchQuery['type'] == 'sale' ? 'checked' : '' }}>
                                <span class="ml-2">Sale</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-1/6">
                    <div class="px-2">
                        <label class="text-sm mb-1 block" for="typeid">Property Type</label>
                        <select name="typeid" id="" class="w-full border border-gray-400 px-4 py-1">
                            <option value="0" selected>All Property Type</option>
                            @forelse ($propertyTypes as $pType)
                                @if($searchQuery['typeid'] == $pType->id)
                                    <option value="{{$pType->id}}" selected>{{$pType->title}}</option>
                                @else
                                    <option value="{{$pType->id}}">{{$pType->title}}</option>
                                @endif
                            @empty
                                <option value="0" selected>All Property Type</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="w-1/6">
                    <button type="submit" class="w-full mt-4 px-4 py-2 bg-blue-500 text-white">Search</button>
                </div>
            </div>
        </form>
        <table class="min-w-full overflow-scroll table-auto mt-8 text-sm">
            <thead class="text-left">
                <tr>
                    <th scope="col" class="px-4 py-2 border">#</th>
                    <th scope="col" class="px-4 py-2 border">County</th>
                    <th scope="col" class="px-4 py-2 border">Country</th>
                    <th scope="col" class="px-4 py-2 border">Town</th>
                    <th scope="col" class="px-4 py-2 border">Description</th>
                    <th scope="col" class="px-4 py-2 border">displayableAddress</th>
                    <th scope="col" class="px-4 py-2 border">Image</th>
                    <th scope="col" class="px-4 py-2 border">Thumnail</th>
                    <th scope="col" class="px-4 py-2 border">Latitude/Longitude</th>
                    <th scope="col" class="px-4 py-2 border">No of Bedrooms</th>
                    <th scope="col" class="px-4 py-2 border">No of Bathrooms</th>
                    <th scope="col" class="px-4 py-2 border">Price</th>
                    <th scope="col" class="px-4 py-2 border">Property Type</th>
                    <th scope="col" class="px-4 py-2 border">Type</th>
                    <th scope="col" class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($properties as $key => $property)
                <tr>
                    <td class="px-4 py-2 border">{{ $key+1 }}</td>
                    <td class="px-4 py-2 border">{{ $property->county }}</td>
                    <td class="px-4 py-2 border">{{ $property->country }}</td>
                    <td class="px-4 py-2 border">{{ $property->town }}</td>
                    <td class="px-4 py-2 border">{{ substr($property->description, 0, 15) }} ...</td>
                    <td class="px-4 py-2 border">{{ $property->displayableAddress }}</td>
                    <td class="px-4 py-2 border"><img width="40" src="{{$property->image}}" alt=""></td>
                    <td class="px-4 py-2 border"><img width="40" src="{{$property->thumnail}}" alt=""></td>
                    <td class="px-4 py-2 border">{{ $property->latitude }} <br>{{$property->longitude }}</td>
                    <td class="px-4 py-2 border">{{ $property->num_bedrooms }}</td>
                    <td class="px-4 py-2 border">{{ $property->num_bathrooms }}</td>
                    <td class="px-4 py-2 border">{{ $property->price }}</td>
                    <td class="px-4 py-2 border">{{ $property->propertyType?->title }}</td>
                    <td class="px-4 py-2 border">{{ $property->type }}</td>
                    <td class="px-4 py-2 border flex">
                        <a href="{{route('properties.edit', $property->id)}}" class="my-2 btn px-2 py-1 bg-blue-600 hover:bg-blue-800 text-white rounded">Edit</a>
                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="my-2 btn ml-1 px-2 py-1 bg-red-600 hover:bg-red-800 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $properties->links() }}
        </div>
    </div>
    <script>
        const alertmsg = document.getElementById('alertmsg')
        setTimeout(() => {
            alertmsg.setAttribute('hidden', true)
        }, 3000);
    </script>
@endsection
