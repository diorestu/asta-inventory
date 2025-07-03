@props(['links' => []])

<div class="d-flex justify-content-between align-items-center">
    <nav aria-label="breadcrumb" class="mb-3">
        @if(count($links) > 0)
            <ol class="breadcrumb breadcrumb-dot mb-1">
                @foreach($links as $link)
                    @if(!$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $link['text'] }}
                        </li>
                    @endif
                @endforeach
            </ol>
        @endif

        <h2 class="fw-bold">{{ $title }}</h2>
    </nav>
    <div>
        {{ $slot }}
        
    </div>
</div>