@extends('layouts.master')

@section('content')
    <style>
        /* Custom styles for search, chat cards, chat box, etc. */
        .chat-card {
            display: flex;
            /* align-items: center; */
            padding: 10px;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #fff;
            transition: background 0.3s;
        }

        .chat-card:hover {
            background: #f0f0f0;
        }

        .chat-container {
            display: flex;
            align-items: center;
        }

        .photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-right: 10px;
        }

        .chat-text {
            flex: 1;
        }

        .chat-name {
            font-weight: bold;
            color: #1d3268;
        }

        .chat-message {
            font-size: 0.9em;
            color: #666;
        }

        .time {
            font-size: 0.8em;
            color: #999;
        }

        .chat-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            /* padding: 10px; */
            background: #fff;
            height: 400px;
            overflow-y: auto;
        }

        .chat-input {
            display: flex;
            align-items: center;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #e76a35;
            color: #fff;
            cursor: pointer;
        }

        .date-header {
            font-weight: bold;
            margin: 10px 0;
        }

        .chat-message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .chat-message.sent {
            background-color: #e0f7fa;
            align-self: flex-end;
        }

        .chat-message.received {
            background-color: #f1f8e9;
            align-self: flex-start;
        }

        .message-time {
            display: block;
            font-size: 0.8em;
            color: #888;
            margin-top: 5px;
        }

        /* Existing styles */

        /* General styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-bar {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 0.5px solid #e76a35;
            border-radius: 5px;
            font-size: 1em;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar input::placeholder {
            color: #162e6b;
        }

        #user-list {
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: none;
            /* scrollbar-color: #e76a35 #f9f9f9; */
            /* Custom colors for the scrollbar */
            border-radius: 10px;
            /* Rounded corners for the user list */
        }

        /* Custom scrollbar styles for WebKit browsers (Chrome, Safari) */
        #user-list::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
            border-radius: 10px;
            /* Rounded corners for the scrollbar */
        }

        #user-list::-webkit-scrollbar-track {
            background: #f9f9f9;
            /* Background color of the scrollbar track */
            border-radius: 10px;
            /* Rounded corners for the track */
        }

        #user-list::-webkit-scrollbar-thumb {
            background-color: #e76a35;
            /* Color of the scrollbar thumb */
            border-radius: 10px;
            /* Rounded corners for the thumb */
            border: 2px solid #f9f9f9;
            /* Adds some padding inside the thumb */
        }

        /* Chat card styles */
        .chat-card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            /* border: 1px solid #e76a35; */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            cursor: pointer;
            padding: 0;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .chat-card:hover {
            background-color: #f9f9f9;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .chatcontainer {
            display: flex;
            align-items: center;
            padding: 15px;
            position: relative;
        }

        .photo {
            width: 50px;
            height: 50px;
            background-size: cover;
            object-fit: contain;
            border-radius: 50%;
            margin-right: 15px;
            border: 1.5px solid #e76a35;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chattext {
            flex: 1;
            overflow: hidden;
        }

        .chatname {
            font-weight: bold;
            font-size: 1.2em;
            color: #1d3268;
            margin-bottom: 5px;
        }

        .chatmessage {
            font-size: 0.9em;
            color: #555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Chat Box */
        .chat-box {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 500px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            margin-top: 20px;
        }

        .chat-header {
            background-color: #1d3268;
            color: white;
            padding: 10px;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: sticky;
            top: 0;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            border-top: 1px solid #ddd;
            scrollbar-width: thin;
            scrollbar-color: #888 #fff;
            display: flex;
            flex-direction: column;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        /* Chat message styles */
        .chat-message {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            max-width: 70%;
            word-wrap: break-word;
            display: inline-block;
        }

        /* Styling for received messages */
        .chat-message.received {
            background-color: #e76a35;
            color: white;
            align-self: flex-start;
        }

        /* Styling for sent messages */
        .chat-message.sent {
            background-color: #1d3268;
            color: white;
            align-self: flex-end;
            text-align: right;
        }

        /* Chat Input */
        .chat-input {
            padding: 10px;
            display: flex;
            align-items: center;
            background-color: #fff;
            border-top: 1px solid #ddd;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            flex-shrink: 0;
            position: sticky;
            bottom: 0;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .chat-input button {
            background-color: #1d3268;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            flex-shrink: 0;
            transition: background-color 0.3s ease;
        }

        .chat-input button:hover {
            background-color: #e76a35;
        }

        /* Styling for message timestamps */
        .message-time {
            font-size: 0.7em;
            color: white;
            text-align: right;
            display: block;
            margin-top: 5px;
        }

        .date-header {
            font-size: 0.8em;
            color: #888;
            text-align: center;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin: 10px 0;
            font-weight: bold;
        }

        /* User card styles for search */
        .user-card {
            display: flex;
            border-bottom: 1px solid #ddd;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .user-card:hover {
            background-color: #f9f9f9;
        }
    </style>

    <h1 style="font-weight: bold;">
        <span style="color: #1d3268;">My </span>
        <span style="color: #e76a35;">Chats</span>
    </h1>

    <div class="mt-4 search-bar">
        <input type="text" id="search-input" placeholder="Search Members...">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div id="user-list">
                @foreach ($listOfUsers as $user)
                    <div class="card chat-card user-card" onclick="openChatBox('{{ $user->id }}', '{{ $user->firstName }} {{ $user->lastName }}')">
                        <div class="chat-container">
                            <a href="#" class="photo" style="background-image: url('{{ asset('ProfilePhoto/' . ($user->member->profilePhoto ?? 'profile.png')) }}');"></a>
                            <div class="chat-text">
                                <div class="chat-name">{{ $user->firstName }} {{ $user->lastName }}</div>
                                {{-- <div class="chat-message">Last message placeholder</div> --}}
                            </div>
                            {{-- <div class="time col-md-3">Time placeholder</div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Box -->
        <div class="col-md-6">
            <div id="chat-box" class="chat-box" style="display:none;">
                <div id="chat-header" class="chat-header"></div>
                <div id="chat-messages" class="chat-messages"></div>
                <div class="chat-input">
                    <input type="hidden" id="conversation-id">
                    <input type="hidden" id="sender-id" value="{{ Auth::user()->id }}">
                    <input type="text" id="message-input" placeholder="Type your message...">
                    <button onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var chatBox = document.getElementById("chat-messages");
        var chatInput = document.getElementById("message-input");
        var pollingInterval;
        var currentConversationId = null;

        function openChatBox(userId, userName) {
            document.getElementById("chat-box").style.display = "";
            document.getElementById("chat-header").textContent = "Chat with " + userName;

            // Stop polling if there's an active conversation
            if (currentConversationId !== null) {
                stopPolling();
            }

            // Check for existing conversation
            $.get('/conversations', function(conversations) {
                let conversationId = null;
                for (const conv of conversations) {
                    if ((conv.user_one_id == userId && conv.user_two_id == '{{ Auth::user()->id }}') ||
                        (conv.user_two_id == userId && conv.user_one_id == '{{ Auth::user()->id }}')) {
                        conversationId = conv.id;
                        break;
                    }
                }

                if (!conversationId) {
                    $.post('/conversations', {
                        user_one_id: '{{ Auth::user()->id }}',
                        user_two_id: userId,
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        conversationId = response.id;
                        loadMessages(conversationId);
                    });
                } else {
                    loadMessages(conversationId);
                }
            });

            function loadMessages(conversationId) {
                document.getElementById("conversation-id").value = conversationId;
                fetchMessages(conversationId);
                startPolling(conversationId);

                // Ensure chat box is scrolled to the bottom when opened
                setTimeout(() => chatBox.scrollTop = chatBox.scrollHeight, 0);
            }
        }

        function fetchMessages(conversationId) {
            $.get(`/messages/${conversationId}`, function(messages) {
                chatBox.innerHTML = '';
                let lastDate = '';

                messages.forEach(function(message) {
                    const messageDate = new Date(message.created_at);
                    const formattedDate = formatDate(messageDate);

                    // Add date header if the message date changes
                    if (lastDate !== formattedDate) {
                        const dateHeader = document.createElement("div");
                        dateHeader.className = "date-header";
                        dateHeader.textContent = formattedDate;
                        chatBox.appendChild(dateHeader);
                        lastDate = formattedDate;
                    }

                    // Create the message element
                    const messageElement = document.createElement("div");
                    messageElement.className = "chat-message " + (message.sender_id == '{{ Auth::user()->id }}' ? 'sent' : 'received');

                    // Display the decrypted message
                    messageElement.textContent = message.message;

                    // Add timestamp below the message
                    const timestampElement = document.createElement("span");
                    timestampElement.className = "message-time";
                    timestampElement.textContent = formatTimestamp(message.created_at);

                    messageElement.appendChild(timestampElement);
                    chatBox.appendChild(messageElement);
                });

                // Scroll to the bottom after messages are added
                chatBox.scrollTop = chatBox.scrollHeight;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching messages:', textStatus, errorThrown);
            });
        }

        function sendMessage() {
            var message = chatInput.value.trim();
            var conversationId = document.getElementById('conversation-id').value;
            var senderId = document.getElementById('sender-id').value;

            if (message && conversationId) {
                var messageElement = document.createElement("div");
                messageElement.className = "chat-message sent";
                messageElement.textContent = message;

                var timestampElement = document.createElement("span");
                timestampElement.className = "message-time";
                timestampElement.textContent = formatTimestamp(new Date());

                messageElement.appendChild(timestampElement);
                chatBox.appendChild(messageElement);
                chatInput.value = "";
                chatBox.scrollTop = chatBox.scrollHeight;

                // Send the encrypted message to the server
                $.post('/messages', {
                    conversation_id: conversationId,
                    sender_id: senderId,
                    message: message, // This will be encrypted by the backend
                    _token: '{{ csrf_token() }}'
                }).done(function(response) {
                    if (response.status !== 'Message sent') {
                        console.error('Error sending message:', response);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error sending message:', textStatus, errorThrown);
                });
            }
        }

        function startPolling(conversationId) {
            currentConversationId = conversationId;
            pollingInterval = setInterval(() => fetchMessages(conversationId), 1000);
        }

        function stopPolling() {
            clearInterval(pollingInterval);
            currentConversationId = null;
        }

        // Format the date for message headers
        function formatDate(date) {
            const today = new Date();
            const messageDate = new Date(date);

            if (messageDate.toDateString() === today.toDateString()) {
                return "Today";
            }

            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            if (messageDate.toDateString() === yesterday.toDateString()) {
                return "Yesterday";
            }

            return messageDate.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'short',
                day: 'numeric'
            });
        }

        // Format the timestamp for messages
        function formatTimestamp(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Send message on Enter key press
        chatInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });

        // Search functionality
        document.getElementById("search-input").addEventListener("input", function(event) {
            var searchTerm = event.target.value.toLowerCase();
            var users = document.querySelectorAll(".user-card");

            users.forEach(function(user) {
                var userName = user.querySelector(".chat-name").textContent.toLowerCase();
                if (userName.includes(searchTerm)) {
                    user.style.display = "";
                } else {
                    user.style.display = "none";
                }
            });
        });

        // Initialize Pusher
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true,
            authEndpoint: '/broadcasting/auth'
        });

        // Subscribe to the channel and bind to events
        var channel = pusher.subscribe('private-chat.' + '{{ Auth::user()->id }}');

        channel.bind('App\\Events\\MessageSent', function(data) {
            if (currentConversationId === data.conversation_id) {
                fetchMessages(currentConversationId);
            }
        });

        // Handle real-time message notification
        window.Echo.channel('private-chat.' + '{{ Auth::user()->id }}')
            .listen('MessageSent', (event) => {
                if (currentConversationId === event.message.conversation_id) {
                    fetchMessages(currentConversationId);
                }
            });
    </script>
@endsection
