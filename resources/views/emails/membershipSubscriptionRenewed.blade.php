<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- add csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Subscription Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin-bottom: 10px;
            color: #666;
        }



        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Subscription Payment</h1>
        <p>Hello, {{ $user->firstName }} {{ $user->lastName }}</p>
        {{-- <span>{{ $data['amount'] }}</span> --}}
        @php
        @endphp
        {{-- {{$user}} --}}
        <p>Your Membership has been renewed successfully. </p>
        {{-- <p>Your Membership is expiring on {{ date('d-m-y', strtotime($user->memberSubscriptions->validity)) }}</p>
        --}}
        <p><strong>Membership Type:</strong> {{ $subscription->membershipType }}</p>
        <p>Your new membership validity is until {{ date('d-m-y', strtotime($subscription->validity)) }}</p>
        <p>Thank you for being a valued member of our community!</p>
    </div>
</body>

</html>
