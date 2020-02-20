<?php

namespace App\Http\Controllers;

use App\Exmset;
use App\Models\Student;
use App\Result;
use App\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class printReportController extends Controller
{
    //

    public function getAlevelreport()
    {
        $results = Result::get();
        $students = new Student();
        $studentz = Student::orderBy('name','asc')->get();
        $schclasses = Auth::user()->schclasses()->get();
        $subjects = Auth::user()->subjects()->get();
        $sets = Exmset::orderBy('id','asc')->get();
        $terms = Term::orderBy('id','asc')->get();

        return view('manage-results.a-level',compact('results','students','schclasses','subjects','terms','sets','studentz'));
    }

}
