<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <!-- Main Content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Properties -->
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l7 7m-7 7l-7-7m7-7v14" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Published Listings</div>
                            <div class="text-lg font-semibold text-gray-800"> {{ $publishedListings }}</div>
                        </div>
                    </div>
                </div>
                <!-- Properties Sold -->
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l7 7m-7 7l-7-7m7-7v14" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Properties Sold</div>
                            <div class="text-lg font-semibold text-gray-800">35</div>
                        </div>
                    </div>
                </div>
                <!-- New Listings -->
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l7 7m-7 7l-7-7m7-7v14" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Listings</div>
                                <div class="text-lg font-semibold text-gray-800">{{ $totalListings }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pending Sales -->
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l7 7m-7 7l-7-7m7-7v14" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Pending Sales</div>
                            <div class="text-lg font-semibold text-gray-800">
                                <p>{{ $pendingListings }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registered Users Box -->
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l7 7m-7 7l-7-7m7-7v14" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Registered Users</div>
                            <div class="text-lg font-semibold text-gray-800">{{ session('totalUsers', $totalUsers) }}
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <!-- User Information Section -->
            <!-- User Information Section -->
            <div x-data="{ open: false }" class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <span>Registered Users</span>
                        <button @click="open = !open" class="ml-2 text-gray-500 hover:text-gray-700">

                            <svg x-show="open" class="w-6 h-6 transition-transform duration-300" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 6l4 4-4 4-4-4 4-4z" clip-rule="evenodd" />
                            </svg>

                            <svg x-show="!open" class="w-6 h-6 transition-transform duration-300" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 9l4 4 4-4H6z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </h3>
                </div>

                <div x-show="open" class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Phone Number</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->phoneNumber }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 edit-button"
                                            data-id="{{ $user->id }}">Edit</button>
                                        <button class="hidden text-green-600 hover:text-green-900 save-button"
                                            data-id="{{ $user->id }}">Save</button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                    </table>
                </div>
            </div>


            <!-- Existing Charts and Transactions Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Registered Users by Month</h3>
                    <div class="w-full h-72">
                        <canvas id="usersChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Monthly Sales Overview -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Sales Overview</h3>
                    <div class="w-full h-36">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>

                <!-- New Listings by Month -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">New Listings by Month</h3>
                    <div class="w-full h-72">
                        <canvas id="listingsChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Property Sales by Agent -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Property Sales by Agent</h3>
                    <div class="w-full h-36">
                        <canvas id="realEstateAgentChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Types of Properties Sold -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Types of Properties Sold</h3>
                    <div class="w-full h-45">
                        <canvas id="propertyTypeChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- For Sale vs For Rent -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Properties For Sale vs For Rent</h3>
                    <div class="w-full h-72">
                        <canvas id="propertyChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- revenue -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4"> Monthly Revenue </h3>
                    <div class="w-full h-72">
                        <canvas id="dailyRevenueChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!--state listings-->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">Listings by state </h3>
                    <div class="w-full h-72">
                        <canvas id="stateListingsChart" width="400" height="200"></canvas>
                    </div>
                </div>





            </div>



            <!-- Recent Transactions Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Property</th>
                            <th class="py-2 px-4 border-b">Client</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">2024-09-01</td>
                            <td class="py-2 px-4 border-b">Modern Apartment</td>
                            <td class="py-2 px-4 border-b">Mindi Chenaya</td>
                            <td class="py-2 px-4 border-b text-green-500">Completed</td>
                            <td class="py-2 px-4 border-b">$350,000</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // User Editing
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.edit-button');
            const saveButtons = document.querySelectorAll('.save-button');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const row = button.closest('tr');
                    const cells = row.querySelectorAll('td');

                    cells.forEach((cell, index) => {
                        if (index < cells.length - 1) { // Skip the actions cell
                            cell.contentEditable = true;
                            cell.classList.add('bg-gray-100');
                        }
                    });

                    button.classList.add('hidden');
                    const saveButton = row.querySelector('.save-button');
                    saveButton.classList.remove('hidden');
                });
            });

            saveButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const row = button.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const userId = button.dataset.id;
                    const updatedData = {
                        name: cells[0].innerText,
                        phoneNumber: cells[1].innerText,
                        email: cells[2].innerText,
                    };

                    // Send updated data to the server via AJAX
                    fetch(`/users/${userId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                            },
                            body: JSON.stringify(updatedData),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('User updated successfully');
                            } else {
                                alert('Failed to update user');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });

                    cells.forEach((cell) => {
                        cell.contentEditable = false;
                        cell.classList.remove('bg-gray-100');
                    });

                    button.classList.add('hidden');
                    const editButton = row.querySelector('.edit-button');
                    editButton.classList.remove('hidden');
                });
            });

            // User Deletion
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault(); // Prevent the default form submission

                    const url = form.action; // Get the form action URL

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                // Remove the user row from the table
                                form.closest('tr').remove();
                                // Update the registered users count
                                const userCountElement = document.querySelector(
                                    'div.text-lg.font-semibold.text-gray-800');
                                const currentCount = parseInt(userCountElement.textContent);
                                userCountElement.textContent = currentCount -
                                    1; // Decrease the count
                            } else {
                                console.error('Error deleting user');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });

        // Sales Chart
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json(array_keys($transactionMonths)),
                datasets: [{
                    label: 'Transactions per Month',
                    data: @json(array_values($transactionMonths)),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // Listings Chart
        const listingsCtx = document.getElementById('listingsChart').getContext('2d');
        const listingsChart = new Chart(listingsCtx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Total Listings',
                    data: @json(array_values($months)),
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', // Change background color to light blue
                    borderColor: 'rgba(0, 123, 255, 1)', // Change border color to blue
                    borderWidth: 2 // Increase the line width for better visibility
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Users Chart
        var ctx = document.getElementById('usersChart').getContext('2d');
        var userMonths = @json(array_values($userMonths)); // Pass the months' data to JavaScript

        var usersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Users Registered',
                    data: userMonths,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Types of Properties Sold
        const propertyTypeCtx = document.getElementById('propertyTypeChart').getContext('2d');
        const propertyTypeChart = new Chart(propertyTypeCtx, {
            type: 'pie',
            data: {
                labels: @json($propertyTypeChart['labels']),
                datasets: [{
                    label: 'Types of Properties Sold',
                    data: @json($propertyTypeChart['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Property Sales by Agent
        const realEstateAgentCtx = document.getElementById('realEstateAgentChart').getContext('2d');
        const realEstateAgentChart = new Chart(realEstateAgentCtx, {
            type: 'bar',
            data: {
                labels: @json($realEstateAgentChart['labels']),
                datasets: [{
                    label: 'Agencies',
                    data: @json($realEstateAgentChart['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // For Sale vs For Rent Chart
        const propertyCtx = document.getElementById('propertyChart').getContext('2d');
        const propertyChart = new Chart(propertyCtx, {
            type: 'doughnut', // You can change to 'pie' if you want
            data: {
                labels: ['For Sale', 'For Rent'],
                datasets: [{
                    label: 'Properties',
                    data: [@json($propertiesForSale), @json($propertiesForRent)],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });


        // Daily Revenue for October
        var ctx = document.getElementById('dailyRevenueChart').getContext('2d');
        var dailyRevenueData = @json($dailyRevenue); // Pass data from the controller

        var myChart = new Chart(ctx, {
            type: 'bar', // Use 'bar' for daily revenue representation
            data: {
                labels: Array.from({
                    length: 31
                }, (v, k) => k + 1), // Days of October (1-31)
                datasets: [{
                    label: 'Daily Revenue for October (Rs.)',
                    data: dailyRevenueData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (Rs.)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Days of October'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        //state listings chart
        // State Listings Chart
        var ctx = document.getElementById('stateListingsChart').getContext('2d');
        var stateLabels = @json($stateLabels); // Pass state labels from the controller
        var stateData = @json($stateData); // Pass state data from the controller

        var stateChart = new Chart(ctx, {
            type: 'bar', // Use 'bar' for better visibility
            data: {
                labels: stateLabels,
                datasets: [{
                    label: 'Number of Listings by State',
                    data: stateData,
                    backgroundColor: 'rgba(255, 165, 0, 0.2)', // Orange with transparency
                    borderColor: 'rgba(255, 165, 0, 1)', // Solid orange
                    borderWidth: 1

                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Listings'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'States'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>

</x-app-layout>
