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
        <p>Hello,  'User'</p>
        <span>{{ $data['amount'] }}</span>
        @php



        @endphp
        <p>You are now Member of UBN </p>
        <p>Please Pay the following amount.</p>
        <p>After Successfull Payment You got your Username and Password in another Email </p>
        <p>Thank you.</p>

        <p> Click here to pay joining fees: {{ $data['amount'] }}</p>

        {{-- <form action="{{route('invitationPay')}}" target="_blank" method="post">
            @csrf
            <input type="hidden" name="personName" value="{{ $data['personName'] }}"/>
            <input type="hidden" name="invitedPersonFirstName" value="{{ $data['personName'] }}"/>
            <input type="hidden" name="invitedPersonLastName" value="{{ $data['personName'] }}"/>
            <input type="hidden" name="personEmail" value="{{ $data['personName'] }}"/>
            <input type="hidden" name="amount" value="{{ $data['personName'] }}"/>
            <input type="submit" class="btn btn-primary " value="Pay Now"/>
        </form> --}}
        <a href="{{ route('memberPayment') }}/{{ $data['email'] }}/{{ $data['amount'] }}" class="btn btn-primary ">Pay Now</a>
        
        
        
        {{-- <a href="{{ route('invitationPay') }}/{{ $personName }}/{{ $invitedPersonFirstName }}/{{ $invitedPersonLastName }}/{{ $personEmail }}/{{ $amount }}" class="btn btn-primary ">Pay Now</a> --}}
    </div>



</body>

</html>
