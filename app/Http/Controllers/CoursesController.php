<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\StudentInfo;


class CoursesController extends Controller
{
        public function index(Request $request)
    {
        $userId = Auth::id();
        $studentInfo = auth()->user()->studentInfo;
        $major =  optional($studentInfo)->major ?? null;
        $courses = Course::where('idUser', $userId)->get();
    
    $editingCourse = null;
    if ($request->has('edit')) {
        $editingCourse = Course::where('idUser', $userId)->find($request->edit);
    }

        return view('student.courses', compact('courses','editingCourse'));
    }

    // تخزين كورس جديد
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:10',
            'course_name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'registration_image' => 'nullable|image|max:2048', // صورة التسجيل
        ]);

        $data = $request->only(['semester', 'course_name', 'grade','code']);
        $data['registration_image'] = null;
        $data['idUser'] = Auth::id();
        // إذا لديك idUni في studentInfo:
        $data['idUni'] = Auth::user()->studentInfo->idUni ?? null;

        // رفع الصورة إذا وجدت
        if ($file = $request->file('registration_image')) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('course_images'), $filename);
            $data['image'] = $filename;
        }

        Course::create($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course added successfully!');
    }

public function update(Request $request, Course $course)
{
    $request->validate([
        'semester' => 'required|string|max:10',
        'course_name' => 'required|string|max:255',
        'code' => 'required|string|max:255',
        'grade' => 'required|string|max:10',
        'registration_image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['semester', 'course_name', 'code', 'grade']);

    if ($request->hasFile('registration_image')) {
        $filename = time() . '_' . $request->file('registration_image')->getClientOriginalName();
        $request->file('registration_image')->storeAs('public/course_images', $filename);
        $data['image'] = $filename;
    }

    $course->update($data);

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
}


}
