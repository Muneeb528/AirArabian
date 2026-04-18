@extends('layouts.vendor')
@section('title', 'Bank Accounts')
@section('page-title', 'Bank Accounts')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">Bank Accounts</div>
        <div class="vp-page-subtitle">Use these accounts to submit your payment proof</div>
    </div>
</div>

@if($banks->isEmpty())
    <div style="background:#fff;border-radius:16px;padding:60px;text-align:center;color:var(--gray-400);box-shadow:var(--shadow)">
        <i class="fas fa-university" style="font-size:3rem;opacity:.3;display:block;margin-bottom:16px"></i>
        <div style="font-weight:600;font-size:1rem;color:var(--gray-600)">No Bank Accounts Added Yet</div>
        <div style="font-size:.85rem;margin-top:6px">Contact admin to add payment bank details.</div>
    </div>
@else

<div class="vp-bank-grid">
    @foreach($banks as $bank)
    <div class="vp-bank-card" style="--bank-color: {{ $bank->bankColor() }}">
        <div class="vp-bank-logo" style="background:{{ $bank->bankColor() }}">
            <i class="{{ $bank->bankIcon() }}"></i>
        </div>
        <div class="vp-bank-name">{{ $bank->bank_name }}</div>

        <button class="vp-bank-copy" onclick="copyToClipboard('{{ $bank->account_number }}', this)">
            <i class="fas fa-copy"></i> Copy
        </button>

        <div class="vp-bank-row">
            <span class="vp-bank-key">Account Title</span>
            <span class="vp-bank-val">{{ $bank->account_title }}</span>
        </div>
        <div class="vp-bank-row">
            <span class="vp-bank-key">Account No.</span>
            <span class="vp-bank-val" style="font-family:monospace;font-size:.9rem">{{ $bank->account_number }}</span>
        </div>
        @if($bank->iban)
        <div class="vp-bank-row">
            <span class="vp-bank-key">IBAN</span>
            <span class="vp-bank-val" style="font-family:monospace;font-size:.82rem">{{ $bank->iban }}</span>
        </div>
        @endif
        @if($bank->branch)
        <div class="vp-bank-row">
            <span class="vp-bank-key">Branch</span>
            <span class="vp-bank-val">{{ $bank->branch }}</span>
        </div>
        @endif
    </div>
    @endforeach
</div>

<div style="background:var(--red-pale);border:1px solid var(--red-light);border-radius:12px;padding:16px 22px;margin-top:28px;font-size:.85rem;color:var(--red-dark);display:flex;align-items:flex-start;gap:12px">
    <i class="fas fa-info-circle" style="font-size:1.1rem;margin-top:2px;flex-shrink:0"></i>
    <div>
        <strong>Payment Instructions:</strong><br>
        Transfer the booking amount to any of the accounts above, then submit the payment proof in your booking detail page within <strong>4 hours</strong> of creating the booking. Late payments will result in automatic booking cancellation.
    </div>
</div>

@endif
@endsection

@push('scripts')
<script>
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        var orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.style.background = 'var(--red)';
        btn.style.color = '#fff';
        setTimeout(function() { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; }, 2000);
    });
}
</script>
@endpush
