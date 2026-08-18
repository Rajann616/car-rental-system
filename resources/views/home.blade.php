@extends('layouts.app')

@section('title', 'AutoLux — Premium Car Rental in Ahmedabad')
@section('body_class', 'has-hero')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-bg-pattern"></div>
    <div class="hero-gradient-orb orb-1"></div>
    <div class="hero-gradient-orb orb-2"></div>
    
    <div class="container position-relative z-2">
        <div class="row align-items-center g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-content">
                    <div class="hero-eyebrow mb-3">
                        <i class="fas fa-map-marker-alt text-warning me-2"></i> Book Online · Delivered to Your Location
                    </div>
                    <h1 class="hero-title">
                        Cars Delivered to <br><span class="highlight">Your Doorstep</span>
                    </h1>
                    <p class="hero-desc">
                        Book your perfect vehicle online and we'll deliver it directly to your home, office, airport, or hotel across Ahmedabad & Gujarat. Transparent rates, zero hassle.
                    </p>
                    <div class="hero-cta-group">
                        <a href="#car" class="btn btn-hero-primary">
                            <span>Explore Cars & Book</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#services" class="btn btn-hero-outline">
                            <i class="fas fa-truck me-2"></i> How Delivery Works
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-3d-wrapper">
                    <!-- Floating Badges -->
                    <div class="hero-floating-badge badge-top-right">
                        <span class="badge-icon bg-warning text-dark"><i class="fas fa-star"></i></span>
                        <div>
                            <div class="fw-bold text-white fs-7">5.0 Customer Rating</div>
                            <div class="text-white-50 small">Top Reviewed Rental</div>
                        </div>
                    </div>

                    <div class="hero-floating-badge badge-bottom-left">
                        <span class="badge-icon bg-success text-white"><i class="fas fa-map-pin"></i></span>
                        <div>
                            <div class="fw-bold text-white fs-7">Instant Doorstep Delivery</div>
                            <div class="text-white-50 small">Ahmedabad & Outstation</div>
                        </div>
                    </div>

                    <!-- Loader Overlay -->
                    <div id="porscheLoader" class="position-absolute top-50 start-50 translate-middle text-center z-3 w-75">
                        <div class="spinner-border text-primary mb-2" role="status" style="width: 2.5rem; height: 2.5rem;">
                            <span class="visually-hidden">Loading 3D Vehicle...</span>
                        </div>
                        <div class="text-white small fw-bold" id="porscheLoadingProgress">Loading 3D Showcase...</div>
                    </div>

                    <!-- 3D Canvas -->
                    <div id="porsche3dCanvas" class="w-100 h-100 position-relative z-1" style="cursor: grab;"></div>
                </div>
            </div>
        </div>

        <!-- Integrated Statistics Transition Bar -->
        <div class="stats-hero-bridge mt-5" data-aos="fade-up">
            <div class="row text-center g-3">
                <div class="col-4 border-end border-white border-opacity-10">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Delivery Zones</div>
                </div>
                <div class="col-4 border-end border-white border-opacity-10">
                    <div class="stat-number">5k+</div>
                    <div class="stat-label">Successful Deliveries</div>
                </div>
                <div class="col-4">
                    <div class="stat-number">30m</div>
                    <div class="stat-label">Average Delivery Time</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Soft Transition Wave/Gradient Mask -->
    <div class="hero-bottom-transition"></div>
</section>

