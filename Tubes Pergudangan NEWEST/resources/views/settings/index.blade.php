@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pengaturan</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="site_name" class="block font-medium text-gray-700">Nama Situs</label>
            <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @error('site_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="admin_email" class="block font-medium text-gray-700">Email Admin</label>
            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email', $settings['admin_email'] ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @error('admin_email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
