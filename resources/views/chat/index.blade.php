@extends('layouts.master')

@section('content')

<h1 style="color: #1d3268; font-weight:bold;">My Chats</h1>
<div class="col-md-6">
    @foreach($listOfUsers as $user)
    <div class="card chat-card">
        <div class="chatcontainer">
            <a href="#" class="photo"
                style="background-image: url('{{ asset('ProfilePhoto/' . ($user->members->profilePhoto ?? 'profile.png')) }}');"></a>
            {{-- <a href="#" class="photo" style="background-image: url('{{ $user->members->profilePhoto }}');"></a>
            --}}

            <div class="chattext">
                <div class="chatname">{{ $user->firstName }} {{ $user->lastName }}</div>
                <div class="chatmessage">Last message placeholder</div>
            </div>
            <div class="time">Time placeholder</div>
        </div>
    </div>
    @endforeach
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        color: #333;
        background-color: #f4f4f4;
    }

    .chat-card {
        background-color: #ffffff;
        border: none;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
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

    .chatmessage.-unread {
        font-weight: bold;
        color: #333;
    }

    .time {
        font-size: 0.8em;
        color: #888;
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>

@endsection