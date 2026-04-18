@extends('layouts.app')

@section('title', 'Become a Vendor - AirArabian')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(201,168,76,0.3); border-radius: 16px; padding: 40px;">
                <div class="text-center mb-4">
                    <i class="fas fa-handshake fa-3x" style="color: #c9a84c;"></i>
                    <h2 class="mt-3" style="color: #f0ece4;">Become an <span style="color: #c9a84c;">AirArabian</span> Vendor</h2>
                    <p style="color: #7a8090;">Fill out the form below and our team will contact you within 24 hours.</p>
                </div>

                <form method="POST" action="/vendor-inquiry">
                    @csrf
                    <div class="mb-3">
                        <label style="color: #c9a84c;">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: #c9a84c;">Company Name</label>
                        <input type="text" name="company" class="form-control" placeholder="Your company name" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: #c9a84c;">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: #c9a84c;">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+92 300 0000000" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: #c9a84c;">Message</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your business..."></textarea>
                    </div>
                    <button type="submit" class="btn w-100" style="background: #c9a84c; color: #000; font-weight: 600; padding: 12px;">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection