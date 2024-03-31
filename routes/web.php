<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\SchoolBatimentController;
use App\Http\Controllers\SchoolLevelController;
use App\Http\Controllers\SchoolYearController;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Scope;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('niveaux')->group(function(){
        Route::get('/',[SchoolLevelController::class, 'index'])->name( 'niveaux' );
        Route::get('/create-school-Level', [SchoolLevelController::class,'create']) -> name('school.create-school-level');
        Route::get('/edit-school-Level/{level}', [SchoolLevelController::class,'edit']) -> name('school.edit-school-level');

    });

    Route::prefix('batiment')->group(function(){
        Route::get('/',[SchoolBatimentController::class, 'index'])->name( 'batiment' );
        Route::get('/create-batiment', [SchoolBatimentController::class,'create']) -> name('school.create-school-batiment');
        Route::get('/edit-batiment/{batiment}', [SchoolBatimentController::class,'edit']) -> name('school.edit-school-batiment');

    });

    Route::prefix('school')->group(function(){
        Route::get("/", [SchoolYearController::class, 'index'])-> name('schoolYears');
        Route::get('/create-school-year', [SchoolYearController::class,'create']) -> name('school.create-school-year');
    });
});
