<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Properties Listed') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Sub-Navigation Bar -->
            <div class="bg-gray-100 p-6 rounded-lg mb-6 shadow-md">
                <div class="flex justify-center space-x-8">
                    <div class="relative">
                        <a href="{{ route('properties.listed') }}"
                            class="text-purple-600 bg-white py-2 px-4 rounded-lg transition duration-300 ease-in-out text-lg font-medium shadow-md">
                            Listed Properties
                        </a>
                    </div>
                    <a href="{{ route('listings.published') }}"
                        class="text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out text-lg font-medium">
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
                <div class="w-full">
                    <!-- Cards for each listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($listings as $listing)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col"
                                id="listing-{{ $listing->id }}">
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
                                    <form id="edit-form-{{ $listing->id }}"
                                        action="{{ route('listings.update', $listing->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="edit-fields" data-id="{{ $listing->id }}" style="display:none;">
                                            <input type="text" name="title" value="{{ $listing->title }}"
                                                class="border p-2 w-full mb-2">
                                            <input type="text" name="price" value="{{ $listing->price }}"
                                                class="border p-2 w-full mb-2">
                                            <input type="text" name="property_type"
                                                value="{{ $listing->property_type }}" class="border p-2 w-full mb-2">
                                            <input type="number" name="bedrooms" value="{{ $listing->bedrooms }}"
                                                class="border p-2 w-full mb-2">
                                            <input type="number" name="bathrooms" value="{{ $listing->bathrooms }}"
                                                class="border p-2 w-full mb-2">
                                            <textarea name="description" class="border p-2 w-full mb-2">{{ $listing->description }}</textarea>
                                        </div>

                                        <div class="view-fields" data-id="{{ $listing->id }}">
                                            <h3 class="text-xl font-semibold mb-2">{{ $listing->title }}</h3>
                                            <p class="text-gray-600 mb-2"><strong>Price:</strong>
                                                ${{ number_format($listing->price, 2) }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Property Type:</strong>
                                                {{ $listing->property_type }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Bedrooms:</strong>
                                                {{ $listing->bedrooms }}
                                            </p>
                                            <p class="text-gray-600 mb-2"><strong>Bathrooms:</strong>
                                                {{ $listing->bathrooms }}
                                            </p>
                                            <p class="text-gray-600 mb-2"><strong>Garages:</strong>
                                                {{ $listing->garages }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Land Size:</strong>
                                                {{ $listing->land_size }}
                                                sqft</p>
                                            <p class="text-gray-600 mb-2"><strong>House Size:</strong>
                                                {{ $listing->house_size }} sqft</p>
                                            <p class="text-gray-600 mb-2"><strong>Price per sqft:</strong>
                                                ${{ number_format($listing->price_per_sqft, 2) }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Address:</strong>
                                                {{ $listing->street_address }}, {{ $listing->city }},
                                                {{ $listing->state }}
                                                {{ $listing->zip_code }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Latitude:</strong>
                                                {{ $listing->latitude }}
                                            </p>
                                            <p class="text-gray-600 mb-2"><strong>Longitude:</strong>
                                                {{ $listing->longitude }}
                                            </p>
                                            <p class="text-gray-800 mb-2"><strong>Description:</strong>
                                                {{ $listing->description }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Real Estate Agent:</strong>
                                                {{ $listing->real_estate_agent }}</p>
                                            <p class="text-gray-600 mb-2"><strong>Negotiable:</strong>
                                                {{ $listing->is_negotiable ? 'Yes' : 'No' }}</p>
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
                                            <p class="text-gray-600 mb-2"><strong>Features:</strong>
                                                {{ $listing->features }}
                                            </p>
                                            <p class="text-gray-600 mb-2"><strong>User ID:</strong>
                                                {{ $listing->user_id }}</p>
                                        </div>

                                        <!-- Save and Cancel Buttons (Hidden Initially) -->
                                        <!-- Save and Cancel Buttons (Hidden Initially) -->
                                        <div class="edit-actions" data-id="{{ $listing->id }}" style="display:none;">
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg">Save</button>
                                            <button type="button" onclick="cancelEdit({{ $listing->id }})"
                                                class="px-4 py-2 bg-gray-600 text-white rounded-lg">Cancel</button>
                                        </div>

                                    </form>
                                </div>

                                <!-- Publish, Edit, and Delete Buttons -->
                                <div class="p-4 border-t border-gray-200 flex justify-center space-x-4">
                                    <form action="{{ route('listings.publish', $listing->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-black rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 ease-in-out">
                                            Publish
                                        </button>
                                    </form>

                                    <!-- Edit Button -->
                                    <button type="button" onclick="editListing({{ $listing->id }})"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-300 ease-in-out">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('listings.destroy', $listing->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-300 ease-in-out">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function editListing(listingId) {
                const viewFields = document.querySelector(`.view-fields[data-id="${listingId}"]`);
                const editFields = document.querySelector(`.edit-fields[data-id="${listingId}"]`);
                const editActions = document.querySelector(`.edit-actions[data-id="${listingId}"]`);

                if (viewFields && editFields && editActions) {
                    viewFields.style.display = 'none';
                    editFields.style.display = 'block';
                    editActions.style.display = 'block';
                } else {
                    console.error(`Elements for listing ID ${listingId} not found`);
                }
            }

            function cancelEdit(listingId) {
                const viewFields = document.querySelector(`.view-fields[data-id="${listingId}"]`);
                const editFields = document.querySelector(`.edit-fields[data-id="${listingId}"]`);
                const editActions = document.querySelector(`.edit-actions[data-id="${listingId}"]`);

                if (viewFields && editFields && editActions) {
                    editFields.style.display = 'none';
                    editActions.style.display = 'none';
                    viewFields.style.display = 'block';
                } else {
                    console.error(`Elements for listing ID ${listingId} not found`);
                }
            }

            // Expose functions globally
            window.editListing = editListing;
            window.cancelEdit = cancelEdit;
        });
    </script>


</x-app-layout>
