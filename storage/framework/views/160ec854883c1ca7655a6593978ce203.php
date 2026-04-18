<?php $__env->startSection('title', 'AirArabian - Premium Airline Ticketing for UAE, KSA, Umrah & Tours'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="container hero-content">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <div class="hero-badge mb-3">
                    <i class="fas fa-star me-1"></i> Pakistan's #1 Airline Ticketing Platform
                </div>
                <h1 class="hero-title">
                    Fly to Your<br>
                    <span class="gold-text">Dream Destination</span>
                </h1>
                <p class="hero-subtitle">
                    Premium flight tickets for UAE, KSA, Umrah & World Tours.<br>Trusted by thousands of travelers across Pakistan.
                </p>

                <!-- Search Bar -->
                <div class="search-card">
                    <form action="/" method="GET" class="search-form">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="search-label"><i class="fas fa-plane-departure me-1"></i>From</label>
                                <input type="text" name="from" class="search-input" placeholder="Karachi, PAK" value="<?php echo e(request('from')); ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="search-label"><i class="fas fa-plane-arrival me-1"></i>To</label>
                                <input type="text" name="to" class="search-input" placeholder="Dubai, UAE" value="<?php echo e(request('to')); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="search-label"><i class="fas fa-calendar me-1"></i>Departure</label>
                                <input type="date" name="date" class="search-input" value="<?php echo e(request('date')); ?>" min="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="search-label"><i class="fas fa-layer-group me-1"></i>Category</label>
                                <select name="category" class="search-input">
                                    <option value="">All Categories</option>
                                    <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat); ?>" <?php echo e(request('category') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn-search w-100">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Stats Row -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Happy Travelers</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="hero-stat">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Flights Weekly</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="hero-stat">
                        <div class="stat-number">4</div>
                        <div class="stat-label">Destinations</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="hero-stat">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <a href="#tickets"><i class="fas fa-chevron-down"></i></a>
    </div>
</section>

<!-- Category Tabs & Tickets Section -->
<section class="tickets-section" id="tickets">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-tag">Available Flights</span>
            <h2 class="section-title">Browse by <span class="gold-text">Destination</span></h2>
            <p class="section-subtitle">Explore our curated flight packages across 4 premium categories</p>
        </div>

        <!-- Category Tabs -->
        <ul class="nav category-tabs mb-4" id="categoryTabs" role="tablist">
            <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item" role="presentation">
                <button class="category-tab <?php echo e($cat === $category ? 'active' : ''); ?>"
                        id="tab-<?php echo e($cat); ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#panel-<?php echo e($cat); ?>"
                        type="button" role="tab">
                    <i class="fas <?php echo e($cat === 'UAE' ? 'fa-city' : ($cat === 'KSA' ? 'fa-mosque' : ($cat === 'Umrah' ? 'fa-kaaba' : 'fa-globe'))); ?> me-2"></i>
                    <?php echo e($cat); ?>

                    <span class="tab-count"><?php echo e($ticketsByCategory[$cat]->count()); ?></span>
                </button>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="categoryTabContent">
            <?php $__currentLoopData = $validCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade <?php echo e($cat === $category ? 'show active' : ''); ?>" id="panel-<?php echo e($cat); ?>" role="tabpanel">
               <?php if($ticketsByCategory[$cat]->isEmpty()): ?>
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-plane-slash empty-icon"></i>
                        <h4>No tickets available in <?php echo e($cat); ?> right now</h4>
                        <p class="text-muted">Check back soon or contact our team for custom packages.</p>
                    </div>
                <?php else: ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $ticketsByCategory[$cat]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="ticket-card">
                            <div class="ticket-card-header">
                                <div class="ticket-category-badge"><?php echo e($ticket->category); ?></div>
                                <div class="ticket-status-badge <?php echo e($ticket->statusBadgeClass()); ?>">
                                    <?php echo e(ucfirst($ticket->status)); ?>

                                </div>
                            </div>

                            <?php if($ticket->image): ?>
                                <img src="<?php echo e(Storage::url($ticket->image)); ?>" class="ticket-image" alt="<?php echo e($ticket->title); ?>">
                            <?php else: ?>
                                <div class="ticket-image-placeholder">
                                    <i class="fas fa-plane"></i>
                                </div>
                            <?php endif; ?>

                            <div class="ticket-body">
                                <div class="ticket-route">
                                    <span class="route-city"><?php echo e($ticket->origin); ?></span>
                                    <div class="route-arrow">
                                        <i class="fas fa-plane"></i>
                                        <div class="route-line"></div>
                                    </div>
                                    <span class="route-city"><?php echo e($ticket->destination); ?></span>
                                </div>

                                <h5 class="ticket-title"><?php echo e($ticket->title); ?></h5>

                                <?php if($ticket->airline): ?>
                                    <p class="ticket-airline"><i class="fas fa-plane-departure me-1"></i><?php echo e($ticket->airline); ?></p>
                                <?php endif; ?>

                                <div class="ticket-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo e($ticket->departure_date->format('d M Y')); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-chair"></i>
                                        <span><?php echo e($ticket->seats_available); ?> seats left</span>
                                    </div>
                                </div>

                                <div class="ticket-footer">
                                    <div class="ticket-price">
                                        <span class="price-currency">PKR</span>
                                        <span class="price-amount"><?php echo e(number_format($ticket->price)); ?></span>
                                        <span class="price-per">/person</span>
                                    </div>
                                    <a href="https://wa.me/923000000000?text=I'm interested in: <?php echo e(urlencode($ticket->title)); ?>"
                                       target="_blank" class="btn-book-now">
                                        <i class="fab fa-whatsapp me-1"></i>Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="features-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-tag">Why AirArabian</span>
            <h2 class="section-title">Travel with <span class="gold-text">Confidence</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h5 class="feature-title">Secure Booking</h5>
                    <p class="feature-text">Your payments are protected via JazzCash & EasyPaisa verified transactions.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="fas fa-tags"></i></div>
                    <h5 class="feature-title">Best Prices</h5>
                    <p class="feature-text">We negotiate directly with airlines to bring you the most competitive fares.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h5 class="feature-title">24/7 Support</h5>
                    <p class="feature-text">Our expert team is always available to assist you before and after travel.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center">
                    <div class="feature-icon"><i class="fas fa-clock"></i></div>
                    <h5 class="feature-title">Instant Confirmation</h5>
                    <p class="feature-text">Get instant booking confirmation once your payment is verified by admin.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Become a Vendor CTA -->
