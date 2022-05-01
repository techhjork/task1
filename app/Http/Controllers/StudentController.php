<?php

namespace App\Http\Controllers;

use App\Models\UserCourse;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function showCourses(Request $request)
    {
        // dump(\Auth::id());
        $courses = UserCourse::where([
            'class_id' => $request->route('id'),
            'user_id' => \Auth::id(),
        ])->with('course')->get();
        // dd($courses);
        return view('course', [
            'courses' => $courses,
        ]);
    }
    public function showUserCourseStatus(Request $request)
    {
        $data = [
            "user_id" => \Auth::id(),
            "class_id" => $request->class_id,
            "course_id" => $request->id,
        ];
        $data = UserCourse::create($data);
        return $data;
    }

}
