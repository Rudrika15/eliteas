@extends('layouts.master')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin: 20px 0;
            color: #333;
        }

        .network-container {
            position: relative;
            width: 600px;
            height: 600px;
            margin: 50px auto;
            border: 1px solid #ddd;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .center-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #007bff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #333;
            z-index: 2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .circle {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ff7043;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .line {
            position: absolute;
            width: 2px;
            background-color: #007bff;
            z-index: 1;
            transform-origin: top center;
        }
    </style>

    <body>
        <h1>Circle Network</h1>
        <div class="network-container" id="network">
            <div class="center-logo">Company Logo</div>
            <!-- Circles will be dynamically added here -->
        </div>

        <script>
            // Pass the entire circles collection from the backend to JavaScript
            const circles = @json($circles); // No need for .data anymore

            // Get the container
            const container = document.getElementById('network');

            // Radius for positioning circles
            const radius = 250; // Distance from the center
            const centerX = 300; // Center X-coordinate
            const centerY = 300; // Center Y-coordinate

            // Add each circle to the container
            circles.forEach((circle, index) => {
                const angle = (index / circles.length) * 2 * Math.PI; // Calculate angle
                const x = centerX + radius * Math.cos(angle) - 40; // Adjust X position
                const y = centerY + radius * Math.sin(angle) - 40; // Adjust Y position

                const circleDiv = document.createElement('div');
                circleDiv.className = 'circle';
                circleDiv.style.left = `${x}px`;
                circleDiv.style.top = `${y}px`;
                circleDiv.innerText = circle.circleName; // Display the circle name

                // Create the connection line between the logo and the circle
                const lineDiv = document.createElement('div');
                lineDiv.className = 'line';

                const dx = x + 40 - centerX; // Calculate horizontal distance
                const dy = y + 40 - centerY; // Calculate vertical distance
                const distance = Math.sqrt(dx * dx + dy * dy); // Calculate distance
                lineDiv.style.height = `${distance}px`; // Set line height
                lineDiv.style.top = `${centerY}px`;
                lineDiv.style.left = `${centerX}px`;
                lineDiv.style.transform = `rotate(${Math.atan2(dy, dx)}rad)`; // Rotate line to connect

                container.appendChild(lineDiv); // Add line to the container
                container.appendChild(circleDiv); // Add circle to the container
            });
        </script>
    @endsection
