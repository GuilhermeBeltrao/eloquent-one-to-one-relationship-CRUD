<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Address;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/createuser/{user_id}/{name}/{email}/{password}', function ($user_id, $name, $email, $password) {

    User::create(['id'=>$user_id, 'name'=>$name, 'email'=>$email, 'password'=>$password]);
});

// one to one relationship between user and address 
Route::get('/addaddress/{user_id}/{address}', function ($user_id, $address){

    $user = User::find($user_id);
    $address = new Address(['name'=>$address]);

    $user->address()->save($address);
}); 

Route::get('user/{user_id}/updateaddress/{address_name}', function($user_id, $address_name){

    $address = Address::whereUserId($user_id)->first();

    $address->name = $address_name;
    $address->save();

});

Route::get('/user/{user_id}/readaddress', function($user_id){

    $user = User::findOrFail($user_id);
    echo $user->address->name;
});

Route::get('user/{user_id}/deleteaddress', function ($user_id){

    $user = User::findOrFail($user_id);
    $user->address->delete();
    return "deleted";
});