@extends('components.layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-bell"></i> Notifikasi Saya
            </h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white text-blue-600 px-3 py-1 rounded-lg text-sm hover:bg-gray-100 transition">
                        <i class="fas fa-check-double mr-1"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
                <div class="p-5 hover:bg-gray-50 transition {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope-open-text {{ $notification->read_at ? 'text-gray-400' : 'text-blue-500' }}"></i>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $notification->data['title'] ?? 'Notifikasi' }}</h3>
                                @if(!$notification->read_at)
                                    <span class="bg-blue-200 text-blue-800 text-xs px-2 py-0.5 rounded-full">Baru</span>
                                @endif
                            </div>
                            <p class="text-gray-600 mt-2">{{ $notification->data['message'] ?? '' }}</p>
                            <div class="flex gap-4 mt-3 text-sm text-gray-500">
                                <span><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</span>
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-500 hover:text-blue-700">
                                            Tandai Dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @if(isset($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-sm hover:bg-blue-100 transition ml-3">
                                Lihat Detail
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-5xl mb-3 block"></i>
                    <p>Belum ada notifikasi</p>
                </div>
            @endforelse
        </div>

        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection