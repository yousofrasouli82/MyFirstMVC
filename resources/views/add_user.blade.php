@extends('layout')
@section('content')
    <form method="post" , action="/add_user_admin">
        @csrf

        Name :
        <input name="name" value="{{ old('name') }}" >

        Last Name :
        <input name="last_name" value="{{ old('last_name') }}">

        Phone Number :
        <input name="phone_number" value="{{ old('phone_number') }}">

        Email :
        <input name="email" value="{{ old('email') }}">

        Password :
        <input name="password" type="password">

        Confirmation Password :
        <input name="password_confirmation" type="password">

        <button> Confirm </button>

    </form>

{{--    <a href="/admin"> Login </a>--}}
@endsection
