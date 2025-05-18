@extends('layouts.app')

@section('content')
<div class="hospital-theme">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Welcome to <span>FIO</span> Hospital</h1>
                    <p class="hero-subtitle">Providing quality healthcare services with compassion and excellence</p>
                    <div class="hero-buttons">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Admin Login
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hospital-hero.png') }}" alt="Hospital Building" class="img-fluid hero-image"  width="100%">
                </div>
            </div>
        </div>
    </div>

        <!-- Services Section -->
        <div class="services-section py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">Our Services</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="service-icon bg-primary">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Emergency Care</h3>
                        <p>24/7 emergency services with state-of-the-art facilities and expert medical staff.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="service-icon bg-success">
                            <i class="fas fa-procedures"></i>
                        </div>
                        <h3>Surgery</h3>
                        <p>Advanced surgical procedures performed by highly skilled surgeons.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <div class="service-icon bg-info">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h3>Medical Consultation</h3>
                        <p>Comprehensive consultations with our specialist doctors.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="features-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('images/medical-team.png') }}" alt="Medical Team" class="img-fluid rounded" width="100%">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Our Hospital</h2>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Experienced Professionals</h4>
                                <p>Our team consists of highly qualified doctors and nurses.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Modern Equipment</h4>
                                <p>We use the latest medical technology for accurate diagnostics.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Patient-Centered Care</h4>
                                <p>Your health and comfort are our top priorities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="cta-section py-5 text-center bg-primary text-white">
        <div class="container">
            <h2 class="mb-4">Need Medical Assistance?</h2>
            <p class="lead mb-4">Our team is ready to provide you with the best healthcare services.</p>
            <a href="tel:+1234567890" class="btn btn-light btn-lg me-3">
                <i class="fas fa-phone-alt me-2"></i>Call Now
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-calendar-alt me-2"></i>Admin Portal
            </a>
        </div>
    </div>
</div>
@endsection