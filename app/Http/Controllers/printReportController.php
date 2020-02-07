<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Result;
use Illuminate\Http\Request;

class printReportController extends Controller
{
    //

    public function getAlevelreport()
    {
        $results = Result::get();
        $students = new Student();
        return view('manage-results.a-level',compact('results','students'));
    }
}
