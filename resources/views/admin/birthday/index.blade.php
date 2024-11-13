<!doctype html>
<html lang="en">

<head>
    <title>Birthday Post Editor</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
        /* Styling for the profile photo and overlay */
        .photo-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            /* Adjust as needed */
            margin: auto;
        }

        #profilePhoto,
        #templateOverlay {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 8px;
        }

        #templateOverlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            pointer-events: none;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <main class="container my-5">
        <div class="row">
            <!-- Profile Photo and Info -->
            <div class="col-md-7 text-center">
                <div class="card shadow-sm border border-3 mb-4">
                    <div class="card-body">
                        <div class="photo-container">
                            <img id="profilePhoto" src="{{ asset('ProfilePhoto') }}/{{ $person->profilePhoto }}" class="img-fluid" alt="Profile Photo">
                            <img id="templateOverlay" src="" class="img-fluid" alt="Template Overlay">
                        </div>
                        <h3 class="card-title">{{ $person->firstName }}'s Birthday</h3>
                        <p class="card-text">Create a special birthday message for {{ $person->firstName }}!</p>
                    </div>
                </div>
            </div>

            <!-- Template Sidebar -->
            <div class="col-md-5 mt-4">
                <div class="card shadow-sm border border-3">
                    <div class="card-body">
                        <h5 class="card-title">Select a Template</h5>
                        <div class="row gy-3">
                            @foreach ($templates as $template)
                                <div class="col-12">
                                    <img class="img-fluid rounded border border-2" src="{{ asset('templateImage') }}/{{ $template->templateImage }}" alt="Template Image" onclick="setTemplate('{{ asset('templateImage') }}/{{ $template->templateImage }}')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript to Set Template as Overlay -->
    <script>
        function setTemplate(imageUrl) {
            document.getElementById('templateOverlay').src = imageUrl;
        }
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
