    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .profile-wrapper {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .cover-bg {
            background: url('https://via.placeholder.com/1200x200') center/cover no-repeat;
            height: 180px;
        }

        .profile-container {
            position: relative;
            display: inline-block;
        }

        .g-badge {
            position: absolute;
            bottom: 0;
            /* Aligns it to the bottom of the image */
            left: 50%;
            /* Center horizontally */
            transform: translate(-50%, 50%);
            /* Move down & center */
            width: 32px;
            /* Adjust size as needed */
            height: 32px;
        }



        .profile-image {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            margin-top: -60px;
        }

        .connected {
            font-size: 14px;
            color: #e76a35;
            margin-left: 5px;
        }

        .profile-buttons button {
            width: 120px;
        }

        .card-section {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            height: 100%;
        }

        .stats-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            height: 100%;
        }

        /* .keyword-badge {
                                          background-color: #e0f0ff;
                                          color: #007bff;
                                          font-size: 12px;
                                          padding: 5px 10px;
                                          border-radius: 20px;
                                          margin: 3px;
                                          display: inline-block;
                                         } */

        .keywords-container {
            text-align: center;
            margin: 15px 20px 10px;
        }

        .keyword-pill {
            display: inline-block;
            background-color: #f3f5fb;
            color: #3a3a3a;
            font-size: 12px;
            padding: 6px 12px;
            margin: 5px 5px;
            border-radius: 20px;
            border: 1px solid #e0e4f0;
            cursor: default;
        }

        .blurred-info {
            filter: blur(4px);
            pointer-events: none;
            user-select: none;
        }

        .contact {
            font-weight: bold;
            color: #1d3268;
        }

        .company {
            font-weight: bold;
            color: #1d3268;
        }

        .text-color {
            color: #1d3268;
        }

        .custom-btn {
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 12px;
            font-weight: 500;
            display: flex;

            align-items: center;
            gap: 8px;
            transition: all 0.2s ease-in-out;
        }

        .message-btn {
            background-color: #fff5e9;
            color: #e65c00;
        }

        .remove-btn {
            background-color: #ffeaea;
            color: #cc0000;
        }

        .custom-btn i {
            font-size: 18px;
        }

        /* Optional hover effect */
        .custom-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }



        /* message model css */
        /* Base styles for the modal */
        .modal.fade .modal-dialog {
            transform: translateY(-30px) scale(0.95);
            /* Initial position and scale */
            opacity: 0;
            transition: all 0.4s ease-in-out;
            /* Smooth transition */
        }

        .modal.show .modal-dialog {
            transform: translateY(0) scale(1);
            /* Final position and scale */
            opacity: 1;
        }

        /* Backdrop effect for fade-in and fade-out */
        .modal-backdrop {
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
        }

        .modal-backdrop.show {
            opacity: 0.5;
            /* Semi-transparent background */
        }

        /* Modal content styles */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            /* Prevents overflow for better animations */
            animation: popup-effect 0.4s ease-in-out;
            /* Add a popup effect */
        }

        /* Keyframes for popup effect */
        @keyframes popup-effect {
            0% {
                transform: scale(0.9);
                /* Start smaller */
                opacity: 0;
                /* Fully transparent */
            }

            100% {
                transform: scale(1);
                /* Normal size */
                opacity: 1;
                /* Fully visible */
            }
        }

        /* Modal body styles */
        .modal-body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #555;
            text-align: center;
            /* Center-align text */
        }

        .modal-body p {
            margin-bottom: 15px;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            display: none;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .memberName {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;

        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            overflow: hidden;
        }

        .chat-box {
            flex: 1;
            padding: 10px;
            overflow-y: scroll;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            scrollbar-width: none;
            /* For Firefox */
        }

        .chat-box::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Edge */
        }

        .input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #fff;
        }

        #chatInput {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 10px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        #sendButton {
            padding: 10px 20px;
            background-color: #e76a35;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        #sendButton:hover {
            background-color: #1d3268;
        }

        .message {
            padding: 10px;
            margin: 5px 0;
            border-radius: 20px;
            max-width: 80%;
            /* Adjusts the maximum width of the message box */
            word-wrap: break-word;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            display: block;
            /* Changed to block to ensure each message is on a new line */
            clear: both;
            /* Ensures messages don't appear on the same line */
        }

        .sender {
            background-color: #1d3268;
            color: white;
            text-align: right;
            margin-left: auto;
            border-radius: 20px 20px 0 20px;
            float: right;
            /* Aligns sender messages to the right */
        }

        .receiver {
            background-color: #e76a35;
            color: white;
            text-align: left;
            margin-right: auto;
            border-radius: 20px 20px 20px 0;
            float: left;
            /* Aligns receiver messages to the left */
        }

        /* Optional: add a small triangle for speech bubble effect */
        .message::after {
            content: "";
            position: absolute;
            border-width: 10px;
            border-style: solid;
        }

        .sender::after {
            border-color: #1d3268 transparent transparent transparent;
            /* right: -15px; */
            top: 10px;
            border-width: 10px 15px 10px 0;
        }

        .receiver::after {
            border-color: #e76a35 transparent transparent transparent;
            left: -5px;
            top: 10px;
            border-width: 10px 0 10px 15px;
        }
    </style>
