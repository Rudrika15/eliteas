{{-- resources/views/chat.blade.php --}}
@extends('layouts.master')

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="left">
            <div class="top">
                <input type="text" placeholder="Search" />
                <a href="javascript:;" class="search"></a>
            </div>
            <ul class="people">
                <li class="person" data-chat="person1">
                    {{-- <img src="{{ asset('images/thomas.jpg') }}" alt="" /> --}}
                    <span class="name">Thomas Bangalter</span>
                    {{-- <span class="time">2:09 PM</span> --}}
                    {{-- <span class="preview">I was wondering...</span> --}}
                </li>
                <!-- Add other chat persons here -->
            </ul>
        </div>
        <div class="right">
            <div class="top"><span>To: <span class="name">Dog Woofson</span></span></div>
            <div class="chat" data-chat="person1">
                <div class="conversation-start">
                    <span>Today, 6:48 AM</span>
                </div>
                <div class="bubble you">
                    Hello,
                </div>
                <!-- Add other chat bubbles here -->
            </div>
            <div class="write">
                <a href="javascript:;" class="write-link attach"></a>
                <input type="text" />
                <a href="javascript:;" class="write-link smiley"></a>
                <a href="javascript:;" class="write-link send"></a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Your CSS code */
    .wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: #e8e8e8;
    }

    .container {
        display: flex;
        flex-direction: row;
        height: 600px;
        width: 1000px;
        background: #fff;
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
    }

    .left {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e6e6e6;
    }

    .top {
        padding: 20px;
        border-bottom: 1px solid #e6e6e6;
    }

    .people {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .person {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        cursor: pointer;
    }

    .person img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .person .name {
        font-weight: bold;
    }

    .person .time {
        font-size: 0.75em;
        color: #999;
    }

    .person .preview {
        font-size: 0.9em;
        color: #999;
    }

    .right {
        flex: 2;
        display: flex;
        flex-direction: column;
    }

    .right .top {
        padding: 20px;
        border-bottom: 1px solid #e6e6e6;
    }

    .right .chat {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .right .chat .conversation-start {
        text-align: center;
        margin-bottom: 30px;
    }

    .right .chat .bubble {
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        position: relative;
        max-width: 70%;
    }

    .right .chat .bubble.you {
        background: #e8f1ff;
        align-self: flex-start;
    }

    .right .chat .bubble.me {
        background: #d8e8ff;
        align-self: flex-end;
    }

    .right .write {
        padding: 20px;
        border-top: 1px solid #e6e6e6;
        display: flex;
        align-items: center;
    }

    .right .write input {
        flex: 1;
        padding: 10px;
        border: 1px solid #e6e6e6;
        border-radius: 5px;
        margin-right: 10px;
    }

    .write-link {
        width: 40px;
        height: 40px;
        background-size: cover;
        margin: 0 5px;
        cursor: pointer;
    }

    .write-link.attach {
        background-image: url('attach-icon.png');
    }

    .write-link.smiley {
        background-image: url('smiley-icon.png');
    }

    .write-link.send {
        background-image: url('send-icon.png');
    }
</style>

<script>
    // Your JavaScript code
document.querySelector('.chat[data-chat=person2]').classList.add('active-chat');
document.querySelector('.person[data-chat=person2]').classList.add('active');

let friends = {
    list: document.querySelector('ul.people'),
    all: document.querySelectorAll('.left .person'),
    name: ''
},
chat = {
    container: document.querySelector('.container .right'),
    current: null,
    person: null,
    name: document.querySelector('.container .right .top .name')
}

friends.all.forEach(f => {
    f.addEventListener('mousedown', () => {
        f.classList.contains('active') || setAciveChat(f)
    })
});

function setAciveChat(f) {
    friends.list.querySelector('.active').classList.remove('active');
    f.classList.add('active');
    chat.current = chat.container.querySelector('.active-chat');
    chat.person = f.getAttribute('data-chat');
    chat.current.classList.remove('active-chat');
    chat.container.querySelector('[data-chat="' + chat.person + '"]').classList.add('active-chat');
    friends.name = f.querySelector('.name').innerText;
    chat.name.innerHTML = friends.name;
}
</script>
@endsection