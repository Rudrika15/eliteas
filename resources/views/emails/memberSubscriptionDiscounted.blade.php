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

    {{-- {{ $data['email'] }}
    {{ $data['amount'] }}
    {{ $data['totalAmount'] }}
    {{ $data['originalAmount'] }} --}}
    {{-- {{ $data['membershipType'] }} --}}



    <div class="container">
        <h1>Subscription Payment</h1>
        <p><b>Hello,</b> Dear User</p>
        {{-- <span>{{ $data['amount'] }}</span> --}}
        @php

        @endphp
        <p>You are now a Member of <b style="color: #0056b3">UBN</b></p>
        {{-- <p>Congratulations! You have received a Discount on your {{ $data['membershipType'] }} membership
            subscription.</p> --}}
        <p>Congratulations! You have received a Discount on your Membership Subscription.</p>
        <p>The Original amount of your Membership is <b style="color: red">₹ {{ $data['originalAmount']
                }}</b>
            <br> And after discount payable amount is <b><strike style="color: red">₹ {{ $data['originalAmount']
                    }}</strike></b> <b style="color: green">₹ {{ $data['amount'] }}</b>
        </p>
        <p>Please pay the following discounted amount.</p>
        <p>After a <b style="color: green">Successful!</b> payment, you will receive your login details in another
            email.</p>
        <p>Thank you.</p>

        <p>Click here to pay the joining fees: <b style="color: royalblue">₹ {{ $data['amount'] }}</b></p>
        {{-- <form action="{{route('invitationPay')}}" target="_blank" method="post">
            @csrf
            <input type="hidden" name="personName" value="{{ $data['personName'] }}" />
            <input type="hidden" name="invitedPersonFirstName" value="{{ $data['personName'] }}" />
            <input type="hidden" name="invitedPersonLastName" value="{{ $data['personName'] }}" />
            <input type="hidden" name="personEmail" value="{{ $data['personName'] }}" />
            <input type="hidden" name="amount" value="{{ $data['personName'] }}" />
            <input type="submit" class="btn btn-primary " value="Pay Now" />
        </form> --}}
        @php
        $paymentData = ["amount" => $data['amount'], "email" => $data['email'], "totalAmount" => $data['totalAmount'],
        "originalAmount" => $data['originalAmount'], "membershipType" => $data['membershipType'] ];
        @endphp

        {{-- <button type="button" class="btn btn-primary"
            onclick="window.location.href='{{ route('memberPayment', Crypt::encrypt($paymentData)) }}'"
            class="btn btn-primary w-100">Pay Now</button> --}}
        <a href="{{ route('memberPayment', Crypt::encrypt($paymentData)) }}" class="btn btn-primary ">Pay Now</a>



        {{-- <a
            href="{{ route('invitationPay') }}/{{ $personName }}/{{ $invitedPersonFirstName }}/{{ $invitedPersonLastName }}/{{ $personEmail }}/{{ $amount }}"
            class="btn btn-primary ">Pay Now</a> --}}
    </div>



</body>

</html>