<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6 wow fadeInUp" data-wow-delay="0.1s">{{ $title ?? 'Shop Page' }}</h1>
    <ol class="breadcrumb justify-content-center mb-0 wow fadeInUp" data-wow-delay="0.3s">
        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
        @if(isset($breadcrumbs) && is_array($breadcrumbs))
            @foreach($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active text-white' : '' }}">
                    @if($loop->last)
                        {{ $breadcrumb['name'] }}
                    @else
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    @endif
                </li>
            @endforeach
        @else
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">{{ $title ?? 'Shop' }}</li>
        @endif
    </ol>
</div>
<!-- Page Header End -->
