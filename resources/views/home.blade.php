@extends('layout')
@section('content')

<h1>
    Welcome {{$user_information->name}}
{{--    {{$user_information->created_at}}--}}{{--  ---> date--}}
</h1>

{{--    <h2>--}}
{{--        <p>name  ---> {{$user_information->name}}</p>--}}

{{--        <p>Last Name ---> {{$user_information->last_name}}</p>--}}

{{--        <p>Email ---> {{$user_information->email}}</p>--}}

{{--        <p>Phone Number ---> {{$user_information->phone_number}}</p>--}}

{{--    </h2>--}}
{{--<th>--}}
{{--    <ta>--}}
{{--        name  ---> {{$user_information->name}}--}}
{{--        <t--}}
{{--    </ta>--}}
{{--</th>--}}

<table border="5">
    <tr>
        <th>subject</th>
        <th>value</th>
    </tr>
    <tr>
        <td>First Name</td>
        <td>{{$user_information->name}}</td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td>{{$user_information->last_name}}</td>
    </tr>
    <tr>
        <td>Email Address</td>
        <td>{{$user_information->email}}</td>
    </tr>
    <tr>
        <td>Phone Number</td>
        <td>{{$user_information->phone_number}}</td>
    </tr>
</table>

<form method="post" action="/logout" class="inline">
    @csrf
    <button>Logout</button>
</form>



@endsection
