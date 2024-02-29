<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/setup", function () {
    $credentials = [
        "email" => "admin@admin.com",
        "password" => "admin"
    ];

    if (!Auth::attempt($credentials)) {
        $user = User::query()->create([
            "name" => "Admin",
            "email" => $credentials["email"],
            "password" => bcrypt($credentials["password"])
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ["create", "update", "delete"]);
            $updateToken = $user->createToken('update-token', ["create", "update"]);
            $basicToken = $user->createToken('basic-token', ["basic"]);

            return [
                "admin" => $adminToken->plainTextToken,
                "update" => $updateToken->plainTextToken,
                "basic" => $basicToken->plainTextToken,
            ];
        }
    }
});
