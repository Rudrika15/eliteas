<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- add csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Meeting Invitation</title>
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
        <h1>Meeting Invitation</h1>
        <p>Hello {{ $data['personName'] }},</p>
        <span>{{ $data['personEmail'] }}</span>
        <p>You are invited to a meeting by {{ $data['invitedPersonFirstName'] }} {{ $data['invitedPersonLastName'] }}.</p>
        <p>Please join us at the scheduled time.</p>
        <p>Thank you.</p>

        <p> Click here to pay joining fees: {{ $data['amount'] }}</p>

        {{-- <a href="{{ route('invitationPay') }}/{{ $personName }}/{{ $invitedPersonFirstName }}/{{ $invitedPersonLastName }}/{{ $personEmail }}/{{ $amount }}" class="btn btn-primary ">Pay Now</a> --}}
        <a href="{{ route('invitationPay') }}/{{ $data['personName'] }}/{{ $data['invitedPersonFirstName'] }}/{{ $data['invitedPersonLastName'] }}/{{ $data['personEmail'] }}/{{ $data['amount'] }}" class="btn btn-primary ">Pay Now</a>
    </div>




</body>

</html>
