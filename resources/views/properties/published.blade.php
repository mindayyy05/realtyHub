<!-- resources/views/properties/published.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Published Properties') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Sub-Navigation Bar -->
            <div class="bg-gray-100 p-6 rounded-lg mb-6 shadow-md">
                <div class="flex justify-center space-x-8">
                    <div class="relative">
                        <a href="{{ route('properties.listed') }}"
                            class="text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out text-lg font-medium">
                            Listed Properties
                        </a>
                    </div>
                    <a href="{{ route('listings.published') }}"
                        class="text-purple-600 bg-white py-2 px-4 rounded-lg transition duration-300 ease-in-out text-lg font-medium shadow-md">
                        Published Properties
                    </a>
                    <a href="{{ route('listings.pending') }}"
                        class="text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out text-lg font-medium">
                        Pending Properties
                    </a>
                </div>

            </div>

            <div class="flex">

                <!-- Main Content -->
                <div class="w-3/4 ml-4">
                    <!-- Cards for each listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($listings as $listing)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col">
                                <!-- Property Image -->
                                <div class="relative">
                                    @if (!empty($listing->images))
                                        @php
                                            $images = json_decode($listing->images, true);
                                        @endphp
                                        @if (isset($images[0]))
                                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Property Image"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/400" alt="Placeholder Image"
                                                class="w-full h-48 object-cover">
                                        @endif
                                    @else
                                        <img src="https://via.placeholder.com/400" alt="Placeholder Image"
                                            class="w-full h-48 object-cover">
                                    @endif
                                </div>

                                <!-- Property Details -->
                                <div class="p-4 flex-1">
                                    <h3 class="text-xl font-semibold mb-2">{{ $listing->title }}</h3>
                                    <p class="text-gray-600 mb-2">Price: ${{ number_format($listing->price, 2) }}</p>
                                    <p class="text-gray-600 mb-2">{{ $listing->address }}, {{ $listing->city }},
                                        {{ $listing->state }} {{ $listing->zip_code }}</p>
                                    <p class="text-gray-800 mb-2">{{ $listing->description }}</p>
                                    <p class="text-gray-500 text-sm mb-4">
                                        @if ($listing->is_for_sale)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">For
                                                Sale</span>
                                        @endif
                                        @if ($listing->is_for_rent)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">For
                                                Rent</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
