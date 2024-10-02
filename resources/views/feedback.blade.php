<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reviews & Feedbacks') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap -m-4">
                <!-- Iterate through feedbacks and create cards -->
                @foreach ($feedbacks as $feedback)
                    <div class="p-4 w-full md:w-1/3">
                        <div
                            class="bg-white rounded-lg shadow-md p-6 transition-transform transform hover:scale-105 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $feedback->name }}</h3>
                            <p class="text-gray-700 mt-2">{{ $feedback->feedback }}</p>
                            <p class="text-gray-500 text-sm mt-4">Posted on:
                                {{ $feedback->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script></script>
</x-app-layout>
