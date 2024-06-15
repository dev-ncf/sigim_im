<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MovementStudentController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Models\Admin;
use App\Models\MovementStudent;
use App\Models\Student;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Hash;

Route::get('/', [WebController::class, 'viewLogin'])->name('login')->middleware('guest');
Route::post('/', [WebController::class, 'auth'])->name('authenticate');

Route::get('/register', [WebController::class, 'viewForm'])->name('register');
Route::post('/register', [WebController::class, 'register'])->name('registerPost');
Route::post('/verify/email', [WebController::class, 'verifyEmail'])->name('verifyEmail');



//Routas de Pre escricao
Route::get('/user/registration', [WebController::class, 'viewForm'])->name('registration')->middleware(['auth']);
//Rota que lista faculdades
Route::post('/user/registration/faculties', [WebController::class, 'faculties'])->middleware(['auth']);
//Rota que lista os cursos
Route::post('/user/registration/courses', [WebController::class, 'courses'])->middleware(['auth']);
//Rota de Linhas de pesguisa
Route::post('/user/registration/sewing-lines', [WebController::class, 'sewingLines'])->middleware(['auth']);


//Rotas para acessar distritos dos enderecos
Route::post('/address/districts', [WebController::class, 'districts'])->middleware(['auth']);


//Rota para criar uma inscricao
Route::post('/user/student/registration', [WebController::class, 'createStudent'])->middleware(['auth']);
Route::get('user/home', [WebController::class, 'home'])->name('home')->middleware(['auth']);

//adicao de nova inscrição
Route::post('user/home/enrollment/add', [EnrollmentController::class, 'store'])->name('enrollment-store')->middleware(['auth']);

Route::get('user/perfil', [WebController::class, 'perfil'])->name('perfil')->middleware(['auth']);

Route::post('/user/password/update', [WebController::class, 'passwordUpdate'])->middleware(['auth']);
Route::post('/user/contact/update', [WebController::class, 'contactUpdate'])->middleware(['auth']);

Route::post('/logout', function(){
	auth()->logout();
	request()->session()->invalidate();
	return redirect()->route('login');
})->name('logout');


#Rotas para gestores do Registo academico
Route::get('/manager/home/{student_code?}', [WebController::class, 'homeManager'])->name('home-manager')->middleware('auth:manager');
Route::prefix('admin')->middleware('auth:manager')->group(function () {
    Route::get('/home', [WebController::class, 'homeAdmin'])->name('home-admin');
    Route::get('/manager', [WebController::class, 'managerDashboard'])->name('manager-dashboard');
    Route::get('/student', [WebController::class, 'studentDashboard'])->name('student-dashboard');
    Route::prefix('/students')->group(function(){
        Route::get('/list',[StudentController::class,'index'])->name('student-list');
        Route::get('/show/{student_id?}',[StudentController::class,'show'])->name('student-show');
        Route::get('/add',[AdminController::class,'adminEstudanteAdicionar'])->name('student-add');
        Route::get('/search',[StudentController::class,'index'])->name('student-search');
        Route::post('/store',[AdminController::class,'adminEstudanteStore'])->name('admin-student-store');
        Route::get('/edit/{studente_code?}',[StudentController::class,'edit'])->name('student-edit');
    });
    Route::prefix('/managers')->group(function(){
        Route::get('/list',[ManagerController::class,'index'])->name('manager-list');
        Route::get('/search',[ManagerController::class,'index'])->name('manager-search');
        Route::get('/add',[AdminController::class,'AdminGestorAdicionar'])->name('manager-add');
        Route::post('/store',[AdminController::class,'AdminGestorStore'])->name('admin-manager-store');
        Route::get('/edit/{studente_code?}',[ManagerController::class,'edit'])->name('manager-edit');
    });
    Route::prefix('/admins')->group(function(){
        Route::get('/list',[AdminController::class,'index'])->name('admin-list');
        Route::get('/add',[AdminController::class,'store'])->name('admin-add');
        Route::get('/edit/{studente_code?}',[AdminController::class,'edit'])->name('admin-edit');
    });
    Route::prefix('/propinas')->group(function(){
        Route::get('/list',[MovementStudentController::class,'index'])->name('propina-list');
        Route::get('/list',[MovementStudentController::class,'index'])->name('propina-list');
        Route::post('/search',[MovementStudentController::class,'index'])->name('propina-search');
        Route::post('/store',[AdminController::class,'AdminPropinaStore'])->name('admin-propina-store');
        Route::get('/add/{student_id?}',[AdminController::class,'AdminPropinaAdicionar'])->name('propina-add');
        Route::get('/edit/{studente_code?}',[AdminController::class,'edit'])->name('propina-edit');
    });
    Route::prefix('/enrollments')->group(function(){
        Route::get('/list',[EnrollmentController::class,'index'])->name('enrollment-list');
        Route::get('/add',[AdminController::class,'adminInscricaoAdicionar'])->name('enrollment-add');
        Route::post('/store',[AdminController::class,'adminInscricaoStore'])->name('admin-enrollment-store');
        Route::get('/edit/{studente_code?}',[EnrollmentController::class,'edit'])->name('enrollment-edit');
    });
});

Route::get('/manager/perfil', [WebController::class, 'perfilManager'])->name('perfil-manager')->middleware('auth:manager');
Route::post('/manager/password/update', [WebController::class, 'passwordUpdateManager'])->middleware(['auth:manager']);
//Visualizacao do perfil do estudante inscrito
Route::get('/manager/student/{code}', [WebController::class, 'studentManager'])->middleware('auth:manager');

//Rota de pagamento dentro do sistema
Route::post('/manager/student/payment', [WebController::class, 'studentMovement'])->middleware('auth:manager');
Route::post('/manager/student/aprovated', [WebController::class, 'studentAprovated'])->middleware('auth:manager');

//Impressao de Recipo de comprovativo de pagamento
Route::get('manager/student/receipt-payment/{number}', [PrintController::class, 'receiptPayment'])->middleware('auth:manager');

Route::get('/printer/recipient-inscription/{code}/{id}', [PrintController::class, 'print']);
