<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Manage Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">All Workshop Bookings</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600 rounded-tl-lg">Customer</th>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600">Vehicle</th>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600">Service</th>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600">Date/Time</th>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600">Status</th>
                                    <th class="py-3 px-5 bg-gray-100 font-bold uppercase text-xs text-gray-600 rounded-tr-lg">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr class="border-b border-gray-100 hover:bg-blue-50 transition">
                                    <td class="py-4 px-5">
                                        <div class="font-semibold text-gray-800">{{ $booking->user->name ?? 'Deleted User' }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->user->phone_number ?? '-' }}</div>
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="text-sm font-medium text-gray-800">{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->model ?? '' }}</div>
                                        <div class="text-xs bg-gray-200 inline-block px-2 rounded mt-1">{{ $booking->vehicle->license_plate ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-4 px-5 text-sm text-gray-700">
                                        {{ $booking->service->service_name ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</div>
                                    </td>
                                    <td class="py-4 px-5">
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
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5">
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-3 rounded transition">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($bookings->isEmpty())
                            <div class="text-center py-8 text-gray-500">No bookings found in the system.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
