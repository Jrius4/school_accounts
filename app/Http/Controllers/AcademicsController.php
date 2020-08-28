<?php

namespace App\Http\Controllers;

use App\Schstream;
use Illuminate\Http\Request;

class AcademicsController extends Controller
{
    public function classesView()
    {
        return view('academic.class-index');
    }
    public function getStreams(Request $request)
    {
        $streams = new Schstream();
        $query = $request->query('query');
        $page = $request->query('page');

        $rowsPerPage = $request->query('rowsPerPage');
        if ($rowsPerPage == "All")  $rowsPerPage = Schstream::count();
        $streams = $streams->with('students', 'schoolClasses')->where('name', 'like', "%" . $query . "%")->paginate($rowsPerPage);
        return response()->json(compact('streams'));
    }
}
