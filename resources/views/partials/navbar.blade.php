@props(['actions' => []])

<nav class="top-0 left-0 w-full shadow-lg z-50"
     style="background: url('{{ asset('img/building-bg.png') }}') no-repeat center top; background-size: cover; background-position-y: -100px;">
    <div class="container mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img src="{{ asset('img/logo-white.png') }}" alt="Logo" class="h-12 sm:h-16 mr-3">
        </a>
        <div class="flex items-center space-x-2 sm:space-x-3">
            @foreach($actions as $action)
                @php
                    $method = $action['method'] ?? 'GET';
                    $route = $action['route'] ?? '#';
                    $label = $action['label'];
                    $class = 'bg-[#2C2C2C] hover:bg-slate-600 text-white px-3 sm:px-6 py-2 rounded-lg font-medium transition-colors duration-200 text-xs sm:text-sm';
                @endphp

                @if($method === 'GET')
                    <a href="{{ $route }}" class="{{ $class }}">
                        {{ $label }}
                    </a>
                @else
                    <form action="{{ $route }}" method="POST" class="inline">
                        @csrf
                        @if($method !== 'POST')
                            @method($method)
                        @endif
                        <button type="submit" class="{{ $class }}">
                            {{ $label }}
                        </button>
                    </form>
                @endif
            @endforeach
        </div>
    </div>
    <div class="h-3 bg-gradient-to-r from-orange-500 via-orange-300 to-orange-500"></div>
</nav>
