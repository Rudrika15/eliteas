    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold">Please Fill Up this Details</h5>

            </div>

            <hr class="my-0">

            <form class="p-4 needs-validation" method="post" action="{{ route('storeForm') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-3">
                    <!-- Circle -->
                    <div class="col-md-6">
                        <label class="form-label">Circle</label>
                        <input type="text" class="form-control" value="{{ $circleName }}" readonly>
                        <input type="hidden" name="circleId" value="{{ $circleId }}">
                    </div>


                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="text" class="form-control" name="mobileNo" required>
                    </div>

                    <!-- Instagram -->
                    <div class="col-md-6">
                        <label class="form-label">Instagram ID</label>
                        <input type="text" class="form-control" name="instaId">
                    </div>

                    <!-- LinkedIn -->
                    <div class="col-md-6">
                        <label class="form-label">LinkedIn ID</label>
                        <input type="text" class="form-control" name="linkedinId">
                    </div>

                    <!-- Presentation -->
                    <div class="col-md-12">
                        <label class="form-label">Presentation Introduction</label>
                        <textarea class="form-control" name="pre_intro" rows="3"></textarea>
                    </div>

                    <!-- Business Name -->
                    <div class="col-md-6">
                        <label class="form-label">Business Name</label>
                        <input type="text" class="form-control" name="business_name" required>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label">Your Business Category</label>
                        <select class="form-select" name="b_category_id" required>
                            <option disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>

                    <!-- Products/Services -->
                    <div class="col-md-12">
                        <label class="form-label">Business Products or Services</label>
                        <textarea class="form-control" name="product_service" rows="3"></textarea>
                    </div>

                    <!-- Website -->
                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <input type="url" class="form-control" name="website">
                    </div>

                    <!-- Birthday -->
                    <div class="col-md-3">
                        <label class="form-label">Birthday</label>
                        <input type="date" class="form-control" name="birthdate">
                    </div>

                    <!-- Anniversary -->
                    <div class="col-md-3">
                        <label class="form-label">Anniversary</label>
                        <input type="date" class="form-control" name="anniversaryDate">
                    </div>

                    <!-- Company Logo -->
                    <div class="col-md-6">
                        <label class="form-label">Company Logo</label>
                        <input type="file" class="form-control" name="companyLogo" accept="image/*">
                    </div>

                    <!-- Photo -->
                    <div class="col-md-6">
                        <label class="form-label">Photo</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 me-2">✅ Submit</button>
                    <button type="reset" class="btn btn-secondary px-4">♻️ Reset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Copy Link Script -->
    <script>
        function copyLink(circleId, circleName) {
            fetch(`{{ url('/encrypt-circle-id') }}?id=${circleId}&name=${encodeURIComponent(circleName)}`)
                .then(response => response.json())
                .then(data => {
                    const link = `${window.location.origin}${window.location.pathname}?cid=${encodeURIComponent(data.id)}&cname=${encodeURIComponent(data.name)}`;
                    navigator.clipboard.writeText(link)
                        .then(() => alert('🔒 Encrypted link copied!'))
                        .catch(() => alert('❌ Copy failed!'));
                });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success 🎉',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
