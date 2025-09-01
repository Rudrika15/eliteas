<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 15px;
            /* border: 2px solid linear-gradient(to right, #e66465, #9198e5); */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            /* Max width for the card */
            overflow: hidden;
            position: relative;
        }

        .card-header-top {
            background-color: #e0e7ff;
            /* Light blue background for "TOP IBM" */
            color: #333;
            font-weight: 600;
            padding: 8px 15px;
            text-align: right;
            font-size: 0.85rem;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-header-bg {
            background-image: url('https://placehold.co/400x120/555/fff?text=Background');
            /* Placeholder background image */
            background-size: cover;
            background-position: center;
            height: 100px;
            /* Height for the background image section */
            position: relative;
        }

        .profile-img-container {
            position: absolute;
            top: 50px;
            /* Adjust to overlap with the background */
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            border: 5px solid #fff;
            /* White border around profile image */
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            /* Remove extra space below image */
        }

        .badge-g {
            position: absolute;
            bottom: 40px;
            right: -15px;
            background-color: #f8c100;
            /* Yellow for 'G' badge */
            color: #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 0.9rem;
            border: 2px solid #fff;
            /* White border for the badge */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }

        .profile-details {
            padding-top: 60px;
            /* Space for the overlapping profile image */
            text-align: center;
            padding-bottom: 20px;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-title {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 20px;
        }

        .stats-section,
        .category-section {
            display: flex;
            justify-content: space-around;
            padding: 15px 0;
            border-top: 1px solid #eee;
        }

        .stats-item,
        .category-item {
            text-align: center;
            flex: 1;
            padding: 0 10px;
        }

        .category-item {
            border-right: 1px solid #eee;
        }

        .stats-item:first-child,
        .category-item:first-child {
            /* border-right: 1px solid #eee; */
        }

        .stats-icon,
        .category-icon {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 8px;
        }

        .stats-text,
        .category-text {
            font-size: 0.9rem;
            color: #555;
            font-weight: 500;
        }

        .category-text.main {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }

        .action-buttons {
            display: flex;
            border-top: 1px solid #eee;
        }

        .action-button {
            flex: 1;
            padding: 15px 0;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            /* Bootstrap primary blue */
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .action-button:hover {
            background-color: #f8f9fa;
            /* Light hover effect */
        }

        .action-button:first-child {
            border-right: 1px solid #eee;
        }

        .action-button i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .profile-card {
                margin: 10px;
            }

            .profile-img-container {
                top: 60px;
                /* Adjust for smaller screens if needed */
            }

            .profile-details {
                padding-top: 50px;
            }

            .profile-name {
                font-size: 1.3rem;
            }

            .profile-title {
                font-size: 0.85rem;
            }

            .stats-icon,
            .category-icon {
                font-size: 1.3rem;
            }

            .stats-text,
            .category-text {
                font-size: 0.8rem;
            }

            .category-text.main {
                font-size: 1rem;
            }

            .action-button {
                font-size: 0.9rem;
                padding: 12px 0;
            }
        }
    </style>

</head>

<body>
    <div class="profile-card bg-white">
        <div class="card-header-top text-center rounded-top">
            TOP IBM
        </div>
        <div class="card-header-bg">
            <div class="profile-img-container">
                <img src="https://placehold.co/100x100/007bff/fff?text=JD" alt="John Doshi" class="profile-img">
                <div class="badge-g">G</div>
            </div>
        </div>
        <div class="profile-details">
            <h2 class="profile-name">John Doshi</h2>
            <p class="profile-title">Vice President at UBN</p>
        </div>

        <div class="stats-section">
            <div class="stats-item">
                <i class="fas fa-circle stats-icon"></i>
                <div class="stats-text">Circle</div>
                <div class="stats-text">Pinnacle</div>
            </div>
            <div class="stats-item">
                <i class="fas fa-handshake stats-icon"></i>
                <div class="stats-text">Meetings</div>
                <div class="stats-text">51</div>
            </div>
        </div>

        <div class="category-section">
            <div class="category-item">
                <i class="fas fa-sushi category-icon"></i>
                <div class="category-text">SUSHI</div>
                <div class="category-text">CubX</div>
                <div class="category-text">Technologies</div>
            </div>
            <div class="category-item">
                <i class="fas fa-cogs category-icon"></i>
                <div class="category-text">Category</div>
                <div class="category-text main">Mechanical</div>
                <div class="category-text main">Workshop</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="#" class="action-button">
                <i class="fas fa-user"></i> View Profile
            </a>
            <a href="#" class="action-button">
                <i class="fas fa-user-plus"></i> Connect
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



{{-- new' card design  for profle --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom CSS for the user profile card */
        body {
            font-family: 'Inter', sans-serif;
            /* Using Inter font for a modern look */
            background-color: #f0f2f5;
            /* Light background color */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Full viewport height to center content */
            margin: 0;
            padding: 20px;
            /* Add some padding for smaller screens */
        }

        .profile-card {
            width: 100%;
            max-width: 400px;
            /* Maximum width for the card */
            border-radius: 1rem;
            /* Rounded corners for the card */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
            overflow: hidden;
            /* Ensures content doesn't spill out of rounded corners */
            background-color: #ffffff;
            /* White background for the card */
            position: relative;
            /* Needed for absolute positioning of shield icon */
        }

        .profile-header {
            /* Placeholder for the background image, replace with actual image URL */
            background-image: url('https://placehold.co/400x150/e0e0e0/ffffff?text=Header+Background');
            background-size: cover;
            /* Cover the entire area */
            background-position: center;
            /* Center the background image */
            height: 120px;
            /* Height of the header section */
            display: flex;
            justify-content: center;
            align-items: flex-end;
            /* Align profile picture to the bottom of the header */
            position: relative;
            /* Needed for positioning the profile picture */
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            /* Ensure image covers the area without distortion */
            border: 4px solid #ffffff;
            /* White border around the profile picture */
            border-radius: 50%;
            /* Make the image perfectly circular */
            margin-bottom: -50px;
            /*Pull the picture up to overlap the header*/
            position: relative;
            z-index: 2;
            /* Ensure profile picture is above other elements */
        }

        .profile-shield {
            background-color: #007bff;
            /* Primary blue color for the shield background */
            color: #ffffff;
            /* White color for the shield icon */
            border-radius: 50%;
            /* Circular shield */
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            position: absolute;
            /* Position relative to the profile-header */
            top: 100px;
            /* Distance from the top */
            right: 135px;
            /* Distance from the right */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* Small shadow for the shield */
            z-index: 3;
            /* Ensure shield is above everything */
        }

        .card-body {
            padding-top: 60px;
            /* Adjust padding to make space for the profile picture */
            text-align: center;
        }

        .card-title {
            font-weight: 700;
            /* Bold font for name */
            color: #343a40;
            /* Darker text color */
            margin-bottom: 0.25rem;
        }

        .card-text.text-muted {
            font-size: 0.9rem;
            color: #6c757d !important;
            /* Muted text color */
        }

        .info-icons {
            display: flex;
            justify-content: space-around;
            /* Distribute items evenly */
            align-items: flex-start;
            /* Align items to the top */
            margin-top: 1.5rem;
            padding: 0 1rem;
            /* Horizontal padding */
        }

        .info-icons .col-4 {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            /* Allow columns to grow */
            text-align: center;
        }

        .info-icons i {
            font-size: 1.3rem;
            color: #007bff;
            /* Primary blue for icons */
            margin-bottom: 0.5rem;
        }

        .info-text {
            font-size: 0.8rem;
            color: #495057;
            /* Slightly darker text for info */
            margin-bottom: 0;
            white-space: nowrap;
            /* Prevent text from wrapping */
            overflow: hidden;
            /* Hide overflowed text */
            text-overflow: ellipsis;
            /* Add ellipsis for overflowed text */
            max-width: 100%;
            /* Ensure text doesn't exceed its container */
        }

        .details-section {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            /* Light border at the top */
            border-bottom: 1px solid #e9ecef;
            /* Light border at the bottom */
            margin-top: 1.5rem;
        }

        .details-section .col-6 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            /* Align text to the left */
        }

        .details-section .col-6:first-child {
            border-right: 1px solid #e9ecef;
            /* Separator between company and category */
            padding-right: 1rem;
        }

        .details-section .col-6:last-child {
            padding-left: 1rem;
        }

        .company-logo {
            width: 50px;
            /* Size of the company logo */
            height: auto;
            object-fit: contain;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            /* Slightly rounded corners for logo */
        }

        .company-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 0;
        }

        .category-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.1rem;
        }

        .category-name {
            font-size: 1rem;
            font-weight: 700;
            color: #007bff;
            /* Primary blue for category name */
            margin-bottom: 0;
        }

        .skills-section {
            margin-top: 1.5rem;
            padding: 0 1rem;
            /* Horizontal padding */
            display: flex;
            flex-wrap: wrap;
            /* Allow badges to wrap to the next line */
            justify-content: center;
            /* Center the badges */
            gap: 0.5rem;
            /* Space between badges */
        }

        .skill-badge {
            background-color: #e9ecef;
            /* Light gray background for badges */
            color: #495057;
            /* Dark text for badges */
            padding: 0.5em 0.9em;
            font-size: 0.8rem;
            border-radius: 1rem;
            /* More rounded pill shape */
            font-weight: 500;
            border: 1px solid #dee2e6;
            /* Subtle border */
        }

        .profile-actions {
            margin-top: 1.5rem;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            /* Separator for action buttons */
            display: flex;
            gap: 0.5rem;
            /* Space between buttons */
            justify-content: center;
        }

        .view-profile-btn,
        .message-btn {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 0.75rem;
            /* Rounded corners for buttons */
            transition: all 0.3s ease;
            /* Smooth transition for hover effects */
        }

        .view-profile-btn {
            background-color: #f8f9fa;
            /* Light background for outline button */
            color: #007bff;
            /* Primary blue text */
            border: 1px solid #007bff;
            /* Primary blue border */
        }

        .view-profile-btn:hover {
            background-color: #007bff;
            /* Fill with blue on hover */
            color: #ffffff;
            /* White text on hover */
        }

        .message-btn {
            background-color: #007bff;
            /* Primary blue background */
            color: #ffffff;
            /* White text */
            border: 1px solid #007bff;
            /* Primary blue border */
        }

        .message-btn:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .profile-card {
                margin: 0 10px;
                /* Add margin on very small screens */
            }

            .info-icons {
                flex-direction: row;
                /* Keep icons in a row */
                gap: 0.5rem;
                /* Reduce gap */
            }

            .info-icons .col-4 {
                padding: 0 5px;
                /* Adjust padding */
            }

            .profile-actions {
                flex-direction: column;
                /* Stack buttons vertically on small screens */
            }

            .view-profile-btn,
            .message-btn {
                width: 100%;
                /* Full width for stacked buttons */
            }
        }
    </style>


