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

use App\Events\NewMessage;
use App\ExpenseInput;
use App\Http\Resources\UserResource;
use App\Notifications\MessageSendNotify;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

// Route::get('/home', function () {
//     return redirect('/dashboard');
// });
// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login-admin');
Route::get('logoutUser',"API\UserController@SessionUser")->name('logoutUser');

Route::post('/register-students','SecretaryController@registerStudent')->name('student.join');
// Route::group(['middleware' => ['auth']], function () {
Route::post('/register-new-student','SecretaryController@registerStudent')->name('new-register.student');

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::resource('/accounts/inflows', 'Accounts\InflowController',['as'=>'accounts']);
    Route::resource('/accounts/outflows', 'Accounts\OutflowController',['as'=>'accounts']);
    // Route::resource('/accounts/school-accounts', 'Accounts\SchoolAccountController',['as'=>'accounts']);
    Route::resource('/students', 'Routine\StudentController');
    Route::get('/student/a-level','Routine\StudentController@indexAlevel');
    Route::get('/student/o-level','Routine\StudentController@indexOlevel');


    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@myProfile')->name('profile');
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
// student life
Route::get('students-1-2','SecretaryController@getStudents12')->name('students.1-2');
Route::get('students-3-4','SecretaryController@getStudents34')->name('students.3-4');
Route::get('students-5-6','SecretaryController@getStudents56')->name('students.5-6');
    Route::view('/home', 'home')->middleware('auth');
    Route::view('/admin', 'admin')->middleware('auth');
    Route::get('/student', 'StudentController@indexStudent');
    Route::get('/student-previous-results', 'StudentController@studentResults');
    Route::get('/student-current-results', 'StudentController@studentCurrentResults');
    Route::view('/reg', 'reg-std');
    Route::get('/report-pdf-export/{id}','StudentController@pdfExport');

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
        'classes'=>'ClassController',
        'papers'=>'PaperController',
        'manage-combinations'=>'CombinationController',
        // Accounts
        'desposits'=>'DepositController',
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
    Route::get('/view-classes','SchoolClassController@viewAllClasses');
    Route::get('/create-classes','ClassController@createClass');
    Route::post('/create-classes','ClassController@storeClass');
    Route::get('/create-streams','ClassController@createStream');
    Route::post('/create-streams','ClassController@storeStream');
    // streams
    Route::get('/edit-stream/{id}/edit','ClassController@editStream');
    Route::delete('/delete-stream/{id}','ClassController@deleteStream');
    Route::post('/edit-stream','ClassController@updateStream');
    Route::get('/all-streams','ClassController@getAllstreams');

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
    Route::get('/pdf/print-results','ResultController@printPdf');

    Route::get('/send',function(){

        $when =Carbon::now()->addSeconds(10);
        User::find(1)->notify((new MessageSendNotify)->delay($when));
        // $users = User::find(1);
        // Notification::send($users, new MessageSendNotify());

    });
    Route::get('/all-level-report','printReportController@getAlevelreport');
    Route::resources([
        'sets'=>'ExmsetController'
    ]);



// });


Route::view('/dashy', 'layouts.main-dashboard');
Route::resource('paper-comments', 'PpTrCommentController');
Route::get('/get-comment-model/{student}/{teacher}/{subject}/comment','ResultController@commentSubject');
Route::post('/result-search','ResultController@ResultSearch');
Route::resource('/declares', 'DeclareResultsController');
Route::post('/entry-status','DeclareResultsController@allowEntryStatus');

Route::resources([
    '/accounts/burser' =>'Accounts\BurserController'
]);
Route::get('results/{search_year}/{search_class}/{search_term}/{search_student}','StudentController@resultAll');


//fianance
Route::resource('/accounts/acc-category', 'AccCategoryController');
Route::get('/accounts/school-accounts','Accounts\AccountantController@index')->name('school_accounts.index');
Route::delete('/accounts/school-accounts-delete/{id}','Accounts\AccountantController@delete')->name('school_accounts.delete');
Route::resources([
    '/accounts/structures'=>'FeeStructureController',
]);
Route::get('/accounts/school-account','Accounts\AccountantController@getCreateAccountForm')->name('account.create');
Route::post('/accounts/school-account','Accounts\AccountantController@storeAccountForm')->name('account.store');
// Route::post('/accounts/school-account')->name();
// Route::post('/accounts/school-account')->name(); //edit account types

