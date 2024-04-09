<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\SchoolAffecterController;
use App\Http\Controllers\SchoolBatimentController;
use App\Http\Controllers\SchoolClassesController;
use App\Http\Controllers\SchoolInscrireController;
use App\Http\Controllers\SchoolLevelController;
use App\Http\Controllers\SchoolStudentController;
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
        Route::get('/create-school-Level', [SchoolLevelController::class,'create']) -> name('create-school-level');
        Route::get('/edit-school-Level/{level}', [SchoolLevelController::class,'edit']) -> name('edit-school-level');

    });

    Route::prefix('classes')->group(function(){
        Route::get('/',[SchoolClassesController::class, 'index'])->name( 'classes' );

        Route::get('/create-classes', [SchoolClassesController::class,'create']) -> name('create-classes');

        Route::get('/edit-classes/{classe}', [SchoolClassesController::class,'edit']) -> name('edit-classes');

    });

    Route::prefix('batiment')->group(function(){
        Route::get('/',[SchoolBatimentController::class, 'index'])->name( 'batiment' );

        Route::get('/create-batiment', [SchoolBatimentController::class,'create']) -> name('create-batiment');

        Route::get('/edit-batiment/{batiment}', [SchoolBatimentController::class,'edit']) -> name('school.edit-batiment');

    });

    Route::prefix('school')->group(function(){
        Route::get("/", [SchoolYearController::class, 'index'])-> name('schoolYears');

        Route::get('/create-school-year', [SchoolYearController::class,'create']) -> name('create-school-year');
    });


   Route::prefix('eleves')->group(function(){
        Route::get('/', [SchoolStudentController::class, 'index'])->name('eleves');

        Route::get('/edit-student/{eleve}', [SchoolStudentController::class, 'edit'])->name('edit-eleves');

        Route::get('/create-student', [SchoolStudentController::class, 'create'])->name('create-student');

        Route::get('/getStudentsByMatricule/{matricule}', [SchoolStudentController::class, 'getStudentsByMatricule'])->name('getStudentsByMatricule');

    });

    Route::prefix('affectation')->group(function () {
        Route::get('/', [SchoolAffecterController::class, 'index'])->name('affectation');
        Route::get('/create', [SchoolAffecterController::class, 'create'])->name('create-affectation');
        Route::get('/edit/{affectation}', [SchoolAffecterController::class, 'edit'])->name('edit-affectation');
    });

    Route::prefix('inscription')->group(function () {
        Route::get('/', [SchoolInscrireController::class, 'index'])->name('inscription');
        Route::get('/create', [SchoolInscrireController::class, 'create'])->name('create-inscription');
        Route::get('/edit/{inscription}', [SchoolInscrireController::class, 'edit'])->name('edit-inscription');
    });
});
