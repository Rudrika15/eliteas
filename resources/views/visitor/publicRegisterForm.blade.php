<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $visitorForm->circle->circleName ?? 'UBN Achievers' }} - Entrepreneurs Meeting Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Razorpay Checkout -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        :root {
            --ubn-navy: #1d2368;
            --ubn-navy-hover: #14194d;
            --bg-color: #f8fafc;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            padding-bottom: 60px;
        }

        .corp-container {
            max-width: 760px;
            margin: 0 auto;
        }

        /* Top Header Card */
        .corp-header-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            padding: 36px 40px;
            margin-bottom: 24px;
        }

        .header-main-title {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 2px;
            letter-spacing: -0.01em;
        }

        .header-sub-title {
            font-size: 26px;
            font-weight: 700;
            font-style: italic;
            color: #111827;
            margin-bottom: 24px;
        }

        .header-body-text {
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
        }

        .attend-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 20px;
        }

        .attend-list li {
            font-size: 15px;
            color: #1f2937;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
        }

        .attend-list li .check-icon {
            font-weight: 800;
            font-size: 16px;
            margin-right: 10px;
            color: #111827;
        }

        .event-detail-row {
            font-size: 15.5px;
            margin-bottom: 8px;
            color: #111827;
        }

        .venue-highlight {
            background-color: #2563eb;
            color: #ffffff;
            padding: 3px 10px;
            border-radius: 4px;
            font-weight: 700;
            display: inline-block;
        }

        /* Form Card */
        .corp-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            padding: 32px 40px;
            margin-bottom: 24px;
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--ubn-navy);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f5f9;
        }

        .corp-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .corp-label .text-danger {
            color: #dc2626 !important;
        }

        .corp-input, .corp-select {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease;
            width: 100%;
        }

        .corp-input:focus, .corp-select:focus {
            outline: none;
            border-color: var(--ubn-navy);
            box-shadow: 0 0 0 3px rgba(29, 35, 104, 0.12);
        }

        .corp-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%3c475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px 12px;
            padding-right: 40px;
            cursor: pointer;
        }

        .other-category-input {
            display: none;
            margin-top: 10px;
        }

        .btn-corp-submit {
            background-color: var(--ubn-navy);
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 6px rgba(29, 35, 104, 0.2);
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-corp-submit:hover {
            background-color: var(--ubn-navy-hover);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(29, 35, 104, 0.3);
        }

        .corp-footer {
            text-align: center;
            font-size: 12.5px;
            color: #64748b;
            margin-top: 24px;
        }

        @media (max-width: 576px) {
            .corp-header-card, .corp-card {
                padding: 24px 20px;
            }
            .header-main-title {
                font-size: 24px;
            }
            .header-sub-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4 py-md-5">
        <div class="corp-container">

            <!-- Main Form Content Container -->
            <div id="mainContentWrapper">

                <!-- Header Card Matching Reference Image Layout -->
                <div class="corp-header-card">
                    <div class="mb-4">
                        <img src="{{ asset('img/logo2.jpg') }}" alt="UBN Logo" style="height: 50px; object-fit: contain;">
                    </div>

                    <h1 class="header-main-title">{{ $visitorForm->circle->circleName ?? 'UBN Achievers' }}</h1>
                    <h2 class="header-sub-title">Entrepreneurs Meeting Registration</h2>

                    <div class="header-body-text">
                        @if($visitorForm->description)
                            <div class="mb-3 text-dark">
                                {!! nl2br(e($visitorForm->description)) !!}
                            </div>
                        @else
                            <p class="fw-bold text-dark fs-6 mb-2">
                                🚀 Join the {{ $visitorForm->circle->circleName ?? 'UBN Achievers' }} Entrepreneurs Meeting
                            </p>

                            <p class="mb-3 text-secondary">
                                Be part of an exclusive gathering of entrepreneurs, business owners, professionals, and industry leaders committed to growth through meaningful relationships and strategic networking.
                            </p>

                            <p class="fw-bold text-dark mb-2">Why Attend?</p>
                            <ul class="attend-list">
                                <li><span class="check-icon">✓</span> Build valuable business connections</li>
                                <li><span class="check-icon">✓</span> Exchange quality referrals and opportunities</li>
                                <li><span class="check-icon">✓</span> Learn from successful entrepreneurs and experts</li>
                                <li><span class="check-icon">✓</span> Discover new collaborations and growth possibilities</li>
                            </ul>
                        @endif

                        <div class="my-3">
                            @if($visitorForm->date)
                                <div class="event-detail-row">
                                    🗓️ <strong>Date:</strong> {{ \Carbon\Carbon::parse($visitorForm->date)->format('jS F Y') }}
                                </div>
                            @endif

                            @if($visitorForm->time)
                                <div class="event-detail-row">
                                    ⏰ <strong>Time:</strong> {{ \Carbon\Carbon::parse($visitorForm->time)->format('g:i A') }} Onwards
                                </div>
                            @endif

                            @if($visitorForm->venue)
                                <div class="event-detail-row">
                                    📍 <strong>Venue:</strong> <span class="venue-highlight">{{ $visitorForm->venue }}</span>
                                </div>
                            @endif

                            <div class="event-detail-row mt-2">
                                🎟️ <strong>Visitor Registration Fee:</strong>
                                @if($visitorForm->visitor_registration_fee > 0)
                                    <span class="text-danger fw-bold">₹{{ number_format($visitorForm->visitor_registration_fee, 2) }}</span>
                                @else
                                    <span class="text-success fw-bold">Free Registration</span>
                                @endif
                            </div>
                        </div>

                        <p class="mt-4 mb-2 text-secondary">
                            We look forward to welcoming you to an evening of networking, learning, and business growth.
                        </p>

                        <p class="fw-bold text-dark mb-0">
                            Kindly fill out the form below to confirm your participation.
                        </p>
                    </div>
                </div>

                <!-- Registration Form -->
                <form id="publicVisitorForm" method="POST" action="{{ route('visitor.public.storeForm') }}">
                    @csrf
                    <input type="hidden" name="code" value="{{ $code }}">

                    <!-- Form Main Card -->
                    <div class="corp-card">
                        <!-- Personal Info Section -->
                        <div class="form-section-title">
                            <i class="bi bi-person-vcard"></i> Personal Information
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="corp-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstName" id="firstName" class="form-control corp-input" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="corp-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastName" id="lastName" class="form-control corp-input" placeholder="Last Name" required>
                            </div>
                        </div>

                        <!-- Contact Details Section -->
                        <div class="form-section-title">
                            <i class="bi bi-telephone-inbound"></i> Contact Details
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="corp-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobileNo" id="mobileNo" class="form-control corp-input" placeholder="10-digit Mobile Number" maxlength="10" pattern="\d{10}" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="corp-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control corp-input" placeholder="name@example.com" required>
                            </div>
                        </div>

                        <!-- Business Details Section -->
                        <div class="form-section-title">
                            <i class="bi bi-briefcase"></i> Business Details
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="corp-label">Business / Organization Name <span class="text-danger">*</span></label>
                                <input type="text" name="businessName" id="businessName" class="form-control corp-input" placeholder="Enter Business Name" required>
                            </div>
                            <div class="col-12">
                                <label class="corp-label">Business Category <span class="text-danger">*</span></label>
                                <select name="businessCategory" id="businessCategory" class="form-select corp-select" onchange="checkCategory(this.value)" required>
                                    <option value="" disabled selected>Select Business Category</option>
                                    @foreach($businessCategory as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->categoryName }}</option>
                                    @endforeach
                                    <option value="other">Other (Specify below)</option>
                                </select>
                                <div id="otherCategoryDiv" class="other-category-input">
                                    <input type="text" name="otherCategory" id="otherCategory" class="form-control corp-input" placeholder="Specify your business category">
                                </div>
                            </div>
                        </div>

                        <!-- Member Reference Section -->
                        <div class="form-section-title">
                            <i class="bi bi-people"></i> Invitation Reference
                        </div>
                        <div class="mb-4">
                            <label class="corp-label">Invited By (Member)</label>
                            <select name="invitedBy" id="invitedBy" class="form-select corp-select">
                                <option value="0" selected>None / Direct Visitor</option>
                                @foreach($members as $mem)
                                    <option value="{{ $mem->id }}">{{ $mem->firstName }} {{ $mem->lastName }}@if(!empty($mem->companyName)) ({{ $mem->companyName }})@endif</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="button" id="submitRegisterBtn" class="btn btn-corp-submit">
                                {{ $visitorForm->visitor_registration_fee > 0 ? 'Pay ₹' . number_format($visitorForm->visitor_registration_fee, 2) . ' & Submit Registration' : 'Submit Registration' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Completion Card (Shown after registration) -->
            <div id="successCompletionCard" class="corp-card text-center py-5 d-none">
                <div class="mb-4">
                    <img src="{{ asset('img/logo2.jpg') }}" alt="UBN Logo" style="height: 55px; object-fit: contain;" class="mb-3 d-block mx-auto">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 64px;"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Registration Successful!</h2>
                <h5 class="text-secondary mb-4">Your response has been recorded.</h5>
                <p class="text-muted mb-4 px-md-4">
                    Thank you for registering for the <strong>{{ $visitorForm->circle->circleName ?? 'UBN' }}</strong> Entrepreneurs Meeting. We look forward to welcoming you!
                </p>

                <div class="p-3 bg-light rounded-3 d-inline-block mb-4 border" style="max-width: 420px; width: 100%;">
                    <span class="text-secondary small">
                        <i class="bi bi-clock-history me-1 text-primary"></i>
                        This page will automatically close in <strong id="closeCountdown" class="text-dark fs-6">5</strong> seconds.
                    </span>
                </div>

                <div>
                    <button type="button" onclick="closeOrDone()" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i> Close Tab Now
                    </button>
                </div>
            </div>

            <div class="corp-footer">
                <i class="bi bi-shield-check text-success me-1"></i> Secure Form Submission • {{ $visitorForm->circle->circleName ?? 'UBN' }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function checkCategory(val) {
            var otherDiv = document.getElementById('otherCategoryDiv');
            if (val === 'other') {
                otherDiv.style.display = 'block';
                document.getElementById('otherCategory').setAttribute('required', 'required');
            } else {
                otherDiv.style.display = 'none';
                document.getElementById('otherCategory').removeAttribute('required');
            }
        }

        document.getElementById('submitRegisterBtn').addEventListener('click', function(e) {
            e.preventDefault();
            var form = document.getElementById('publicVisitorForm');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var fee = parseFloat("{{ $visitorForm->visitor_registration_fee }}");

            if (fee > 0) {
                // Razorpay Payment Integration
                var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                var amountInPaise = fee * 100;
                var firstName = document.getElementById('firstName').value;
                var lastName = document.getElementById('lastName').value;
                var email = document.getElementById('email').value;
                var mobileNo = document.getElementById('mobileNo').value;

                var options = {
                    "key": razorpayKey,
                    "amount": amountInPaise,
                    "currency": "INR",
                    "name": "Visitor Registration Fee",
                    "description": "{{ $visitorForm->circle->circleName ?? 'Visitor Form' }} Fee",
                    "image": "{{ asset('img/logo2.jpg') }}",
                    "handler": function (response) {
                        submitFormWithPayment(response.razorpay_payment_id);
                    },
                    "prefill": {
                        "name": firstName + ' ' + lastName,
                        "email": email,
                        "contact": mobileNo
                    },
                    "theme": {
                        "color": "#1d2368"
                    }
                };

                var rzp = new Razorpay(options);
                rzp.open();
            } else {
                // Direct Submission (Free Fee)
                submitFormDirect();
            }
        });

        function showSuccessCompletion() {
            document.getElementById('mainContentWrapper').classList.add('d-none');
            var successCard = document.getElementById('successCompletionCard');
            successCard.classList.remove('d-none');

            var seconds = 5;
            var countdownEl = document.getElementById('closeCountdown');

            var interval = setInterval(function() {
                seconds--;
                if (countdownEl) {
                    countdownEl.textContent = seconds;
                }
                if (seconds <= 0) {
                    clearInterval(interval);
                    closeOrDone();
                }
            }, 1000);
        }

        function closeOrDone() {
            window.close();
            // Fallback message if browser blocks auto window.close()
            setTimeout(function() {
                var countdownParent = document.getElementById('closeCountdown')?.parentElement;
                if (countdownParent) {
                    countdownParent.innerHTML = '✅ Registration Complete. You may now close this browser tab.';
                }
            }, 300);
        }

        function submitFormDirect() {
            var form = document.getElementById('publicVisitorForm');
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: 'Your response has been recorded.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        showSuccessCompletion();
                    });
                    // Fallback timer if user doesn't dismiss alert
                    setTimeout(showSuccessCompletion, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: data.message || 'Failed to submit registration. Please try again.',
                        confirmButtonColor: '#1d2368'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    confirmButtonColor: '#1d2368'
                });
            });
        }

        function submitFormWithPayment(paymentId) {
            var form = document.getElementById('publicVisitorForm');
            var formData = new FormData(form);
            formData.append('paymentId', paymentId);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment & Registration Successful!',
                        text: 'Your response has been recorded.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        showSuccessCompletion();
                    });
                    setTimeout(showSuccessCompletion, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Error',
                        text: data.message || 'Payment received but failed to complete registration.',
                        confirmButtonColor: '#1d2368'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred after payment. Please contact support.',
                    confirmButtonColor: '#1d2368'
                });
            });
        }
    </script>
</body>

</html>
