@extends('layouts.master')

@section('content')

<style>
    /* Existing styles for the chat cards */
    .chat-card {
        background-color: #ffffff;
        border: none;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
        cursor: pointer;
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
        border-radius: 50%;
        margin-right: 15px;
    }

    .chattext {
        flex: 1;
        overflow: hidden;
    }

    .chatname {
        font-weight: bold;
        font-size: 1.2em;
        color: #000;
        margin-bottom: 5px;
    }

    .chatmessage {
        font-size: 0.9em;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .time {
        font-size: 0.8em;
        color: #888;
        position: absolute;
        top: 20px;
        right: 20px;
    }

    /* Adjusted styles for the chat box */
    .chat-box {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        height: 500px;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
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
        background-color: #e5e5ea;
        align-self: flex-start;
    }

    /* Styling for sent messages */
    .chat-message.sent {
        background-color: #1d3268;
        color: white;
        align-self: flex-end;
        text-align: right;
    }

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
    }

    /* Styling for message timestamps */
    .message-time {
        font-size: 0.7em;
        color: #888;
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
</style>

<h1 style="color: #1d3268; font-weight:bold;">My Chats</h1>
<div class="row">
    <div class="col-md-6">
        @foreach($listOfUsers as $user)
        <div class="card chat-card"
            onclick="openChatBox('{{ $user->id }}', '{{ $user->firstName }} {{ $user->lastName }}')">
            <div class="chatcontainer">
                <a href="#" class="photo"
                    style="background-image: url('{{ asset('ProfilePhoto/' . ($user->members->profilePhoto ?? 'profile.png')) }}');"></a>
                <div class="chattext">
                    <div class="chatname">{{ $user->firstName }} {{ $user->lastName }}</div>
                    <div class="chatmessage">Last message placeholder</div>
                </div>
                <div class="time">Time placeholder</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Chat Box -->
    <div class="col-md-6">
        <div id="chat-box" class="chat-box" style="display:none;">
            <div id="chat-header" class="chat-header"></div>
            <div id="chat-messages" class="chat-messages"></div>
            <div class="chat-input">
                <input type="hidden" id="memberId">
                <input type="text" id="message-input" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var chatBox = document.getElementById("chat-messages");
    var chatInput = document.getElementById("message-input");
    var pollingInterval;

    function openChatBox(userId, userName) {
        document.getElementById("chat-box").style.display = "block";
        document.getElementById("chat-header").textContent = "Chat with " + userName;
        document.getElementById("memberId").value = userId;
        fetchMessages();
        startPolling();
    }

    function fetchMessages() {
        const authCheck = `{{Auth::user()->id}}`;
        var receiverId = document.getElementById('memberId').value;

        $.post('/get-messages', {
            receiverId: receiverId,
            _token: '{{ csrf_token() }}'
        }).done(function (messages) {
            chatBox.innerHTML = '';
            let lastDate = '';

            messages.forEach(function (message) {
                const messageDate = new Date(message.created_at);
                const formattedDate = formatDate(messageDate);

                // Add date header if it is different from the last date
                if (lastDate !== formattedDate) {
                    const dateHeader = document.createElement("div");
                    dateHeader.className = "date-header";
                    dateHeader.textContent = formattedDate;
                    chatBox.appendChild(dateHeader);
                    lastDate = formattedDate;
                }

                // Create and append message element
                const messageElement = document.createElement("div");
                messageElement.className = "chat-message " + (message.senderId == authCheck ? 'sent' : 'received');
                messageElement.textContent = message.content;

                // Create and add timestamp element
                const timestampElement = document.createElement("span");
                timestampElement.className = "message-time";
                timestampElement.textContent = formatTimestamp(message.created_at);

                messageElement.appendChild(timestampElement);
                chatBox.appendChild(messageElement);
            });

            chatBox.scrollTop = chatBox.scrollHeight;
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching messages:', textStatus, errorThrown);
        });
    }

    function sendMessage() {
        var message = chatInput.value.trim();
        var receiverId = document.getElementById('memberId').value;

        if (message && receiverId) {
            // Add the message to the chat box immediately
            var messageElement = document.createElement("div");
            messageElement.className = "chat-message sent";
            messageElement.textContent = message;

            // Create and add timestamp element
            var timestampElement = document.createElement("span");
            timestampElement.className = "message-time";
            timestampElement.textContent = formatTimestamp(new Date()); // Use current time

            messageElement.appendChild(timestampElement);
            chatBox.appendChild(messageElement);
            chatInput.value = "";
            chatBox.scrollTop = chatBox.scrollHeight;

            // Send message to the server
            $.post('/send-message', {
                message: message,
                userId: receiverId,
                _token: '{{ csrf_token() }}'
            }).done(function (response) {
                if (response.status !== 'Message sent') {
                    console.error('Error sending message:', response);
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Error sending message:', textStatus, errorThrown);
            });
        }
    }

    function startPolling() {
        pollingInterval = setInterval(fetchMessages, 1000);
    }

    function stopPolling() {
        clearInterval(pollingInterval);
    }

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

        return messageDate.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
    }

    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    // Add event listener to send message on Enter key press
    chatInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent the default action (e.g., form submission)
            sendMessage(); // Call the sendMessage function
        }
    });
</script>

@endsection