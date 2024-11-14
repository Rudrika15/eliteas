<!doctype html>
<html lang="en">

<head>
    <title>UBN - Search User </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    {{-- add csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet" />
    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</head>

<body class="" style=" mix-blend-mode: multiply;">
    {{--

    <body class="" style=" mix-blend-mode: multiply; background: linear-gradient(to right, #1d2856, #e76a35);"> --}}
    <header>
        <!-- place navbar here -->
    </header>
    <main>

        <div class="pt-5 px-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-1">
                    <img src="{{ asset('img/logo4.png') }}" alt="UBN" class="pb-2" width="100"
                        style="max-width: 100%; height: auto;">
                </div>
                <div class="col-md-10">
                    <input type="text" name="query" id="searchInput"
                        placeholder="Enter circle name or member name..." class="form-control"
                        title="Enter search keyword">
                </div>
                <div class="col-auto">
                    <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                </div>
                <style>
                    @media (max-width: 425px) {
                        .col-auto {
                            margin-top: 30px;
                        }
                    }

                    @media (max-width: 786px) {
                        .col-auto {
                            margin-top: 10px;
                        }
                    }
                </style>
            </div>

            <style>
                @media (max-width: 768px) {
                    .col-md-1 {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                }
            </style>
        </div>
        <div class="container pt-5">
            <h3 class="text-muted mb-3">
                <div class="searchText"> </div>
            </h3>

            <div class="">
                <div id="searchResults">
                </div>
                {{-- @auth
                    <div class="mb-3">
                        You are logged in as {{ Auth::user()->id }}
                    </div>
                    @endauth

                    @guest
                    <div class="mb-3">
                        You are not logged in
                    </div>
                    @endguest --}}

            </div>
        </div>
    </main>
    <br>
    {{-- <div id="memberModal" class="modal">
            <div class="model-dialog">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modalContent"></div> <!-- This is the element to display member details -->
                </div>
            </div>
        </div> --}}



    {{-- <div class="modal" id="memberModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> --}}








    {{-- <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>FlipCode Solutions</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">FlipCode</a>
            </div>
        </footer><!-- End Footer --> --}}

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->



    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <div id="searchResults"></div>

    <style>
        /* LinkedIn-inspired styling */
        .card-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background-color: #fff;
            text-align: center;
            /* Center align text for LinkedIn look */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
            background-color: #e1e9ee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #0073b1;
            overflow: hidden;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .card-title {
            font-weight: bold;
            font-size: 16px;
            margin: 0;
            color: #0073b1;
            /* LinkedIn blue */
            cursor: pointer;
        }

        .card-text {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .btn-view-profile {
            background-color: #e76a35;
            color: #fff;
            border-radius: 25px;
            padding: 5px 15px;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-view-profile:hover {
            background-color: #e76a35;
        }
    </style>



    <script>
        var timeoutId;
        var inputElement = document.getElementById('searchInput');

        inputElement.addEventListener('input', function(event) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                var searchText = event.target.value;
                performSearch(searchText);
            }, 500);
        });

        function performSearch(query) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/searchQuery?query=' + encodeURIComponent(query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    displaySearchResults(response);
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };
            xhr.send();
        }

        function displaySearchResults(response) {
            var searchResultsElement = document.getElementById('searchResults');
            searchResultsElement.innerHTML = ''; // Clear previous results

            var cardContainer = document.createElement('div');
            cardContainer.classList.add('card-container');

            if (response && response.members && Array.isArray(response.members)) {
                response.members.forEach(function(member) {
                    var cardElement = document.createElement('div');
                    cardElement.classList.add('card');

                    var cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    // Profile image or initials
                    var profileImage = document.createElement('div');
                    profileImage.classList.add('profile-image');

                    if (member.profilePhoto) {
                        var imgElement = document.createElement('img');
                        imgElement.src = '/ProfilePhoto/' + member.profilePhoto;
                        profileImage.appendChild(imgElement);
                    } else {
                        profileImage.textContent = member.firstName.charAt(0) + member.lastName.charAt(0);
                    }

                    var cardTitle = document.createElement('h5');
                    cardTitle.classList.add('card-title');
                    cardTitle.textContent =
                        member.firstName.charAt(0).toUpperCase() +
                        member.firstName.slice(1) +
                        ' ' +
                        member.lastName.charAt(0).toUpperCase() +
                        member.lastName.slice(1);
                    cardTitle.addEventListener('click', function() {
                        var routeURL = '/foundPersonDetails/' + member.id;
                        window.location.href = routeURL;
                    });

                    var emailText = document.createElement('p');
                    emailText.classList.add('card-text');
                    emailText.textContent = member.user && member.user.email ? 'Email: ' + member.user.email : '';

                    var circleText = document.createElement('p');
                    circleText.classList.add('card-text');
                    circleText.textContent = 'Circle Name: ' + member.circle.circleName;

                    var viewProfileButton = document.createElement('button');
                    viewProfileButton.classList.add('btn', 'btn-view-profile');
                    viewProfileButton.textContent = 'View Profile';
                    viewProfileButton.addEventListener('click', function() {
                        var routeURL = '/foundPersonDetails/' + member.id;
                        window.location.href = routeURL;
                    });

                    // Append elements to card
                    cardBody.appendChild(profileImage);
                    cardBody.appendChild(cardTitle);
                    cardBody.appendChild(emailText);
                    cardBody.appendChild(circleText);
                    cardBody.appendChild(viewProfileButton);
                    cardElement.appendChild(cardBody);

                    cardContainer.appendChild(cardElement); // Append card to card container
                });
            } else {
                console.error('Invalid response format or missing data');
            }

            searchResultsElement.appendChild(cardContainer); // Append card container to results
        }
    </script>


    {{-- <script>
        // Paste your JavaScript code here
        // Declare a variable to hold the timeout ID
        var timeoutId;

        // Get the input element
        var inputElement = document.getElementById('searchInput');

        // Add event listener for input event
        inputElement.addEventListener('input', function(event) {
            // Clear any previous timeout
            clearTimeout(timeoutId);

            // Set a new timeout for 500 milliseconds
            timeoutId = setTimeout(function() {
                // Get the value of the input field
                var searchText = event.target.value;

                // Log the text to the console or perform any other action
                console.log('Text from input (after typing):', searchText);

                // Call your search function here
                console.log('searchText', searchText);

                performSearch(searchText);
            }, 500); // Adjust the delay time as needed
        });


        // Function to perform the search using AJAX
        function performSearch(query) {
            // Make an AJAX request
            var xhr = new XMLHttpRequest();
            console.log("query", query);

            xhr.open('GET', '/searchQuery?query=' + encodeURIComponent(query), true);

            // Set up the callback function for when the request is complete
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Request was successful
                    // Parse the response and display the search results
                    var response = JSON.parse(xhr.responseText);
                    displaySearchResults(response);
                } else {
                    // Request failed
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            // Send the request
            xhr.send();
        }

        // Function to display the search results
        function displaySearchResults(response) {
            var searchTextElement = document.querySelector('.searchText');
            var searchResultsElement = document.getElementById('searchResults');

            // Clear previous search results and messages
            searchTextElement.textContent = '';
            searchResultsElement.innerHTML = '';

            // Check if the response contains the expected structure
            if (response && response.message) {
                // Display search message
                searchTextElement.textContent = response.message;
            }
            console.log('response', response);

            if (response && response.members && Array.isArray(response.members)) {
                // Loop through the members array and create card elements
                response.members.forEach(function(member) {
                    console.log('member', member);
                    var cardElement = document.createElement('div');
                    cardElement.classList.add('card', 'mb-3');

                    var cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    // Name Row
                    var nameRow = document.createElement('div');
                    nameRow.classList.add('row');

                    var nameCol = document.createElement('div');
                    nameCol.classList.add('col-md-8');

                    var cardTitle = document.createElement('h5');
                    cardTitle.classList.add('card-title');
                    var nameText = document.createElement('span');
                    nameText.textContent = member.firstName + ' ' + member.lastName;
                    // Add click event listener to the card title (first name and last name)
                    nameText.addEventListener('click', function() {
                        // Get the route URL with the id concatenated
                        var routeURL = '/foundPersonDetails/' + member
                            .id; // Assuming the route follows this pattern

                        // Create an anchor tag
                        var anchorTag = document.createElement('a');

                        // Set the href attribute to the route URL
                        anchorTag.href = routeURL;

                        // Click the anchor tag to open the page
                        anchorTag.click();
                    });


                    nameText.style.cursor = "pointer";
                    cardTitle.appendChild(nameText); // Append the span element to the card title
                    nameCol.appendChild(cardTitle);
                    nameRow.appendChild(nameCol);

                    nameCol.appendChild(cardTitle);
                    nameRow.appendChild(nameCol);

                    // Email
                    if (member.user && member.user.email) {
                        var emailCol = document.createElement('div');
                        emailCol.classList.add('col-md-8', 'text-muted');

                        var cardEmail = document.createElement('p');
                        cardEmail.classList.add('card-text');
                        cardEmail.textContent = 'Email: ' + member.user.email;
                        emailCol.appendChild(cardEmail);

                        nameRow.appendChild(emailCol);
                    }

                    cardBody.appendChild(nameRow);

                    var cardText = document.createElement('p');
                    cardText.classList.add('card-text');
                    cardText.textContent = 'Circle Name: ' + member.circle.circleName; // Adjust as needed

                    // Button Element
                    var buttonWrapper = document.createElement('div');
                    // buttonWrapper.classList.add('text-end');

                    var button = document.createElement('button');
                    // button.innerHTML = `<i class="bi bi-person-plus-fill"></i> Connect`;
                    // button.classList.add('btn', 'btn-primary', 'btn-sm');

                    // Add click event listener to the button
                    button.addEventListener('click', function() {
                        // Perform action here when the button is clicked
                        // For example, make an AJAX call
                        console.log('clicked');
                        fetch('/connect', {
                                method: 'POST', // Adjust method as needed (e.g., 'GET', 'POST')
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                    // Add any additional headers if required
                                },
                                body: JSON.stringify({
                                    memberId: member.id // Assuming member ID is available
                                })
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                } else {
                                    throw new Error('Network response was not ok');
                                }
                            })
                            .then(data => {
                                console.log(data);
                                // Perform any further actions based on the response
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                            });
                    });

                    // Append elements to card body
                    cardBody.appendChild(cardText);

                    // Append button to wrapper
                    buttonWrapper.appendChild(button);

                    // Append card body and button wrapper to card element
                    cardElement.appendChild(cardBody);
                    // cardElement.appendChild(buttonWrapper);

                    // Append card element to search results container
                    searchResultsElement.appendChild(cardElement);
                });
            } else {
                console.error('Invalid response format or missing data');
            }
        }
    </script> --}}


    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- end -->

    @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: true,

            });
        </script>
    @endif

    @if (Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: true,
            });
        </script>
    @endif
</body>

</html>
