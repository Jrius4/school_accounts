<?php

use App\Combination;
use App\Http\Requests\Request as RequestsRequest;
use App\Models\Student;
use App\Role;
use App\Schclass;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return User::with('roles')->find($request->user()->id);
});
Route::middleware('auth:api')->get('/search-student', 'Routine\StudentController@searchStudent');
Route::post('/get-data', 'TeacherController@postRoles');
Route::get('/students', function () {
    $student = new Student();
    if (request('q') !== null) {
        $term = '%' . request('q') . '%';
        $student = DB::select("SELECT * FROM students WHERE name LIKE ?", [$term]);
        return response()->json($student);
    } else {
        $student = $student->orderBy('name')->get();
        return response()->json($student);
    }
});

Route::get('/get-students', function () {
    $student = Student::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $student;
});

Route::get('/get-roles', function () {
    $roles = Role::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $roles;
});
Route::get('/get-classes', function () {
    $roles = Schclass::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $roles;
});
Route::get('/get-teachers', function () {
    $roles = Role::whereName('teacher')->first()->users()->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $roles;
});
Route::get('/get-subjects', function () {
    $subject = Subject::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $subject;
});
Route::get('/get-a-level-subjects', function () {
    $subject = Subject::where('subject_compulsory', false)->where('level', 'Advanced Level')->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $subject;
});
Route::get('/get-a-level-combination', function () {
    $comb = Combination::where('level', 'Advanced Level')->where('combination_name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $comb;
});
Route::get('/get-o-level-subjects', function () {
    $subject = Subject::where('subject_compulsory', false)->where('level', 'Ordinary Level')->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $subject;
});



//teacher classes
Route::get('/get-classes-teacher', function () {
    $schclasses = Schclass::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
    return $schclasses;
});
Route::post('/search-results', function (Request $request) {
    return response()->json(['data' => $request['query']]);
});

Route::get('/marks/{one}/{two}/{three}/grade', 'ResultController@papers');

Route::resource('vue-cities', 'CityVueController');
Route::get('get-user', function () {
    $user = User::find(1);
    $id = Auth::user();
    return response()->json(compact('user', 'id'));
});

// Route::middleware('auth:api')->group(function(){
//     Route::post('logout', 'API\UserController@logout');
//     Route::resource('files', 'API\FileController');

// });

//expenses
// Route::middleware('auth:api')->resource('make-expenses','API\MakeExpenseController');
Route::middleware('auth:api')->get('make-expenses', 'API\MakeExpenseController@index');
Route::middleware('auth:api')->post('make-expenses', 'API\MakeExpenseController@store');
Route::middleware('auth:api')->put('make-expenses/{make_expense}', 'API\MakeExpenseController@update');
Route::middleware('auth:api')->get('make-expenses/{make_expense}', 'API\MakeExpenseController@show');
Route::middleware('auth:api')->delete('make-expenses/{make_expense}', 'API\MakeExpenseController@destroy');
Route::middleware('auth:api')->get('get_accountz', 'API\MakeExpenseController@fetchAccounts');
Route::middleware('auth:api')->post('store-expense', 'API\MakeExpenseController@storeExpense');

Route::middleware('auth:api')->post('getloan', 'Accounts\AccountantController@getLoanInput');
Route::middleware('auth:api')->get('getloanaccounts', 'API\MakeExpenseController@fetchLoanAccounts');

Route::get('/comments', "CommentController@index");
Route::middleware('auth:api')->group(function () {
    Route::post('/comment', "CommentController@store");
    Route::get('/v1/messages', 'ChatController@fetchAllMessages');
    Route::post('/v1/messages', 'ChatController@sendMessage');
    Route::get('/v1/getEmployees', 'Salary\SalaryController@getEmployees');
    Route::post('/v1/saveSalaryEmployee', 'Salary\SalaryController@saveEmployee');

    Route::get('/v1/users', 'API\UserController@fetchUsers');
    Route::get('/v1/get-users', 'API\UserController@getUsers');
    Route::get('/v1/get-users/{user}', 'API\UserController@getUser');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user-tasks', 'TaskController@index');
    Route::post('/user-tasks', 'TaskController@store');
    Route::get('/user-tasks/{id}', 'TaskController@show');
    Route::post('/user-tasks/{id}', 'TaskController@update');
    Route::delete('/user-tasks/{id}', 'TaskController@destroy');

    Route::get('/account-types', "AccountTypeController@index");
    Route::post('/account-types', 'AccountTypeController@store');
    Route::get('/account-types/{id}', 'AccountTypeController@show');
    Route::post('/account-types/{id}', 'AccountTypeController@update');
    Route::delete('/account-types/{id}', 'AccountTypeController@destroy');

    Route::get('/accounts', 'AccountController@index');
    Route::post('/accounts', 'AccountController@store');
    Route::get('/accounts/{id}', 'AccountController@show');
    Route::post('/accounts/{id}', 'AccountController@update');
    Route::delete('/accounts/{id}', 'AccountController@destroy');


    Route::get('/accounts/{account_id}/structures', 'FeesStructureController@index');
    Route::post('/accounts/{account_id}/structures', 'FeesStructureController@store');
    Route::get('/accounts/{account_id}/structures/{id}', 'FeesStructureController@show');
    Route::post('/accounts/{account_id}/structures/{id}', 'FeesStructureController@update');
    Route::delete('/accounts/{account_id}/structures/{id}', 'FeesStructureController@destroy');

    Route::get('payment-details', 'PaymentReportController@indexDetailed');
    Route::get('payment-reports', 'PaymentReportController@overviewReport');

    Route::get('v1/get-students', 'API\StudentsController@getStudents')->name('get-students.all');

    Route::get('expense-details', 'ExpenseReportController@indexDetailed');

    Route::get('overview-payments', 'PaymentReportController@overviewReport');
    Route::get('overview-expenses', 'ExpenseReportController@overviewReport');
    Route::post('make-payment', 'API\MakePaymentsController@storePayment');

    //roles & permissions

    Route::get('roles', 'API\RolesController@getRoles');
    Route::post('roles', 'API\RolesController@saveRole');
    Route::get('roles/{role}', 'API\RolesController@showRole');
    Route::post('roles/users/check-uniqueness', 'API\RolesController@checkUniqueness');
    Route::post('roles/create-user', 'API\RolesController@createUser');

    Route::get('permissions', 'API\RolesController@getPermissions');
    Route::get('permissions/{permission}', 'API\RolesController@showPermission');
});

Route::get('details', 'PaymentReportController@listOutcomes');
