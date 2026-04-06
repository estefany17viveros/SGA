<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
// Route::get('/register', [RegisteredUserController::class, 'create'])
//     ->name('register');
//     Route::post('/register', [RegisteredUserController::class, 'store']); 

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 


/*
|--------------------------------------------------------------------------
| RUTAS ADMIN
|--------------------------------------------------------------------------
*/
// --------------------------------------------------------------------------
// RUTAS ADMIN
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    
        // Academic Years
        //no permite las rutas editar por que la verdad daña el sistema si hace cambio alguno 
       Route::resource('academic_years', AcademicYearController::class)
    ->except(['edit', 'update']);

        Route::patch('academic_years/{academicYear}/activate', [AcademicYearController::class, 'activate'])
            ->name('academic_years.activate');
        Route::patch('academic_years/{academicYear}/close', [AcademicYearController::class, 'closeYear'])
            ->name('academic_years.close');

        // Grades
        Route::resource('grades', GradeController::class);
        Route::patch('grades/{grade}/approve-year', [StudentController::class, 'approveYear'])
            ->name('grades.approveYear');

        // Groups
        Route::resource('grades.groups', GroupController::class);
        // Route::resource('groups', GroupController::class);

        // Students
        Route::resource('students', StudentController::class);
        Route::get('students/{student}/status/{status}', [StudentController::class, 'changeStatus'])
            ->name('students.changeStatus');
            
            
            // Acudientes
             Route::get('guardians/create/{student_id}', [GuardianController::class,'create'])
        ->name('guardians.create');

    Route::post('guardians', [GuardianController::class,'store'])
        ->name('guardians.store');
     Route::resource('guardians', GuardianController::class);
    
    
    // Enrollments
           
            Route::patch('enrollments/{enrollment}/promote',
                [EnrollmentController::class, 'promote']
            )->name('enrollments.promote');

            Route::patch('enrollments/{enrollment}/fail',
                [EnrollmentController::class, 'fail']
            )->name('enrollments.fail');

            Route::put('enrollments/{enrollment}/status',
                [EnrollmentController::class,'updateStatus']
            )->name('enrollments.updateStatus');
            Route::put('enrollments/approve-all',
                        [EnrollmentController::class,'approveAll']
                    )->name('enrollments.approveAll');
                    //esta es la vista de los estudiantesgraduados
            Route::get('enrollments/graduated',
                [EnrollmentController::class,'graduated']
            )->name('enrollments.graduated');
            //esta es la vista de los estudiantes reirados
            Route::get('/enrollments/retired', [EnrollmentController::class, 'retired'])
                ->name('enrollments.retired');

         Route::resource('enrollments', EnrollmentController::class);


        //cerrar año académico
            Route::put('academic_years/{id}/close',
    [AcademicYearController::class, 'close']
)->name('admin.academic_years.close');


//teacher

Route::resource('teachers', TeacherController::class);



//subjets

Route::resource('subjects', SubjectController::class);


//teacher_subjets

Route::resource('teacher-subjects', TeacherSubjectController::class);

//periods 

 // 📋 Listar periodos por año
    Route::get('periods/{year}', [PeriodController::class, 'index'])
        ->name('periods.index');

    // 👁️ Ver detalle
    Route::get('periods/show/{id}', [PeriodController::class, 'show'])
        ->name('periods.show');

    // ✏️ Editar
    Route::get('periods/edit/{id}', [PeriodController::class, 'edit'])
        ->name('periods.edit');

    // 🔄 Actualizar
    Route::put('periods/{id}', [PeriodController::class, 'update'])
        ->name('periods.update');

    // 🔒 Cerrar periodo
    Route::get('periods/{id}/close', [PeriodController::class, 'close'])
        ->name('periods.close');

    // 🔓 Activar periodo
    Route::get('periods/{id}/open', [PeriodController::class, 'open'])
        ->name('periods.open');

    // ❌ Eliminar
    Route::delete('periods/{id}', [PeriodController::class, 'destroy'])
        ->name('periods.destroy');

});


// --------------------------------------------------------------------------
// RUTAS TEACHER
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {



    

//  IMPORTANTE: Las rutas de actividades y notas deben ir al final para evitar conflictos con otras rutas

        // Activities and scores
        Route::resource('activities', ActivityController::class);
Route::get('scores/{activity}/create', [ScoreController::class, 'create'])->name('scores.create');
Route::post('scores', [ScoreController::class, 'store'])->name('scores.store');
Route::get('scores/{activity}', [ScoreController::class, 'show'])->name('scores.show');
Route::get('score/{id}/edit', [ScoreController::class, 'edit'])->name('scores.edit');
Route::put('score/{id}', [ScoreController::class, 'update'])->name('scores.update');
Route::delete('score/{id}', [ScoreController::class, 'destroy'])->name('scores.destroy');
    });