<section class="vendor-cta-section">
    <div class="container">
        <div class="vendor-cta-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="cta-badge mb-2"><i class="fas fa-handshake me-1"></i>Partnership Opportunity</div>
                    <h2 class="cta-title">Become an <span class="gold-text">AirArabian</span> Vendor</h2>
                    <p class="cta-text">
                        Join our network of travel agents and vendors. Get exclusive access to wholesale ticket prices,
                        dedicated support, and a powerful booking dashboard to manage your customers.
                    </p>
                    <ul class="cta-benefits">
                        <li><i class="fas fa-check-circle me-2 gold-text"></i>Exclusive wholesale pricing</li>
                        <li><i class="fas fa-check-circle me-2 gold-text"></i>Dedicated vendor dashboard</li>
                        <li><i class="fas fa-check-circle me-2 gold-text"></i>Book on behalf of customers</li>
                        <li><i class="fas fa-check-circle me-2 gold-text"></i>Priority customer support</li>
                    </ul>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <div class="cta-icon-wrap mb-3">
                        <i class="fas fa-store-alt"></i>
                    </div>
                    <a href="<?php echo e(route('vendor.inquiry')); ?>" class="btn-cta-primary">
                        <i class="fas fa-rocket me-2"></i>Apply Now — It's Free
                    </a>
                    <p class="text-muted mt-2 small">Admin reviews within 24 hours</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Routes -->
<section class="routes-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-tag">Popular Routes</span>
            <h2 class="section-title">Top <span class="gold-text">Destinations</span></h2>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = [
                ['from'=>'Karachi','to'=>'Dubai','cat'=>'UAE','icon'=>'fa-city','price'=>'From PKR 28,000'],
                ['from'=>'Lahore','to'=>'Riyadh','cat'=>'KSA','icon'=>'fa-mosque','price'=>'From PKR 35,000'],
                ['from'=>'Islamabad','to'=>'Makkah','cat'=>'Umrah','icon'=>'fa-kaaba','price'=>'From PKR 55,000'],
                ['from'=>'Karachi','to'=>'Istanbul','cat'=>'Tour','icon'=>'fa-globe','price'=>'From PKR 95,000'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?php echo e(route('home')); ?>?category=<?php echo e($route['cat']); ?>" class="route-card">
                    <div class="route-icon"><i class="fas <?php echo e($route['icon']); ?>"></i></div>
                    <div class="route-info">
                        <div class="route-from-to"><?php echo e($route['from']); ?> → <?php echo e($route['to']); ?></div>
                        <div class="route-category"><?php echo e($route['cat']); ?></div>
                        <div class="route-price gold-text"><?php echo e($route['price']); ?></div>
                    </div>
                    <i class="fas fa-arrow-right route-arrow-icon"></i>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Activate correct tab based on URL
const urlParams = new URLSearchParams(window.location.search);
const cat = urlParams.get('category');
if (cat) {
    const tab = document.getElementById('tab-' + cat);
    if (tab) { new bootstrap.Tab(tab).show(); }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/home.blade.php ENDPATH**/ ?>