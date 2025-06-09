@props(['route', 'pattern', 'icon' => 'far fa-circle', 'label'])

<li class="nav-item">
    <a
        @if (request()->is($pattern))
            class="nav-link active"
        @else
            class="nav-link"
        @endif
        href="{{ route($route) }}">
        <i class="{{ $icon }} nav-icon"></i>
        <p>{{ $label }}</p>
    </a>
</li>
