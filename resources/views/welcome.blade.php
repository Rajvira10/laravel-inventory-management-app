@extends('layout')

@section('content')
    <div class="container ">
        @auth('web')
            <p>Welcome, {{ auth()->user()->name }}! (Logged in as User)</p>
            @include('components.homepage')
            @elseauth('admin')
            <p>Welcome, {{ auth('admin')->user()->name }}! (Logged in as Admin)</p>
            @include('components.homepage')
        @else
            <p>You are not logged in. Please <a href="{{ route('auth.showlogin') }}">log in</a> to access this page.</p>
        @endauth
    @endsection
