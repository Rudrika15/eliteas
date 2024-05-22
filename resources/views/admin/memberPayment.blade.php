<!doctype html>
<html lang="en">

<head>
    <title>Payment Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<style>
    body {
        background-color: #f8f9fa;
    }

    .card-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .card-content {
        margin-bottom: 20px;
        color: #666;
    }

    .btn-pay {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-pay:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<body>
    @if (Session::has('data'))
    <div class="container mt-5">
        <div class="card-container p-4">
            <p>The payable amount is for</p>
            <h3 class="card-title" id="amount">₹ {{ session('data')['amount'] }}</h3>
            <button type="button" class="btn btn-pay pay">Pay Now</button>
        </div>
    </div>
    @endif

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all elements with the 'pay' class
            var payButtons = document.querySelectorAll('.pay');

            // Loop through each pay button and attach the click event handler
            payButtons.forEach(function (button) {
                button.addEventListener('click', function (e) {
                    // Get the amount and convert it to the smallest currency unit
                    var amountElement = document.querySelector('#amount');
                    var amountText = amountElement.textContent.trim();
                    var amount = parseInt(amountText.replace('₹', '').trim()) * 100;

                    // Razorpay options
                    var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}", // Razorpay key from environment
                        "amount": amount,
                        "currency": "INR",
                        "name": "UBN",
                        "description": "Razorpay payment",
                        "image": "", // Add your logo URL here if needed
                        "handler": function (response) {
                            // Handle the response after payment
                            console.log(response);
                            var paymentId = response.razorpay_payment_id;
                            storePaymentId(paymentId, amount);
                        },
                        "prefill": {
                            "name": "abcd", // Replace with actual prefill name if needed
                            "email": "abcd" // Replace with actual prefill email if needed
                        },
                        "theme": {
                            "color": "#012e6f"
                        }
                    };
                    console.log(options);
                    var rzp = new Razorpay(options);
                    rzp.open();
                });
            });
        });

        function storePaymentId(paymentId = '', amount = '') {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('razorpay.payment.membershipPayment') }}`;
            var email = "{{ request('email') }}";
            var membershipType = $('#membershipType').val();
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    paymentId: paymentId,
                    amount: amount,
                    email: email,
                }),
            })
            .then(response => {
                console.log('Payment ID stored successfully');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Your Payment is Successfull',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                        // or
                        // window.location.href = "{{ route('home') }}";
                        // window.location.reload();
                    }
                });
            })
            .catch(error => {
                console.error('Error storing payment ID: ', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to store payment ID',
                });
            });
        }
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>