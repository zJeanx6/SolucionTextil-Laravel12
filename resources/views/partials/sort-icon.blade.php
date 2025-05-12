@php
    $isActive = $sortField === $field;
@endphp
@if ($isActive)
    @if ($sortDirection === 'asc')
        ▲
    @else
        ▼
    @endif
@endif