</head>

<body>
    <div class="profile-card">
        <div class="profile-header">
            <img src="https://placehold.co/100x100/007bff/ffffff?text=JD" class="profile-pic" alt="John Doshi">
            <div class="profile-shield">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>

        <div class="card-body">
            <h4 class="card-title">John Doshi</h4>
            <p class="card-text text-muted">Vice President at UBN</p>

            <div class="info-icons">
                <div class="col-4">
                    <i class="far fa-envelope"></i>
                    <p class="info-text">John5969dosh...</p>
                </div>
                <div class="col-4">
                    <i class="fas fa-phone-alt"></i>
                    <p class="info-text">941 440 2140</p>
                </div>
                <div class="col-4">
                    <i class="fas fa-fingerprint"></i>
                    <p class="info-text">Pinnacle</p>
                </div>
            </div>

            <div class="details-section">
                <div class="col-6">
                    <img src="https://placehold.co/50x25/007bff/ffffff?text=LOGO" class="company-logo" alt="Company Logo">
                    <p class="company-name">CubX Technologies</p>
                </div>
                <div class="col-6">
                    <p class="category-label">Category</p>
                    <p class="category-name">Mechanical Workshop</p>
                </div>
            </div>

            <div class="skills-section">
                <span class="skill-badge">Mobile App Development</span>
                <span class="skill-badge">Web Development</span>
                <span class="skill-badge">SAAS Application</span>
            </div>

            <div class="profile-actions">
                <div class="col-6">
                    <button class="btn view-profile-btn w-100">
                        <i class="fas fa-user pe-2"></i>View Profile
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn message-btn w-100">
                        <i class="fas fa-comment-dots pe-2"></i>Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
