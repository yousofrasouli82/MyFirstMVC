@extends('layout')
@section('content')

    <h1>
        Welcome
    </h1>
    <h2>
        <p> Login as admin : </p>
{{--        <p> admin name = {{ $user_information->name }}</p>--}}
{{--        <p> last name = {{$user_information->last_name}}</p>--}}
        <p>Admin name = {{$admin_name}}</p>
    </h2>

    <h3>Users Information count = {{$all_users->count()}}</h3>
    <p><a href="/add_user_admin">Add new user</a></p>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Registered At</th>
            <th>Lats Update</th>
            <th>Delete status</th>
            <th>Update/Delete</th>
        </tr>
        @foreach(@$all_users as $this_user)
            <tr>
                <th>{{$this_user->name}}</th>
                <th>{{$this_user->last_name}}</th>
                <th>{{$this_user->email}}</th>
                <th>{{$this_user->phone_number}}</th>
                <th>{{$this_user->created_at}}</th>
                <th>{{$this_user->updated_at}}</th>

{{--                @if(var_dump($this_user->deleted_at)!==null)--}}
{{--                    <th>{{$this_user->deleted_at}}</th>--}}
{{--                    --}}
{{--                @elseif(var_dump($this_user->deleted_at)==null)--}}
{{--                    <th>Not Deleted yet</th>--}}
{{--                @endif--}}

{{--                @if(isset($this_user->deleted_at))--}}
{{--                    <th>{{$this_user->deleted_at}}</th>--}}
{{--                @else--}}
{{--                    <th>Not deleted yet</th>--}}
{{--                @endif--}}

{{--                <th>--}}
{{--                    <a href="/edit/{{$this_user->id}}">edit</a>--}}
{{--                    <a href="/delete">delete</a>--}}
{{--                </th>--}}
{{--            </tr>--}}
            @if($this_user->deleted_at)
                    <th>{{$this_user->deleted_at}}</th>
                    <th>-</th>
            @else
                    <th>Not deleted yet</th>
                    <th>
                        <a href="/edit/{{$this_user->id}}">Edit</a>
                        <form method="post" action="/delete/{{$this_user->id}}" class="inline" onsubmit="return confirm('delete this user ?')">
                            @csrf
                            <button>delete</button>
                        </form>
                    </th>
            @endif
            </tr>
        @endforeach
    </table>


<form method="post" action="/logout" class="inline">
    @csrf
    <button>Logout</button>
</form>

@endsection
