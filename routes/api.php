<?php
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// WebsiteController API endpoints
Route::post('websites', [WebsiteController::class, 'create']);
Route::post('websites/{website}/posts', [WebsiteController::class, 'createPost']);


// UserController API endpoints
Route::post('/users/{user}/subscriptions', [UserController::class, 'subscribe']);

// PostController API endpoints (not required)

