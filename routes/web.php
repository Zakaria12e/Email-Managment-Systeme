<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinataireController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserSettingsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/register', [AuthController::class, 'postsignup'])->name('signup.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/{view?}', [ApplicationController::class, 'admin'])->where('view', '.*')->name('admin.pages');

    Route::post('/api/create-reception', [DestinataireController::class, 'store']);
    Route::post('/api/check-unique-fields', [DestinataireController::class, 'checkUniqueFields']);
    Route::post('/api/create-departments', [DepartmentController::class, 'store']);
    Route::get('/api/getdepartments', [DepartmentController::class, 'index']);
    Route::get('/api/getroles', [DepartmentController::class, 'getroles']);
    Route::post('/api/create-roles', [DepartmentController::class, 'storeRoles']);
    Route::get('/api/destinataires', [DestinataireController::class, 'index']);
    Route::get('/api/getEmaildestinataire/{id}', [DestinataireController::class, 'getEmail']);
    Route::get('/api/destinatairesCount', [DestinataireController::class, 'destinatairesCount']);
    Route::post('/api/emailsByRole', [DestinataireController::class, 'getEmailsByRole']);

    Route::post('/api/store-data', [EmailController::class, 'store']);
    Route::post('/api/send-email', [EmailController::class, 'sendEmail']);

    Route::post('/api/store-user-data', [UserSettingsController::class, 'store']);
    Route::post('/api/upload-photo', [UserSettingsController::class, 'uploadPhoto']);
    Route::post('/api/get-photo', [UserSettingsController::class, 'getPhoto']);

    Route::get('/api/getuser-data', [UserSettingsController::class, 'getUserData']);



    Route::get('/api/get-emails', [EmailController::class, 'index']);
    
    Route::get('/api/get-expediteurs', [EmailController::class, 'getexpediteurs']);
    Route::get('/api/email/{id}', [EmailController::class, 'show']);

});

