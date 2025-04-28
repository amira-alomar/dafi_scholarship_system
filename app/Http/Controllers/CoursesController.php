<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class CoursesController extends Controller
{
    public function index()
    {
        return view('student.courses');
    }
}
