<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;
use App\Schclass;
use App\Subject;
use App\User;

class ClassResultController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('query');
        $event = $request->query('event');
        $results = null;
        $exams = new Exam();
        $from = null;
        $classes = new Schclass();
        $subjects = new Subject();
        if ($event == 'class') {
            if ($classes->where('slug', $query)->exists()) {
                $from = $classes->where('slug', $query)->first();
            }
        } elseif ($event == 'subject') {
            if ($subjects->where('slug', $query)->exists()) {
                $from = $subjects->where('slug', $query)->first();
            }
        }




        return view('manage-results.class-results', compact('event', 'query', 'from'));
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
        $query = $request->query('query');
        $event = $request->query('event');
        $results = null;
        $item_id = null;
        $classes = new Schclass();
        $subjects = new Subject();
        $exams = new Exam();
        if ($event == 'class') {
            if ($classes->where('slug', $query)->exists()) {
                $item_id = $classes->where('slug', $query)->first()->id;
            }
            $results = $exams->with('student', 'schclass', 'subject')->latest()->where('year', date('Y'))->where('schclass_id', $item_id)->get();
        } elseif ($event == 'subject') {
            if ($subjects->where('slug', $query)->exists()) {
                $item_id = $subjects->where('slug', $query)->first()->id;
            }
            $results = $exams->with('student', 'schclass', 'subject')->latest()->where('year', date('Y'))->where('subject_id', $item_id)->get();
        } else {
            $results = $exams->with('student', 'schclass', 'subject')->latest()->get();
        }

        // $results = compact('event', 'item_id');

        return response()->json(compact('results'));
    }
}
