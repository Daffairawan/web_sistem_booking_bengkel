<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">Booking History</h3>
                <a href="{{ route('customer.bookings.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transform transition hover:scale-105">
                    + New Booking
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($bookings->isEmpty())
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new workshop booking.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600 border-b border-gray-200">Date & Time</th>
                                        <th class="py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600 border-b border-gray-200">Service</th>
                                        <th class="py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600 border-b border-gray-200">Vehicle</th>
                                        <th class="py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600 border-b border-gray-200">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-4 px-6 border-b border-gray-200">
                                            <div class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</div>
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 text-gray-700">
                                            {{ $booking->service->service_name ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 text-gray-700">
                                            {{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->model ?? '' }} 
                                            <span class="block text-xs text-gray-500">{{ $booking->vehicle->license_plate ?? '' }}</span>
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200">
                                            @php
                                                $color = match($booking->status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                                    'in_progress' => 'bg-indigo-100 text-indigo-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
