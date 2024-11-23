<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>

    <!-- CSS Section -->
    <style>
        /* Global Styles */
        body,
        html {
            background: #ffffff;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Wrapper Styles */
        #wrapper {
            width: 600px;
            margin: 15% auto 0 auto;
            text-align: center;
        }

        /* Heading Styles */
        h1 {
            color: #e76a35;
            text-shadow: -1px -2px 3px rgba(0, 0, 0, 0.3);
            font-family: "Montserrat", sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 80px;
            margin-bottom: -5px;
        }

        h1 underline {
            display: block;
            border-top: 5px solid rgba(231, 106, 53, 0.3);
            border-bottom: 5px solid rgba(231, 106, 53, 0.3);
        }

        /* Subheading Styles */
        .message {
            width: 570px;
            margin: 16px auto;
            font-family: "Lato", sans-serif;
            font-weight: 600;
            color: #1d3268;
            font-size: 18px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- Wrapper -->
    <div id="wrapper" class="animated zoomIn">
        <!-- Main Heading -->
        <h1>
            <underline>Thank you!</underline>
        </h1>

        <!-- Messages Section -->
        <div class="message">
            <p>Your registration for the event has been successfully completed.</p>
            <p>Details regarding slot booking will be sent to your registered email shortly.</p>
        </div>

                <a href="{{route('login')}}" class="btn btn-primary">Back to Home</a>
    </div>

    <!-- JavaScript Section -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add hover effect on the h1 tag
            $("h1").hover(
                function() {
                    $(this).addClass("animated infinite pulse"); // Add animation
                },
                function() {
                    $(this).removeClass("animated infinite pulse"); // Remove animation
                }
            );
        });
    </script>
</body>

</html>