<!-- Cars Section (SOFT surface background #F6F8FC) -->
<section class="section-padding bg-soft-surface" id="car">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Curated Selection</span>
            <h2 class="section-title">Explore Our Premium Cars</h2>
            <p class="section-subtitle mx-auto">Select from top-rated sedans, hatchbacks, electric vehicles, and rugged 4x4 SUVs delivered to your location.</p>
        </div>

        <div class="row g-4">
            @forelse($featuredCars as $car)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="car-card w-100">
                        <div class="car-card-img">
                            @if($car->thumbnail)
                                <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}">
                            @else
                                <div class="car-placeholder-icon">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif
                            <span class="car-badge {{ strtolower($car->status) }}">
                                @if($car->status === 'Available')
                                    <span class="pulse-dot me-1"></span>
                                @endif
                                {{ $car->status }}
                            </span>
                            <span class="car-fuel-badge"><i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type }}</span>
                        </div>
                        <div class="car-card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="car-card-brand">{{ $car->brand }}</div>
                                <h3 class="car-card-title">{{ $car->model }} <small class="text-muted fs-6">({{ $car->year }})</small></h3>
                                <div class="car-card-specs">
                                    <div class="car-spec"><i class="fas fa-cog"></i> {{ $car->transmission }}</div>
                                    <div class="car-spec"><i class="fas fa-user-friends"></i> {{ $car->seating_capacity }} Seats</div>
                                    <div class="car-spec"><i class="fas fa-shield-alt"></i> Insured</div>
                                </div>
                            </div>
                            <div class="car-card-footer">
                                <div class="car-price">₹{{ number_format($car->rental_price_per_day, 0) }} <span>/ day</span></div>
                                <a href="{{ route('login') }}" class="btn btn-book">
                                    Book Now <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">No vehicles available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us Section (PURE WHITE background #FFFFFF) -->
