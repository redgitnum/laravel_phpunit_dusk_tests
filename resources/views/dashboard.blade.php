<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg text-center mb-4">Add item to db</h1>
                    @if(session('duplicate'))
                    <div class="text-center text-red-600 mb-2">
                        {{ session('duplicate') }}
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="text-center text-green-600 mb-2">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form action="{{ route('dashboard.add') }}" method="POST" class="flex flex-col gap-1 items-center">
                        @csrf
                        <label for="name">Name:
                            <input type="text" name="name" required>
                        </label>
                        <label for="count">Count:
                            <input type="number" name="count" min="1" max="100">
                        </label>
                        <label for="location">Location:
                            <input type="text" name="location" required>
                        </label>
                        <button class="bg-green-300 p-2 rounded">Submit</button>
                    </form>
                    
                </div>
                <div class="flex flex-col items-center">
                    <h1 class="text-lg p-4">Items list</h1>
                    @if(!$products->isEmpty())
                        <table class="table-auto border-collapse m-4">
                            <thead class="bg-gray-600 text-gray-100">
                                <tr>
                                    <th class="border p-2">#</th>
                                    <th class="border p-2">Name</th>
                                    <th class="border p-2">Location</th>
                                    <th class="border p-2">Count</th>
                                    <th class="border p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="border border-gray-500 p-2">{{ $product->id }}</td>
                                    <td class="border border-gray-500 p-2">{{ $product->name }}</td>
                                    <td class="border border-gray-500 p-2">{{ $product->location }}</td>
                                    <td class="border border-gray-500 p-2">{{ $product->count }}</td>
                                    <td class="border border-gray-500 p-2">
                                        <form action="{{ route('dashboard.delete') }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name='id' value="{{ $product->id }}">
                                            <button class="bg-red-600 text-white p-2 rounded">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="m-4">Nothing to show :(</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
