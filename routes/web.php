<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Support\Facades\Auth;

// Route::get('/home', function () {
//     return redirect('/dashboard');
// });
// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::resource('/accounts/inflows', 'Accounts\InflowController',['as'=>'accounts']);
Route::resource('/accounts/outflows', 'Accounts\OutflowController',['as'=>'accounts']);
Route::resource('/accounts/school-accounts', 'Accounts\SchoolAccountController',['as'=>'accounts']);
Route::resource('/students', 'Routine\StudentController');
Route::get('/student/a-level','Routine\StudentController@indexAlevel');
Route::get('/student/o-level','Routine\StudentController@indexOlevel');


Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/form',function(){
    return view('manage-outflows.form');
});

Route::get('/table',function(){
    return view('manage-inflows.table');
});

// For authenticated users:

Route::group(['middleware' => ['auth']], function () {
    // login protected routes.
});

// For authenticated admin users:

Route::group(['middleware' => ['auth.admin']], function () {
    // login protected routes.
});


Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/student', 'Auth\LoginController@showStudentLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/student', 'Auth\RegisterController@showStudentRegisterForm')->name('register.student');

Route::post('/login/admin', 'Auth\LoginController@adminLogin')->name('login.admin');
Route::post('/login/student', 'Auth\LoginController@studentLogin')->name('login.student');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/student', 'Auth\RegisterController@createStudent');

Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin')->middleware('auth');
Route::view('/student', 'student');
Route::view('/reg', 'reg-std');

Route::resource('/files', 'FileController');
Route::resource('/routine/classes', 'SchoolClassController');
Route::resource('/routine/streams', 'ClassStreamController');
Route::resource('/routine/staffs', 'StaffController');
Route::resource('/routine/users', 'UserController');
Route::resources([
    'to-checks'=>'ToCheckController',
    'to-lists'=>'ToListController',
    'subjects'=>'SubjectController',
    'results'=>'ResultController',
]);

Route::resources([
    'roles'=>'RoleController',
    'permissions'=>'PermissionController',
    'teachers'=>'TeacherController',
    'students'=>'StudentController',
    'classes'=>'ClassController',
    'papers'=>'PaperController',
    'manage-combinations'=>'CombinationController',
    // Accounts
    'desposits'=>'DepositController',
    'expenses'=>'Accounts\OutflowController',
    'cities'=>'CityController',
    'tests'=>'AjaxController',
    'foods'=>'FoodController',
    'manage-students-results'=>'ManageStudentResultsController',
]);
Route::post('/file-file','FoodController@uploadfiles');
Route::get('/ajax-request','AjaxController@getCity');
Route::post('/ajax-request','AjaxController@postCity');
Route::post('/fetch','AjaxController@fetch');
Route::resource('ajax-crud', 'AjaxCrudController');

Route::post('ajax-crud/update', 'AjaxCrudController@update')->name('ajax-crud.update');

Route::get('ajax-crud/destroy/{id}', 'AjaxCrudController@destroy');
Route::get('get-subjects', 'TeacherController@getSubjects');
Route::get('get-classes', 'TeacherController@getClasses');
Route::get('get-roles', 'TeacherController@getRoles');
Route::post('get-roles', 'TeacherController@postRoles');
Route::resource('ajaxproducts','ProductAjaxController');
Route::get('/songs',function(){
        return new UserResource(User::all());
});

Route::get('ajaxImageUpload', 'AjaxImageController@ajaxImageUpload');

Route::post('ajaxImageUpload', 'AjaxImageController@ajaxImageUploadPost')->name('ajaxImageUpload');
Route::post('save-image','AjaxImageController@save');

# manage classes
Route::get('/create-classes','ClassController@createClass');
Route::post('/create-classes','ClassController@storeClass');
Route::get('/create-streams','ClassController@createStream');
Route::post('/create-streams','ClassController@storeStream');
Route::get('/assign-class-to-classteacher','ClassController@createAssignClassTeacherToClasses');
Route::post('/assign-class-to-classteacher','ClassController@storeAssignClassTeacherToClasses');

Route::post('/fetch-cities','CityController@fetchCity');
Route::post('/fetch-streams','ClassController@fetchStreams');
Route::post('/fetch-subjects','SubjectController@fetchSubjects');

Route::get('/assign_paper_subjects','SubjectController@getAssignPaper');
Route::post('/assign_paper_subjects','SubjectController@storeAssignPaper');

Route::get('/manage-combinations-O-level','CombinationController@getOlevelCombinations');
Route::post('/manage-combinations-O-level','CombinationController@storeOlevelCombinations');

Route::get('/manage-combinations-A-level','CombinationController@getAlevelCombinations');
Route::post('/manage-combinations-A-level','CombinationController@storeAlevelCombinations');
//academics to teachers
Route::get('/assign-subject-to-teacher','TeacherController@getAssignedSubjectsToTeacher');
Route::post('/assign-subject-to-teacher','TeacherController@storeAssignedSubjectsToTeacher');
Route::get('/assign-class-to-teacher','TeacherController@getAssignedClassToTeacher');
Route::post('/assign-class-to-teacher','TeacherController@storeAssignedClassToTeacher');
Route::get('/manage-assign-class-to-teacher','TeacherController@manageAssignedClassToTeacher');
Route::get('/manage-assign-subject-to-teacher','TeacherController@manageAssignedSubjectToTeacher');
//building results
Route::resource('marks', 'ResultController');
Route::get('/examsets/{term}/{set}/term-sets','ResultController@getBot');
Route::post('/fetch-papers','ResultController@fetchPapers');
Route::post('/store-student-marks','ResultController@storeStudentMarks');
Route::get('/manage-marks','ResultController@getManageMarks');
Route::post('/manage-marks','ResultController@fetchManageMarks');
