<?php

use App\Combination;
use App\Http\Requests\Request as RequestsRequest;
use App\Models\Student;
use App\Role;
use App\Schclass;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
    return $request->user();
});
Route::post('/get-data','TeacherController@postRoles');
Route::get('/students',function(){
    $student = new Student();
    if(request('q' )!== null){
        $term = '%'.request('q').'%';
        $student = DB::select("SELECT * FROM students WHERE name LIKE ?",[$term]);
        return response()->json($student);
    }else{
        $student = $student->orderBy('name')->get();
        return response()->json($student);
    }

});

Route::get('/get-students',function(){
    $student = Student::where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $student;
});

Route::get('/get-roles',function(){
    $roles = Role::where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $roles;
});
Route::get('/get-classes',function(){
    $roles = Schclass::where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $roles;
});
Route::get('/get-teachers',function(){
    $roles = Role::whereName('teacher')->first()->users()->where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $roles;
});
Route::get('/get-subjects',function(){
    $subject = Subject::where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $subject;
});
Route::get('/get-a-level-subjects',function(){
    $subject = Subject::where('subject_compulsory',false)->where('level','Advanced Level')->where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $subject;
});
Route::get('/get-a-level-combination',function(){
    $comb = Combination::where('level','Advanced Level')->where('combination_name','LIKE','%'.request('q').'%')->paginate(10);
    return $comb;
});
Route::get('/get-o-level-subjects',function(){
    $subject = Subject::where('subject_compulsory',false)->where('level','Ordinary Level')->where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $subject;
});

Route::post('/register-students','StudentController@registerStudent');

//teacher classes
Route::get('/get-classes-teacher',function(){
    $schclasses = Schclass::where('name','LIKE','%'.request('q').'%')->paginate(10);
    return $schclasses;
});
Route::post('/search-results',function(Request $request){
    return response()->json(['data'=>$request['query']]);
});

