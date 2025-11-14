<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PatientController;
use App\Jobs\TestRabbitJob;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/test-rabbit', function () {
    TestRabbitJob::dispatch();
    return 'Job enviado!';
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::get('/patients/{patient}', [PatientController::class, 'show']);
    Route::patch('/patients/{patient}', [PatientController::class, 'update']);
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);


    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::get('/addresses/{address}', [AddressController::class, 'show']);
    Route::patch('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    Route::get('/caregivers', [CaregiverController::class, 'index']);
    Route::post('/caregivers', [CaregiverController::class, 'store']);
    Route::get('/caregivers/{caregiver}', [CaregiverController::class, 'show']);
    Route::patch('/caregivers/{caregiver}', [CaregiverController::class, 'update']);
    Route::delete('/caregivers/{caregiver}', [CaregiverController::class, 'destroy']);

    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

    Route::get('donnations', [DonationController::class, 'index']);
    Route::post('donnations', [DonationController::class, 'store']);
    Route::get('donnations/{donation}', [DonationController::class, 'show']);
    Route::patch('donnations/{donation}', [DonationController::class, 'update']);
    Route::delete('donnations/{donation}', [DonationController::class, 'destroy']);

    Route::get('/contacts/patient/{patient}', [ContactController::class, 'getAllByPatient']);
    Route::get('/contacts/caregiver/{caregiver}', [ContactController::class, 'getAllByCaregiver']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts/{contact}', [ContactController::class, 'show']);
    Route::patch('/contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);

    Route::post('/documents', [DocumentController::class, 'store']);
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::get('/documents/{document}', [DocumentController::class, 'show']);
    Route::patch('/documents/{document}', [DocumentController::class, 'update']);
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy']);
});
