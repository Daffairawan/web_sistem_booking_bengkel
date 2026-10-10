<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl">
                <div class="p-8 sm:px-10 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Schedule a Service</h3>
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                            <div class="font-medium text-red-700">Whoops! Something went wrong.</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.bookings.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Vehicle Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Vehicle</label>
                                <select name="vehicle_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" required>
                                    <option value="">-- Choose your vehicle --</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($vehicles->isEmpty())
                                    <p class="text-xs text-red-500 mt-2">You don't have any vehicles registered yet.</p>
                                @endif
                            </div>

                            <!-- Service Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Service</label>
                                <select name="service_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" required>
                                    <option value="">-- Choose a service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->service_name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                                <input type="date" name="booking_date" value="{{ old('booking_date') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" required>
                            </div>

                            <!-- Time -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                                <input type="time" name="booking_time" value="{{ old('booking_time') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                            <textarea name="customer_notes" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" placeholder="Tell us about the issue...">{{ old('customer_notes') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('customer.bookings.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4 transition">Cancel</a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:-translate-y-1">
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
