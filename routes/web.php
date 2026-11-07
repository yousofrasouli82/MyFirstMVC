<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Cookie;
//--------------------->>>   Login    --------------------->>>
Route::get('/', fn() => redirect('/login'));

Route::get('/login', fn() => view('/login'));

Route::post('/login',function (Request $request){
    $admin_email = config('auth.admin_name');
    $admin_password = config('auth.admin_password');

    if ($admin_email && $admin_password && $request->email == $admin_email && $request->password == $admin_password) {
        $request->session()->put('is_admin', true);
        return redirect('/admin');
    }

    $credit = $request->only('email','password');
    if (Auth::attempt($credit)){
        if ($request->boolean('remember')) {
            Cookie::queue('remember_user',auth()->id(),60*24*10); // 10 roz to cookie mimone
        }
        return redirect('/home');
    }
    return redirect('/login')->with('failure','Email or Password is incorrect');
});


//--------------------->>>   register    --------------------->>>
Route::get('/register', fn() => view('/register'));


Route::
post('register',function (RegisterRequest $request){
    User::create($request->validated());
    return redirect('/login')->with('success', 'your registration was successful!');
});


//--------------------->>>   home    --------------------->>>

//
//Route::get('/home',function (Request $request){
//    view('/home')->with('user',$request);
//});
Route::get('/home', function(){
    return view('home', ['user_information' => Auth::user()]);
});


//--------------------->>>   admin    --------------------->>>
//Route::get('/admin', function(){
//    return view('admin', ['user_information' => Auth::user()]);
//});


Route::get('/admin',function(){
   if (!session('is_admin')){
       return redirect('/login');
   }
   return view('admin',['admin_name' => config('auth.admin_name'),
       'admin_password' => config('auth.admin_password'),
       'all_users' => User::withTrashed()->get()
   ]);
});

//--------------------->>>   add user _ admin    --------------------->>>
Route::get('/add_user_admin',function (){
    if (!session('is_admin')){
        return redirect('/login');
    }
    return view('/add_user');
});

Route::post('/add_user_admin',function (RegisterRequest $request){
    if (!session('is_admin')){
        return redirect('/login');
    };
    User::create($request->validated());
    return redirect('/admin')->with('successful', 'your add employee was successful!');
});
//--------------------->>>   edit    --------------------->>>

Route::get('edit/{id}',function($id){
//    return view('edit');
//    if (!session('is_admin')){
//        return redirect('/login');
//    }
    $user = User::find($id);
    return view('edit',['edit_user' => $user]);
});



Route::get('edit/{id}/{field}',function($id,$field){

    $user = User::find($id);
    return view('edit_field',['edit_user' => $user,'field' => $field]);
});

Route::post('edit/{id}/{field}',function(UpdateUserRequest $request,$id,$field){
    $user = User::find($id);
    $user->update([$field => $request->validated()['value']]);

    return redirect('/edit/'.$id)->with('success', 'Your data has been updated!');
});
//--------------------->>>   edit Ai   --------------------->>>

//Route::get('edit/{id}', function ($id) {
//    if (!session('is_admin')) {
//        return redirect('/login');
//    }
//    $user = User::findOrFail($id);
//    return view('edit', ['edit_user' => $user]);
//});
//
//Route::get('edit/{id}/{field}', function ($id, $field) {
//    if (!session('is_admin')) {
//        return redirect('/login');
//    }
//    if (!in_array($field, ['name', 'last_name', 'email', 'phone_number'])) {
//        abort(404);
//    }
//    $user = User::findOrFail($id);
//    return view('edit_field', ['edit_user' => $user, 'field' => $field]);
//});
//
//Route::post('edit/{id}/{field}', function (UpdateUserRequest $request, $id, $field) {
//    $user = User::findOrFail($id);
//    $user->update([$field => $request->validated()['value']]);
//
//    return redirect('/edit/' . $id)->with('ok', 'Your ' . $field . ' has been updated!');
//});
//--------------------->>>   logout    --------------------->>>
Route::post('logout',function (Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

//--------------------->>>   delete    --------------------->>>
Route::post('/delete/{id}',function ($id){
    if (!session('is_admin')){
        return redirect('/');
    }
    User::findOrFail($id)->delete();
    return redirect('/admin')->with('success', 'Your data has been deleted!');
});
