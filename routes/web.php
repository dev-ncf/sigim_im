<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MovementStudentController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Models\Admin;
use App\Models\MovementStudent;
use App\Models\Student;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
Route::post('/user/student/registration', [WebController::class, 'createStudent'])->name('student-registration');
Route::get('user/home', [WebController::class, 'home'])->name('home')->middleware(['auth']);

//adicao de nova inscrição
Route::post('user/home/enrollment/add', [EnrollmentController::class, 'store'])->name('enrollment-store')->middleware(['auth']);
Route::put('user/home/enrollment/matricular/{enrollment}', [EnrollmentController::class, 'matricular'])->name('enrollment-matricular')->middleware(['auth']);

Route::get('user/perfil', [WebController::class, 'perfil'])->name('perfil')->middleware(['auth']);

Route::post('/user/password/update', [WebController::class, 'passwordUpdate'])->middleware(['auth']);
Route::post('/user/contact/update', [WebController::class, 'contactUpdate'])->middleware(['auth']);

Route::post('/logout',[WebController::class, 'logout'])->name('logout');


#Rotas para gestores do Registo academico
Route::get('/manager/home/{student_code?}', [WebController::class, 'homeManager'])->name('home-manager')->middleware('auth:manager');

Route::prefix('admin')->middleware('auth:manager')->group(function () {
    Route::get('', [WebController::class, 'homeAdmin'])->name('home-admin');
    Route::get('/manager', [WebController::class, 'managerDashboard'])->name('manager-dashboard');
    Route::get('/student', [WebController::class, 'studentDashboard'])->name('student-dashboard');
    Route::prefix('/students')->group(function(){
        Route::get('/list',[StudentController::class,'index'])->name('student-list');
        Route::get('/show/{student_id?}',[StudentController::class,'show'])->name('student-show');
        Route::get('/add',[AdminController::class,'adminEstudanteAdicionar'])->name('student-add');
        Route::get('/search',[StudentController::class,'index'])->name('student-search');
        Route::post('/store',[AdminController::class,'adminEstudanteStore'])->name('admin-student-store');
         Route::post('/update-password/{student?}',[StudentController::class,'updatePassword'])->name('student-update-password');
        Route::get('/edit/{studente_code?}',[StudentController::class,'edit'])->name('student-edit');
        Route::put('/update/{student?}',[StudentController::class,'update'])->name('student-update');
        Route::get('/delete/{student?}',[StudentController::class,'destroy'])->name('student-delete');
        Route::get('/active-deactive/{student?}',[StudentController::class,'activeDeactive'])->name('student-active-deactive');
    });
    Route::prefix('/user')->group(function(){
        Route::get('/show/{manager?}',[ManagerController::class,'userShow'])->name('user-show');
        Route::post('/user-update-password/{manager?}',[ManagerController::class,'userUpdatePassword'])->name('user-update-password');
    });
    Route::prefix('/managers')->group(function(){
        Route::get('/list',[ManagerController::class,'index'])->name('manager-list');
        Route::get('/search',[ManagerController::class,'index'])->name('manager-search');
        Route::get('/add',[AdminController::class,'AdminGestorAdicionar'])->name('manager-add');
        Route::post('/store',[AdminController::class,'AdminGestorStore'])->name('admin-manager-store');
        Route::get('/edit/{manager?}',[ManagerController::class,'edit'])->name('manager-edit');
        Route::get('/show/{manager?}',[ManagerController::class,'show'])->name('manager-show');
        Route::get('/active-deactive/{manager?}',[ManagerController::class,'activeDeactive'])->name('manager-active-deactive');
        Route::post('/update/{manager?}',[ManagerController::class,'update'])->name('manager-update');
        Route::post('/update-password/{manager?}',[ManagerController::class,'updatePassword'])->name('manager-update-password');
        Route::get('/delete/{manager?}',[ManagerController::class,'destroy'])->name('manager-delete');
    });
    Route::prefix('/admins')->group(function(){
        Route::get('/list',[AdminController::class,'index'])->name('admin-list');
        Route::get('/add',[AdminController::class,'store'])->name('admin-add');
        Route::get('/edit/{studente_code?}',[AdminController::class,'edit'])->name('admin-edit');
    });
    Route::prefix('/propinas')->group(function(){
        Route::get('/list',[MovementStudentController::class,'index'])->name('propina-list');
        Route::get('print/{number}', [PrintController::class, 'receiptPayment'])->name('propina-print');
        Route::post('/search',[MovementStudentController::class,'index'])->name('propina-search');
        Route::post('/store',[AdminController::class,'AdminPropinaStore'])->name('admin-propina-store');
        Route::post('/update',[MovementStudentController::class,'update'])->name('admin-propina-update');
        Route::get('/add/{student_id?}',[AdminController::class,'AdminPropinaAdicionar'])->name('propina-add');
        Route::get('/edit/{movementStudent?}',[MovementStudentController::class,'edit'])->name('propina-edit');
        Route::get('/destroy/{movementStudent?}',[MovementStudentController::class,'destroy'])->name('propina-delete');
    });
    Route::prefix('/enrollments')->group(function(){
        Route::get('/list',[EnrollmentController::class,'index'])->name('enrollment-list');
        Route::post('/search',[EnrollmentController::class,'index'])->name('enrollment-search');
        Route::get('/add',[AdminController::class,'adminInscricaoAdicionar'])->name('enrollment-add');
        Route::post('/store',[AdminController::class,'adminInscricaoStore'])->name('admin-enrollment-store');
        Route::get('/edit/{enrollment?}',[EnrollmentController::class,'edit'])->name('enrollment-edit');
        Route::get('/destroy/{enrollment?}',[EnrollmentController::class,'destroy'])->name('enrollment-delete');
        Route::post('/update/{enrollment?}',[EnrollmentController::class,'update'])->name('admin-enrollment-update');
        Route::get('/approve/{enrollment?}',[EnrollmentController::class,'approve'])->name('enrollment-approve');
        Route::get('/print/{code}/{id}', [PrintController::class, 'print'])->name('enrollment-print');
    });
    Route::prefix('/faculties')->group(function(){
        Route::get('/list',[FacultyController::class,'index'])->name('faculty-list');
        Route::post('/search',[FacultyController::class,'index'])->name('faculty-search');
        Route::get('/add',[FacultyController::class,'create'])->name('faculty-add');
        Route::post('/store',[FacultyController::class,'store'])->name('faculty-store');
        Route::get('/edit/{faculty?}',[FacultyController::class,'edit'])->name('faculty-edit');
        Route::get('/show/{faculty?}',[FacultyController::class,'show'])->name('faculty-show');
        Route::get('/destroy/{faculty?}',[FacultyController::class,'destroy'])->name('faculty-delete');
        Route::post('/update/{faculty?}',[FacultyController::class,'update'])->name('faculty-update');
    });
    Route::prefix('/courses')->group(function(){
        Route::get('/list',[CourseController::class,'index'])->name('course-list');
        Route::post('/search',[CourseController::class,'index'])->name('course-search');
        Route::get('/add',[CourseController::class,'create'])->name('course-add');
        Route::post('/store',[CourseController::class,'store'])->name('course-store');
        Route::get('/edit/{course?}',[CourseController::class,'edit'])->name('course-edit');
        Route::get('/show/{course?}',[CourseController::class,'show'])->name('course-show');
        Route::get('/destroy/{course?}',[CourseController::class,'destroy'])->name('course-delete');
        Route::post('/update/{course?}',[CourseController::class,'update'])->name('course-update');
    });
    Route::prefix('/periodos')->group(function(){
        Route::get('/list',[PeriodoController::class,'index'])->name('periodo-list');
        Route::get('/add',[PeriodoController::class,'create'])->name('periodo-add');
        Route::post('/store',[PeriodoController::class,'store'])->name('periodo-store');
        Route::get('/edit/{periodo?}',[PeriodoController::class,'edit'])->name('periodo-edit');
        Route::post('/update/{periodo?}',[PeriodoController::class,'update'])->name('periodo-update');
        Route::post('/destroy/{periodo?}',[PeriodoController::class,'destroy'])->name('periodo-delete');
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

Route::get('/teste',function(){dd('Ola mundo');});
