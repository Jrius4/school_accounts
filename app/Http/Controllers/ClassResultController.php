<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use App\Schclass;
use App\User;

class ClassResultController extends Controller
{
    public function index(Request $request, $class)
    {
        $classes = new Schclass();
        $class_id = $class;
        $class = null;

        if ($classes->where('slug', $class_id)->exists()) {
            $class = $classes->where('slug', $class_id)->first();
        }



        return view('manage-results.class-results', compact('class'));
    }
    public function allStudents(Request $request)
    {
    }
    public function allClasses(Request $request, $user)
    {
        $users = new User();
        $user_id = $user;
        $user = null;


        if ($users->where('id', $user_id)->exists()) {
            $user = $users->with('schclasses', 'subjects')->where('id', $user_id)->first();
        }
        return response()->json(compact('user'));
    }
    public function results(Request $request)
    {
        $item_id = $request->query('item_id');
        $event = $request->query('event');
        $results = null;
        $exams = new Exam();
        if ($event == 'class') {
            $results = $exams->with('student', 'schclass')->latest()->where('year', date('Y'))->where('schclass_id', $item_id)->paginate(20);
        } elseif ($event == 'subject') {
            $results = $exams->with('student', 'schclass')->latest()->where('year', date('Y'))->where('subject_id', $item_id)->paginate(20);
        } else {
            $results = $exams->with('student', 'schclass')->latest()->paginate(20);
        }

        // $results = compact('event', 'item_id');

        return response()->json(compact('results'));
    }
}
