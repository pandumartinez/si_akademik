@props(['patterns', 'icon', 'label'])

<li
    @if (request()->is(...$patterns))
        class="nav-item has-treeview menu-open"
    @else
        class="nav-item has-treeview"
    @endif>
    <a
        @if (request()->is(...$patterns))
            class="nav-link active"
        @else
            class="nav-link"
        @endif
        type="button">
        <i class="nav-icon fas {{ $icon }}"></i>
        <p>
            {{ $label }}
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>
</li>
