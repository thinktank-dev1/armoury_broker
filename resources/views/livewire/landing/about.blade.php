<div>
    <div class="section head about-bg" wire:ignore.self>
        <div class="head-back">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title text-center">
                            <h3 class="text-white mt-3">ABOUT ARMOURY BROKER</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section suppor-section pt-5">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="page-title">South Africa's trusted marketplace for the tactical<br /> and outdoor equipment community</h3>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <b class="text-21">Structured, verified, and built around the people who live the lifestyle.</b>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="about-box1 card">
                        <div class="card-body">
                            <div class="about-box1-head mb-2">
                                <b class="text-21">REGISTERED USERS</b>
                            </div>
                            <h3 class="about-box1-count bold-700">{{ $user_count }}</h3>
                            <b class="about-box1-foot-text text-muted">Verified members</b>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-box1 card">
                        <div class="card-body">
                            <div class="about-box1-head mb-2">
                                <b class="text-21">LISTED ITEMS</b>
                            </div>
                            <h3 class="about-box1-count bold-700">{{ $product_count }}</h3>
                            <b class="about-box1-foot-text text-muted">Active listings</b>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-box1 card">
                        <div class="card-body">
                            <div class="about-box1-head mb-2">
                                <b class="text-21">ITEMS SOLD</b>
                            </div>
                            <h3 class="about-box1-count bold-700">{{ $sold_count }}</h3>
                            <b class="about-box1-foot-text text-muted">Completed transactions</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card about-bg-grey h-100">
                        <div class="card-body">
                            <img src="{{ asset('img/about_who_we_are_Icon.png') }}">
                            <div class="py-3">
                                <h3 class="page-title">WHO WE ARE</h3>
                            </div>
                            <p>Armoury Broker is South Africa’s first managed marketplace built exclusively for the tactical and outdoor equipment community.</p>
                            <p>Individuals and businesses can buy and sell new and used goods across a wide range of categories, including optics, archery equipment, tactical gear, safes, outdoor vehicles, and adventure kit.</p>
                            <p>We exist for one reason: to bring structure, safety, and trust to a market that has long operated without it.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card about-bg-problem h-100">
                        <div class="card-body">
                            <img src="{{ asset('img/about_problem_solving_icon.png') }}">
                            <div class="py-3">
                                <h3 class="page-title text-white">THE PROBLEM WE ARE SOLVING</h3>
                            </div>
                            <p class="text-white">South Africa’s outdoor and tactical resale market is large and growing, but it has always lacked a safe, structured home. Transactions happen across Facebook groups, WhatsApp threads, and Telegram communities with no oversight, no verification, and no recourse when things go wrong.</p>
                            <p class="text-white">Fraud is common. Buyers pay for goods that never arrive. Sellers hand over items and never receive payment. The community deserves better.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card about-cta-bg">
                        <div class="card-body">
                            <div class="my-4">
                                <h3 class="page-title text-white">SECURE  |  VERIFIED  |  RELIABLE </h3>
                            </div>
                            <div class="mb-4">
                                <b class="text-white">The trading platform built specifically for South Africa’s tactical and outdoor equipment community.</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section suppor-section pt-5">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="page-title">HOW WE SOLVE IT</h3>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <b class="text-21">Armoury Broker replaces informal channels with a fully managed platform.</b><br />
                    <b class="text-21">Every user is verified before transacting. Every transaction is covered by secure escrow.</b>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-lg-6">
                    <div class="card about-bg-grey about-card-bordered h-100 py-3">
                        <div class="card-body">
                            <h3 class="page-title">WHAT IS ESCROW</h3>
                            <p>When a purchase is made, Armoury Broker holds the buyer’s payment securely.</p>
                            <p>Funds are only released to the seller once the buyer confirms the goods have arrived as described. Neither party can be left out of pocket.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card about-bg-grey h-100">
                        <div class="card-body">
                            <p>Every verified user gets their own storefront, their “Armoury”, to list items, manage stock, and trade with confidence. Buyers browse knowing what they see is what they will receive. Every dispute has a clear resolution path.</p>
                            <p>We support individual sellers and registered businesses alike, in a single trusted environment fully compliant with South African consumer protection, data privacy, and financial legislation.</p>
                            <div class="">
                                <a href="{{ url('auth/login') }}" class="btn btn-secondary">GET STARTED</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <h3 class="page-title">OUR VISION</h3>
                    </div>
                    <p>This community values <b>quality, authenticity, and trust</b> above all else.</p>
                    <p>Armoury Broker is the foundation of a circular economy built around those values. Better tools. Better protection. Better access to the gear that fuels the lifestyle.</p>
                    <div class="">
                        <a href="{{ url('auth/login') }}" class="btn btn-secondary">SIGN UP</a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 text-center">
                    <img src="{{ asset('img/about_image_3.png') }}" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>
    <div class="section about-contact-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="mb-3">
                        <h3 class="page-title text-white">CONTACT US</h3>
                    </div>
                    <p class="text-white">Have a question or just want to know more? <b>We are here to help</b>.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card about-contact-card">
                        <div class="card-body">
                            <div class="about-contact-head d-flex align-items-center">
                                <img src="{{ asset('img/Address Icon.png') }}" style="height: 20px; vertical-align: middle;"> 
                                <b class="ms-2">ADDRESS</b>
                            </div>
                            <div class="about-contact-body mt-4">
                                <b>Westfield Road</b><br />
                                <p class="text-white pt-2">Modderfontein, Johannesburg</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card about-contact-card">
                        <div class="card-body">
                            <div class="about-contact-head d-flex align-items-center">
                                <img src="{{ asset('img/Whatsapp Icon.png') }}" style="height: 20px; vertical-align: middle;"> 
                                <b class="ms-2">WHATSAPP</b>
                            </div>
                            <div class="about-contact-body mt-4">
                                <b>063 791 8959</b><br />
                                <p class="text-white pt-2">Messages only, no voice calls</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card about-contact-card">
                        <div class="card-body">
                            <div class="about-contact-head d-flex align-items-center">
                                <img src="{{ asset('img/Email Icon.png') }}" style="height: 20px; vertical-align: middle;"> 
                                <b class="ms-2">EMAIL</b>
                            </div>
                            <div class="about-contact-body mt-4">
                                <b>info@armourybroker.com</b><br />
                                <p class="text-white pt-2">Email us directly</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card about-contact-card">
                        <div class="card-body">
                            <div class="about-contact-head d-flex align-items-center">
                                <img src="{{ asset('img/Support Icon.png') }}" style="height: 20px; vertical-align: middle;"> 
                                <b class="ms-2">SUPPORT HOURS</b>
                            </div>
                            <div class="about-contact-body mt-4">
                                <b>Mon to Fri, 08:00 to 17:00</b><br />
                                <p class="text-white pt-2">Excluding public holidays</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mt-5">
                    <p class="text-white">Fill in our quick and easy contact form, and we’ll be in touch.</p>
                    <a href="{{ url('support#contact') }}" class="btn btn btn-primary-outline btn-white-alt">CONTACT FROM</a>
                </div>
            </div>
        </div>
    </div>
</div>