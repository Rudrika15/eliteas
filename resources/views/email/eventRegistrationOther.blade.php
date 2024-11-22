<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Event Registration Confirmation</title>
    <meta name="description" content="Event Registration Confirmation Email">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            color: #333;
        }

        table {
            border-spacing: 0;
            width: 100%;
            background-color: #f4f4f7;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .email-header {
            text-align: center;
            padding: 20px 0;
        }

        .email-header img {
            width: 100px;
        }

        .email-body {
            padding: 40px;
            color: #555;
            margin: 0 10px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 15px 0;
            color: #555;
        }

        li {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f7;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 0;
        }

        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <table class="email-wrapper">
                    <tr class="email-header">
                        <td>
                            <a href="{{ url('/') }}" target="_blank">
                                <img src="{{ asset('img/logo2.jpg') }}" alt="UBN Community Logo">
                            </a>
                        </td>
                    </tr>
                    <tr class="email-body">
                        <td>
                            <h2>Thank You for Registering!</h2>
                            <p>Dear <b> {{ $eventDetails['firstName'] ?? 'User' }},</b></p>

                            <p>If you want to register for any other events, please note that you will need to use the same
                                email address and password as below to ensure a smooth registration process.</p>


                            <p>We are excited to confirm your registration for the event
                                <strong>{{ $eventDetails['title'] }}</strong>!
                            </p>
                            <p><strong>Event Details:</strong></p>
                            <ul>
                                <li><strong>Event Name:</strong> {{ $eventDetails['title'] ?? 'Not Available' }}</li>
                                <li><strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($eventDetails['event_date'])->format('d-m-Y') }}</li>
                                <li><strong>Location:</strong> {{ $eventDetails['venue'] ?? 'To Be Decided' }}</li>
                            </ul>
                            <p>Slot booking has not started yet. Please wait for further updates. Once booking starts,
                                we will notify you via email.</p>
                            <p>When the booking opens, you can visit this link to reserve your slot:</p>
                            <p style="font-weight: bold; color: red;">Please note that you will need to use the same
                                email address when booking your slot to ensure a smooth registration process.</p>
                            <p><a href="{{ url('/booking') }}" class="button">Reserve Your Slot</a></p>
                            <p>We look forward to seeing you there!</p>

                                <b>Here is Your Email & Password</b>

                            <p><strong>Email: </strong>{{ $eventDetails['email'] ?? 'Not Available' }}</p>
                            <p><strong>Password: </strong>{{ $eventDetails['password'] ?? 'Not Available' }}</p>



                        </td>
                    </tr>
                    <tr class="footer">
                        <td>
                            <p>&copy; {{ date('Y') }} UBN. All rights reserved.</p>
                            <p>If you have any questions or need assistance, feel free to contact us at
                                <a href="mailto:support@ubncommunity.com">support@ubncommunity.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
