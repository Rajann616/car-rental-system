@extends('layouts.app')

@section('title', 'AutoLux — Premium Car Rental in Ahmedabad')
@section('body_class', 'has-hero')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-bg-pattern"></div>
    <div class="hero-gradient-orb orb-1"></div>
    <div class="hero-gradient-orb orb-2"></div>
    
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-content">
                    <div class="hero-eyebrow">
                        <i class="fas fa-star text-warning me-1"></i> Premium Car Rental in Ahmedabad
                    </div>
                    <h1 class="hero-title">
                        Drive Your Dreams in <span class="highlight">Gujarat</span>
                    </h1>
                    <p class="hero-desc">
                        Experience freedom on wheels. Choose from our luxury car of Maruti, Tata, Mahindra, Hyundai & Toyota vehicles for self-drive, outstation, or airport transfers.
                    </p>
                    <div class="hero-cta-group">
                        <a href="#car" class="btn btn-hero-primary">
                            <span>Explore Cars</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#services" class="btn btn-hero-outline">
                            <i class="fas fa-concierge-bell me-2"></i> Our Services
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">Luxury car</div>
                        </div>
                        <div class="hero-stat">
                            <div class="stat-number">5k+</div>
                            <div class="stat-label">Happy Drivers</div>
                        </div>
                        <div class="hero-stat">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Road Assistance</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-image-wrapper text-center">
                    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop" alt="Luxury SUV" class="img-fluid rounded-4 shadow-lg border border-light border-opacity-10">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- car Section -->
<section class="py-5" id="car">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Curated Selection</span>
            <h2 class="section-title">Explore Our Premium car</h2>
            <p class="section-subtitle mx-auto">Choose from India's top-rated sedans, hatchbacks, electric vehicles, and rugged 4x4 SUVs.</p>
        </div>

        <div class="row g-4">
            @forelse($featuredCars as $car)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="car-card">
                        <div class="car-card-img">
                            @if($car->thumbnail)
                                <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}">
                            @else
                                <div class="car-placeholder-icon">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif
                            <span class="car-badge {{ strtolower($car->status) }}">{{ $car->status }}</span>
                            <span class="car-fuel-badge"><i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type }}</span>
                        </div>
                        <div class="car-card-body">
                            <div class="car-card-brand">{{ $car->brand }}</div>
                            <h3 class="car-card-title">{{ $car->model }} <small class="text-muted fs-6">({{ $car->year }})</small></h3>
                            <div class="car-card-specs">
                                <div class="car-spec"><i class="fas fa-cog"></i> {{ $car->transmission }}</div>
                                <div class="car-spec"><i class="fas fa-user-friends"></i> {{ $car->seating_capacity }} Seats</div>
                                <div class="car-spec"><i class="fas fa-shield-alt"></i> Insured</div>
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

<!-- Why Choose Us -->
<section class="py-5 bg-light" id="about">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Why AutoLux</span>
            <h2 class="section-title">The AutoLux Distinction</h2>
            <p class="section-subtitle mx-auto">We redefine car rental in Gujarat with transparent pricing, instant verification, and premium customer care.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-virus"></i></div>
                    <h4>Sanitized & Maintained</h4>
                    <p>Every vehicle undergoes a 40-point safety inspection and deep cleaning before key handoff.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <h4>Zero Hidden Costs</h4>
                    <p>Clear pricing with included insurance, basic roadside assist, and flexible security deposits.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <h4>Doorstep Delivery</h4>
                    <p>Get your car delivered anywhere in Ahmedabad — SG Highway, Airport, Railway Station or home.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h4>24/7 Road Assistance</h4>
                    <p>24-hour dedicated helpline and breakdown support anywhere across Gujarat highway routes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5" id="services">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Tailored Solutions</span>
            <h2 class="section-title">Services Built Around You</h2>
            <p class="section-subtitle mx-auto">From weekend getaways to corporate trips, choose the rental format that suits your lifestyle.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-user-gear"></i></div>
                    <h4>Self-Drive Rentals</h4>
                    <p>Full control and freedom to explore Gujarat at your own pace without driver intrusion.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-user-tie"></i></div>
                    <h4>Chauffeur Driven</h4>
                    <p>Professional uniform-clad drivers for business meetings, weddings and luxury travel.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-plane-arrival"></i></div>
                    <h4>Airport Pickup & Drop</h4>
                    <p>Punctual pick and drop services at Sardar Vallabhbhai Patel International Airport (AMD).</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-route"></i></div>
                    <h4>Outstation Expeditions</h4>
                    <p>Unlimited kilometer plans for trips to Udaipur, Statues of Unity, Diu, Kutch, and Gir.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Client Feedback</span>
            <h2 class="section-title">Loved By Drivers Across Gujarat</h2>
            <p class="section-subtitle mx-auto">Read real experiences from our satisfied customers in Ahmedabad.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Rented a Tata Harrier for a family trip to Statue of Unity. The vehicle condition was brand new, and delivery at SG Highway was right on time!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">RP</div>
                        <div>
                            <div class="testimonial-name">Rajesh Patel</div>
                            <div class="testimonial-role">Business Owner, Ahmedabad</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The Razorpay booking process was smooth and instant. Driving the Thar in Kutch was an unforgettable experience. Highly recommended AutoLux!"</p>
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
                    <p class="testimonial-text">"Best rental service in Ahmedabad! Clean cars, simple document upload with Aadhaar and DL, and no hassle during deposit refund."</p>
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

<!-- FAQ Section -->
<section class="py-5" id="faq">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-eyebrow">Got Questions?</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
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
                                You need a valid Indian Driving License (DL) and an ID proof such as Aadhaar Card or PAN Card. Documents can be uploaded directly to your dashboard for instant verification.
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
                                Yes, a small refundable security deposit is charged based on vehicle category. The deposit is refunded within 24-48 hours after vehicle return inspection.
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
                                We follow a like-for-like fuel policy. Return the car with the same fuel level as provided at pickup.
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
                                Yes, free cancellation is allowed up to 24 hours before your pickup schedule.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 contact-section" id="contact">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="section-eyebrow text-warning">Get In Touch</span>
                <h2 class="section-title text-white">Visit Our Ahmedabad Hub</h2>
                <p class="text-white-50 mb-4">Have questions or custom requirements? Stop by our hub on SG Highway or send us a quick message.</p>

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-info-text">
                        <h6>Location</h6>
                        <p>123 SG Highway, Near Iskcon Temple, Ahmedabad, GJ 380015</p>
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
                        <p>support@AutoLux.in</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form p-4 p-md-5 rounded-4 bg-white bg-opacity-10 border border-light border-opacity-10">
                    <h3 class="font-display text-white mb-4">Send Message</h3>
                    <form onsubmit="event.preventDefault(); alert('Thank you for reaching out! We will contact you shortly.');">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" rows="4" placeholder="Your Message..." required></textarea>
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
@endsection
