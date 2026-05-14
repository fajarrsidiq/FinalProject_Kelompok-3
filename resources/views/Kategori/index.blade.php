<nav class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
    <!-- Kiri: Informasi cabang / title -->
    <div class="flex items-center gap-4">
        <div class="text-gray-600">
            <i class="fas fa-store mr-2 text-blue-600"></i>
            <span class="font-semibold">{{ auth()->user()->cabang->nama_toko ?? 'Semua Cabang' }}</span>
        </div>
        @if(auth()->user()->isOwner())
            <div class="text-sm text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                <i class="fas fa-crown mr-1"></i> Owner
            </div>
        @endif
    </div>

    <!-- Kanan: Notifikasi + User Menu -->
    <div class="flex items-center gap-4">
        <!-- Notifikasi (posisi paling kanan) -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bell text-xl"></i>
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Notifikasi -->
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 overflow-hidden">
                <div class="p-3 border-b bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                        <div class="p-3 border-b hover:bg-gray-50 transition {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-500 hover:text-blue-700">Tandai</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 text-sm">
                            <i class="fas fa-inbox mb-2 block"></i>
                            Tidak ada notifikasi
                        </div>
                    @endforelse
                </div>
                <div class="p-2 border-t bg-gray-50 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
                </div>
            </div>
        </div>

        <!-- User Menu (avatar, logout, dll) -->
        <div class="flex items-center gap-3">
            <div class="text-right hidden md:block">
                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-red-600 transition-all">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </button>
            </form>
        </div>
    </div>
</nav>