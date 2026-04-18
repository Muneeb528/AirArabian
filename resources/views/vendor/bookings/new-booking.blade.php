@extends('layouts.vendor')
@section('title', 'New Booking')
@section('page-title', 'New Booking')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">New Booking</div>
        <div class="vp-page-subtitle">Select a travel category to start a new booking</div>
    </div>
    <a href="{{ route('vendor.bookings.index') }}" class="btn-vp-secondary btn-vp-sm">
        <i class="fas fa-list me-1"></i> My Bookings
    </a>
</div>

<div class="vp-category-grid">

    @php
    $catConfig = [
        'Umrah Package' => ['icon' => 'fas fa-kaaba', 'desc' => 'Full Umrah packages with hotel & flight'],
        'Umrah Tickets' => ['icon' => 'fas fa-ticket-alt', 'desc' => 'Standalone Umrah flight tickets'],
        'KSA Oneway Groups' => ['icon' => 'fas fa-users', 'desc' => 'Group bookings for Saudi Arabia'],
        'Dubai'         => ['icon' => 'fas fa-city', 'desc' => 'Dubai travel packages & tickets'],
        'Oman'          => ['icon' => 'fas fa-mountain', 'desc' => 'Oman tour & travel packages'],
        'UK'            => ['icon' => 'fas fa-landmark', 'desc' => 'United Kingdom travel packages'],
    ];
    @endphp

    @foreach($categories as $cat)
    @php $cfg = $catConfig[$cat] ?? ['icon'=>'fas fa-globe','desc'=>'Travel package']; @endphp
    <a href="{{ route('vendor.bookings.create', ['category' => $cat]) }}" class="vp-cat-card">
        <div class="vp-cat-icon">
            <i class="{{ $cfg['icon'] }}"></i>
        </div>
        <div class="vp-cat-title">{{ $cat }}</div>
        <div class="vp-cat-desc">{{ $cfg['desc'] }}</div>
    </a>
    @endforeach

</div>
@endsection