//student payments
Route::get('/students-payments/all-payments','Accounts\BurserController@allStudentsPayment')->name('payments.all-payments');
Route::get('/student-payments','Accounts\BurserController@studentPayments')->name('payments.students');
Route::get('/student-payment','Accounts\BurserController@studentPaymentGet')->name('payments.student-payment');
Route::post('/student-payment','Accounts\BurserController@studentPaymentPost')->name('payments.student-store');
//expenses
Route::resources([
    '/expenses'=>'ExpenseController',
    '/expenses/exp-categories'=>'Accounts\OutflowCategoryController',
]);
Route::get('/expenses-items/get-items','ExpenseController@fetchItems')->name('expenses.fetch-items');
Route::post('/expenses-items/get-form','ExpenseController@getForm')->name('expenses.get-form');
Route::post('/expenses-items/get-results','ExpenseController@getBorrow')->name('expenses.get-results');
Route::post('/expenses-borrow/inputs','ExpenseController@getBorrowInput')->name('expenses-borrow.inputs');
Route::post('/expenses-remove/item','ExpenseController@deleteItem')->name('remove-item');

Route::get('/get-remaing','ExpenseController@remainChange')->name('remaining');


//messaging

Route::resource('messages', 'CreateMessageController');
// Route::get('/spa/chat','AppController@get');
// Route::get('/spa/cities','AppController@get');
// Route::get('/spa/contact','AppController@get');
// Route::get('/s','AppController@get');
Route::get('/portal/{any}','AppController@get')->where('any','.*');

Route::get('/listings', 'ListingController@getIndex');

Route::get('/details/{id}', 'ListingController@getDetails');
Route::get('/chat-room',function(){
    return view('chat-room');
});
Route::get('/chat-index',function(){
    return view('chat-index');
});

Route::middleware('auth')->get('web-events',function(){

    return view('web-events');
});

Route::get('/chat-room','ChatController@index')->name('chat-room.all');
Route::get('/test-vue','Tests\TestController@index');

Route::get('/v2/chats',function(){
    broadcast(new NewMessage('New Something'));
    return view('chat.v2-chats');
});
Route::group(['prefix' => 'admin'], function () {

});
Route::group(['middleware'=>'auth','prefix'=>'follows'],function(){{
    Route::post('/comment',"CommentController@storeComment")->name('comment');
    Route::get('/users','Tests\TestController@users')->name('follows.users');
    Route::get('/users/{user}','Tests\TestController@showUser')->name('follows.user.show');
    Route::get('/comments/{comment}','Tests\TestController@showComment')->name('follows.comment.show');
    Route::post('/users/{user}/follow','Tests\TestController@follow')->name('follows.follow');
    Route::delete('/users/{user}/unfollow','Tests\TestController@unfollow')->name('follows.unfollow');
    Route::get('/notifications','Tests\TestController@notifications')->name('follows.notifications');
    Route::get('/all-notifications/{unread}/{already}','Tests\TestController@allNotifications');
}});

Route::middleware("auth")->get('/all-notifications','Tests\TestController@allNotifications');
Route::group(['middleware'=>'auth'],function(){
    Route::get('/messenger','MessengerController@index')->name('messenger.index');
    Route::get('/messenger/{user_id}','MessengerController@getMessages')->name('messenger.fetch-messages');
    Route::post('/messenger','MessengerController@sendMessage');

    //school_accounts
Route::get('accounts-index', 'AccountController@accountView')->name('accounts-index');
    //salary
    Route::get('/employee-salaries','Salary\SalaryController@employeeSalary')->name('employee-salary.index');

    Route::get('print-test','PdfController@printTestTfile');
    Route::get('print-invoice','PdfController@printInvoice');
    Route::get('print-expense','PdfController@printExpense')->name('print.expense');

    //payments
    Route::get('make-payment','API\PaymentsController@makePayment')->name('make-payment');
    Route::get('view-payments','API\PaymentsController@viewPayments')->name('view-payments');
    Route::get('view-expenses','API\PaymentsController@viewExpenses')->name('view-expenses');
    Route::get('overview-payments','PaymentReportController@overviewPayments')->name('overview-payments');
    Route::get('overview-expenses','ExpenseReportController@overviewPayments')->name('overview-expenses');
    Route::get('overview-payments-and-expenses','PaymentReportController@overview')->name('overview-payments-and-expenses');

    Route::get('graph-payments','PaymentReportController@graphPayments')->name('graph-payments');
    Route::get('graph-expenses','ExpenseReportController@graphExpenses')->name('graph-expenses');
    Route::get('graph-payments-and-expenses','PaymentReportController@graphIncomeStatement')->name('graph-payments-and-expenses');

});

Route::get('/test-dashboard',function(){
   return view('tests.dashboard');
});
Route::get('/test-dashboardv2',function(){
    return view('tests.dashboardv2');
 });
 Route::middleware('auth','api')->get('/test-main-layout',function(){
    return view('portals.layouts.main');
 });



