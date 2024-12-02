<?php

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/customers', function (Request $request) {
    return Customer::Simplepaginate(20);
});
Route::post('/add-customer', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:12', 'regex:/^(\+91|91|9|8|7|6)\d{9}$/', 'unique:customers,phone'],
        'dob' => ['nullable', 'date'],
    ]);
    $customer = Customer::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'dob' => $request->dob,
        'email' => $request->email ?? null,
        'age' => Carbon::parse($request->dob)->age,
        'shop_id' => $request->shop_id ?? 1,
    ]);
    return $customer;
});
