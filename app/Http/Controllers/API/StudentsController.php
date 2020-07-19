<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentsController extends Controller
{
    public function getStudents(Request $request)
    {

        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage')!=null?$request->query('rowsPerPage'):5;
        $sortRowsBy = 'name';
        $sortDesc = false;
        if(isset($request['sortDesc']) && $request['sortDesc'] !== '' ){
            $sortDesc = $request['sortDesc'] == 'true'?true:false;
        }
        else{
            $sortDesc = false;
        }
        if(isset($request['sortRowsBy']) && $request['sortRowsBy']!==''){
            $sortRowsBy = $request['sortRowsBy'];
        }
        else{
            $sortRowsBy = 'name';
        }
        $students = Student::with('schclass','schstream')->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('name','like','%'.$query.'%')->orWhere('roll_number','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json(compact('students'));
    }
}