<section class="section-padding bg-pure-white" id="about">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Why AutoLux</span>
            <h2 class="section-title">The AutoLux Distinction</h2>
            <p class="section-subtitle mx-auto">We redefine car rental with transparent pricing, instant online verification, and doorstep delivery.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-virus"></i></div>
                    <h4>Sanitized & Maintained</h4>
                    <p>Every vehicle undergoes a 40-point safety check and full sanitization before delivery to your door.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <h4>Zero Hidden Costs</h4>
                    <p>Transparent daily rates, inclusive insurance coverage, and clear refundable security deposit terms.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-truck-ramp-box"></i></div>
                    <h4>Doorstep Delivery</h4>
                    <p>Get your vehicle delivered directly to your home, office, hotel, or airport terminal on schedule.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h4>24/7 Road Assistance</h4>
                    <p>Dedicated 24-hour helpline and instant breakdown assistance across highway routes in Gujarat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section (SOFT surface background #F6F8FC) -->
<section class="section-padding bg-soft-surface" id="services">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Simple 4-Step Process</span>
            <h2 class="section-title">Car Delivered, Wherever You Are</h2>
            <p class="section-subtitle mx-auto">Book online in minutes. We handle delivery and pickup so you can focus entirely on your journey.</p>
        </div>

        <div class="row g-4 position-relative step-flow-container">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card">
                    <div class="step-number">01</div>
                    <div class="step-icon"><i class="fas fa-map-location-dot"></i></div>
                    <h4>Pick Your Location</h4>
                    <p>Enter your preferred delivery address — home, office, hotel, or airport terminal in Ahmedabad.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card">
                    <div class="step-number">02</div>
                    <div class="step-icon"><i class="fas fa-car-side"></i></div>
                    <h4>Choose Your Car</h4>
                    <p>Select your ideal hatchback, sedan, or SUV. Pick your dates and upload required verification documents.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card">
                    <div class="step-number">03</div>
                    <div class="step-icon"><i class="fas fa-truck-fast"></i></div>
                    <h4>Doorstep Delivery</h4>
                    <p>Our driver delivers a clean, fueled vehicle to your doorstep at your requested time slot.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card">
                    <div class="step-number">04</div>
                    <div class="step-icon"><i class="fas fa-location-arrow"></i></div>
                    <h4>Drive & Return Anywhere</h4>
                    <p>Enjoy your trip across Gujarat. When finished, our team picks up the car from your designated location.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Stories Section (PURE WHITE background #FFFFFF) -->
<section class="section-padding bg-pure-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Customer Experience</span>
            <h2 class="section-title">Delivered to Their Door, Loved Every Mile</h2>
            <p class="section-subtitle mx-auto">Sample experiences from drivers who experienced seamless online booking & doorstep delivery.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Booked a Tata Harrier for a Statue of Unity weekend trip. The vehicle was delivered right outside my SG Highway flat at 6 AM — pristine and fully fueled."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">RP</div>
                        <div>
                            <div class="testimonial-name">Rajesh Patel</div>
                            <div class="testimonial-role">Business Owner, SG Highway</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Landed at Ahmedabad airport and my reserved Mahindra Thar was already delivered and parked outside arrivals. Fast document check and I was on the road!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">PS</div>
                        <div>
                            <div class="testimonial-name">Priya Sharma</div>
                            <div class="testimonial-role">Architect, Satellite</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Needed an urgent car for an outstation meeting. Booked on AutoLux, set my office as delivery point, and it arrived in 30 minutes. Exceptional service!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">AD</div>
                        <div>
                            <div class="testimonial-name">Amit Desai</div>
                            <div class="testimonial-role">Software Engineer, Bodakdev</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section (SOFT surface background #F6F8FC) -->
<section class="section-padding bg-soft-surface" id="faq">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle mx-auto">Everything you need to know about our location-based rental & delivery service.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="accordion faq-section" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What documents are required to rent a vehicle?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You need a valid Indian Driving License (DL) and an ID proof such as Aadhaar Card or Passport. Documents can be uploaded directly to your dashboard for instant verification.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Is security deposit required?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, a small refundable security deposit is charged depending on vehicle category. The deposit is refunded automatically within 24-48 hours after vehicle return.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What is the fuel policy?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We follow a like-for-like fuel policy. Return the vehicle with the same fuel level provided at the time of delivery.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Can I cancel my booking?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, free cancellation is allowed up to 24 hours before your scheduled delivery time directly through your customer dashboard.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final High-Conversion CTA Section (DARK NAVY #071A33) -->
<section class="final-cta-section text-white py-5">
    <div class="container py-4 text-center" data-aos="zoom-in">
        <div class="badge bg-warning bg-opacity-20 text-warning px-3 py-2 rounded-pill text-uppercase fw-bold mb-3 fs-7">
            <i class="fas fa-bolt me-1"></i> Quick & Easy Car Rental
        </div>
        <h2 class="display-5 font-display fw-bold mb-3">Ready to Ride?</h2>
        <p class="lead text-white-50 mx-auto max-width-600 mb-4">
            Choose your car, select your dates, and get it delivered directly to your preferred location across Ahmedabad.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('cars.index') }}" class="btn btn-brand-cta">
                <span>Browse Cars Now</span>
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a href="#services" class="btn btn-hero-outline">
                <i class="fas fa-circle-info me-2"></i> How It Works
            </a>
        </div>
    </div>
</section>

<!-- Contact Section (DARK NAVY) -->
<section class="py-5 contact-section" id="contact">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="section-eyebrow text-warning">Get In Touch</span>
                <h2 class="section-title text-white">Visit Our Ahmedabad Hub</h2>
                <p class="text-white-50 mb-4">Have questions or custom requirements? Contact our support team or send us a quick message.</p>

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-info-text">
                        <h6>Location</h6>
                        <p>SG Highway, Near Iskcon Temple, Ahmedabad, GJ 380015</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="contact-info-text">
                        <h6>Call Us</h6>
                        <p>+91 98765 43210 / +91 79 2685 0000</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-info-text">
                        <h6>Email</h6>
                        <p>support@autolux.in</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form p-4 p-md-5 rounded-4 bg-white bg-opacity-10 border border-light border-opacity-10">
                    <h3 class="font-display text-white mb-4">Send Message</h3>
                    <form action="{{ route('contact.send') }}" method="POST" onsubmit="const btn = this.querySelector('button[type=submit]'); setTimeout(() => { btn.disabled = true; btn.innerHTML = '<i class=\'fas fa-spinner fa-spin me-2\'></i> Sending...'; }, 10);">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-md-12">
                                <textarea name="message" class="form-control" rows="4" placeholder="Your Message..." required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-hero-primary w-100">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById('porsche3dCanvas');
    if (!container || typeof THREE === 'undefined' || typeof THREE.GLTFLoader === 'undefined') return;

    // 1. Scene & Fog
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x0f172a, 0.025);

    // 2. Camera setup - lowered aggressive luxury sports car perspective
    const camera = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(3.4, 1.15, 3.8);

    // 3. WebGL Renderer with soft shadows
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    if ('outputColorSpace' in renderer && THREE.SRGBColorSpace) {
        renderer.outputColorSpace = THREE.SRGBColorSpace;
    }
    container.appendChild(renderer.domElement);

    // 4. OrbitControls & Interactive Listeners
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.maxPolarAngle = Math.PI / 2 - 0.02;
    controls.minDistance = 2.5;
    controls.maxDistance = 12;
    controls.target.set(0, 0.22, 0);

    let isHovered = false;
    let isUserDragging = false;

    container.addEventListener('mouseenter', () => { isHovered = true; });
    container.addEventListener('mouseleave', () => { isHovered = false; });
    controls.addEventListener('start', () => { isUserDragging = true; });
    controls.addEventListener('end', () => { isUserDragging = false; });

    // Double Click Reset
    container.addEventListener('dblclick', () => {
        camera.position.set(3.4, 1.15, 3.8);
        controls.target.set(0, 0.22, 0);
        controls.update();
    });
    window.porscheControls = controls;

    // 5. Realistic Showroom Studio Lighting
    // Subtle blue ambient fill light
    const ambientLight = new THREE.AmbientLight(0xdbeafe, 0.8);
    scene.add(ambientLight);

    // Soft White Key Light from top-left
    const mainLight = new THREE.DirectionalLight(0xffffff, 2.8);
    mainLight.position.set(-8, 12, 8);
    mainLight.castShadow = true;
    mainLight.shadow.mapSize.width = 2048;
    mainLight.shadow.mapSize.height = 2048;
    scene.add(mainLight);

    // Gentle Blue Rim Light around contours
    const blueRimLight = new THREE.DirectionalLight(0x60a5fa, 1.8);
    blueRimLight.position.set(8, 7, -6);
    scene.add(blueRimLight);

    // 6. Rotating Pedestal Platform & Realistic Ground Reflections
    const pedestalGroup = new THREE.Group();
    scene.add(pedestalGroup);

    const pedestalGeo = new THREE.CylinderGeometry(3.2, 3.4, 0.22, 64);
    const pedestalMat = new THREE.MeshStandardMaterial({
        color: 0x0f172a,
        roughness: 0.2,
        metalness: 0.8
    });
    const pedestal = new THREE.Mesh(pedestalGeo, pedestalMat);
    pedestal.position.y = -0.11;
    pedestal.receiveShadow = true;
    pedestalGroup.add(pedestal);

    // Subtle Pedestal Edge Accent Ring
    const ringGeo = new THREE.TorusGeometry(3.3, 0.025, 16, 100);
    const ringMat = new THREE.MeshBasicMaterial({ color: 0x38bdf8, transparent: true, opacity: 0.7 });
    const ring = new THREE.Mesh(ringGeo, ringMat);
    ring.rotation.x = Math.PI / 2;
    ring.position.y = 0.001;
    pedestal.add(ring);

    // Soft Radial Blue Ambient Floor Glow (No vertical point light)
    const glowGeo = new THREE.CircleGeometry(2.8, 64);
    const glowMat = new THREE.MeshBasicMaterial({
        color: 0x1e3a8a,
        transparent: true,
        opacity: 0.18,
        side: THREE.DoubleSide
    });
    const chassisGlow = new THREE.Mesh(glowGeo, glowMat);
    chassisGlow.rotation.x = Math.PI / 2;
    chassisGlow.position.y = 0.005;
    pedestal.add(chassisGlow);

    // Realistic Contact Shadow beneath tires
    const contactShadowGeo = new THREE.CircleGeometry(2.4, 64);
    const contactShadowMat = new THREE.MeshBasicMaterial({
        color: 0x020617,
        transparent: true,
        opacity: 0.45,
        side: THREE.DoubleSide
    });
    const contactShadow = new THREE.Mesh(contactShadowGeo, contactShadowMat);
    contactShadow.rotation.x = Math.PI / 2;
    contactShadow.position.y = 0.012;
    pedestal.add(contactShadow);

    // Smooth Reflective Studio Ground Floor
    const groundGeo = new THREE.PlaneGeometry(50, 50);
    const groundMat = new THREE.MeshStandardMaterial({
        color: 0x060913,
        roughness: 0.18,
        metalness: 0.8
    });
    const ground = new THREE.Mesh(groundGeo, groundMat);
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = -0.22;
    ground.receiveShadow = true;
    scene.add(ground);

    const grid = new THREE.GridHelper(30, 30, 0x1e293b, 0x090e1a);
    grid.position.y = -0.21;
    scene.add(grid);

    // Subtle Background Particle Stars
    const particleCount = 60;
    const particleGeo = new THREE.BufferGeometry();
    const particlePositions = new Float32Array(particleCount * 3);
    for (let i = 0; i < particleCount * 3; i += 3) {
        particlePositions[i] = (Math.random() - 0.5) * 20;
        particlePositions[i + 1] = Math.random() * 8;
        particlePositions[i + 2] = (Math.random() - 0.5) * 20;
    }
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
    const particleMat = new THREE.PointsMaterial({
        color: 0x93c5fd,
        size: 0.05,
        transparent: true,
        opacity: 0.25
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    // 7. Load Local Porsche GLTF Model
    const loader = new THREE.GLTFLoader();
    const modelUrl = "{{ asset('models/porsche_718_cayman_gt4_2020__www.vecarz.com.glb') }}";

    loader.load(
        modelUrl,
        function (gltf) {
            const porscheModel = gltf.scene;

            // Compute Bounding Box for Centering and Scaling
            const box = new THREE.Box3().setFromObject(porscheModel);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());

            // Center model at origin
            porscheModel.position.x += (porscheModel.position.x - center.x);
            porscheModel.position.y += (porscheModel.position.y - center.y);
            porscheModel.position.z += (porscheModel.position.z - center.z);

            // Scale to fit hero card with balanced padding
            const maxDim = Math.max(size.x, size.y, size.z);
            const targetScale = 4.6 / maxDim;
            porscheModel.scale.set(targetScale, targetScale, targetScale);

            // Position ground alignment on top of pedestal
            const scaledBox = new THREE.Box3().setFromObject(porscheModel);
            porscheModel.position.y -= scaledBox.min.y;

            // Glossy Pearl White Paint Finish
            porscheModel.traverse((child) => {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;

                    if (child.material) {
                        const matArray = Array.isArray(child.material) ? child.material : [child.material];
                        matArray.forEach(m => {
                            const nameLower = (child.name || '').toLowerCase();
                            const matName = (m.name || '').toLowerCase();

                            if (matName.includes('paint') || matName.includes('body') || matName.includes('car_paint') || matName.includes('primary') || matName.includes('color') || nameLower.includes('body')) {
                                m.color.setHex(0xf8fafc); // Pearl White
                                m.metalness = 0.35;
                                m.roughness = 0.08;
                                if ('clearcoat' in m) m.clearcoat = 1.0;
                                if ('clearcoatRoughness' in m) m.clearcoatRoughness = 0.03;
                            }
                        });
                    }
                }
            });

            pedestalGroup.add(porscheModel);

            // Hide loader progress UI
            const loaderEl = document.getElementById('porscheLoader');
            if (loaderEl) loaderEl.classList.add('d-none');
        },
        function (xhr) {
            if (xhr.lengthComputable) {
                const percentComplete = Math.round((xhr.loaded / xhr.total) * 100);
                const progressEl = document.getElementById('porscheLoadingProgress');
                if (progressEl) {
                    progressEl.innerText = `Loading Porsche 3D Model... ${percentComplete}%`;
                }
            }
        },
        function (error) {
            console.error('Error loading local Porsche GLB model:', error);
            const progressEl = document.getElementById('porscheLoadingProgress');
            if (progressEl) {
                progressEl.innerText = 'Unable to load 3D model';
            }
        }
    );

    // Animation Loop
    const fullSpeed = 0.0035;
    const hoverSpeed = 0.0008; // slow spin on hover instead of full stop
    let currentSpeed = fullSpeed;

    function animate() {
        requestAnimationFrame(animate);

        // Smoothly transition rotation speed (no jarring stop on hover)
        let targetSpeed = fullSpeed;
        if (isUserDragging) {
            targetSpeed = 0; // only full stop when user is dragging
        } else if (isHovered) {
            targetSpeed = hoverSpeed; // slow down on hover, don't stop
        }
        currentSpeed += (targetSpeed - currentSpeed) * 0.05; // smooth lerp

        if (pedestalGroup) {
            pedestalGroup.rotation.y += currentSpeed;
        }

        controls.update();

        // Slow particle float
        const positions = particleGeo.attributes.position.array;
        for (let i = 1; i < particleCount * 3; i += 3) {
            positions[i] -= 0.004;
            if (positions[i] < 0) positions[i] = 8;
        }
        particleGeo.attributes.position.needsUpdate = true;

        renderer.render(scene, camera);
    }
    animate();

    // Window Resize Handler
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
});

</script>
@endpush
@endsection


