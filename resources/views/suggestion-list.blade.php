@extends('layouts.app')

@section('title', 'Daftar Saran dan Kritik')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        <i class="bi bi-chat-dots text-indigo-600"></i> Saran & Kritik
    </h2>

    @if($suggestions->isEmpty())
        <div class="text-center text-gray-600">Belum ada saran atau kritik yang masuk.</div>
    @endif

    <div class="space-y-6">
        @foreach($suggestions as $suggestion)
            <div class="flex items-start space-x-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($suggestion->nama) }}&background=4f46e5&color=fff" alt="{{ $suggestion->nama }}" class="w-12 h-12 rounded-full">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="font-semibold text-gray-800">{{ $suggestion->nama }}</h4>
                        <span class="text-sm text-gray-500">{{ $suggestion->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="text-gray-700">{{ $suggestion->pesan }}</p>
                    <p class="text-sm text-gray-400 mt-1">{{ $suggestion->email }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $suggestions->links() }}
    </div>
</div>
@endsection