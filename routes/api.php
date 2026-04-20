<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/sales', function () {
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    $todaysale = DB::table('invoice_items')
        ->whereDate('created_at', $today)
        ->where('status', '!=', 'Returned')
        ->sum('total');
        $yesterdaysale = DB::table('invoice_items')
                    ->whereDate('created_at', $yesterday)
                    ->where('status', '!=', 'Returned')
                    ->sum('total');
    return response()->json([
        'status' => 'success',
        'today_sale' => $todaysale,
        'yesterday_sale' => $yesterdaysale
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
