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

        return view('student.courses', compact('courses','editingCourse','major'));
    }

    // تخزين كورس جديد
    public function store(Request $request)
    {

        
        // $request->validate([
        //     'semester' => 'required|string|max:10',
        //     'course_name' => 'required|string|max:255',
        //     'code' => 'required|string|max:255',
        //       'grade' => 'nullable|string|max:255',
        //      'credit' => 'required|integer|max:10',
        //     'registration_image' => 'nullable|image|max:2048', // صورة التسجيل
        // ]);

        $data = $request->only(['semester','credit', 'course_name', 'grade','code']);
        $data['idUser'] = Auth::id();
        // إذا لديك idUni في studentInfo:
        $data['idUni'] = Auth::user()->studentInfo->idUni ?? null;

        // رفع الصورة إذا وجدت
        if ($file = $request->file('registration_image')) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('course_images'), $filename);
            $data['image'] = $filename;
        }

       $created = Course::create($data);

if (!$created) {
    dd('failed to save');
}

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course added successfully!');
    }

public function update(Request $request, Course $course)
{
    $request->validate([
        // 'semester' => 'required|string|max:10',
        // 'course_name' => 'required|string|max:255',
        // 'code' => 'required|string|max:255',
        // 'grade' => 'nullable|string|max:255',
        // 'credit' => 'required|integer|max:10',
        // 'registration_image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['semester','credit', 'course_name', 'code', 'grade']);

    if ($request->hasFile('registration_image')) {
        $filename = time() . '_' . $request->file('registration_image')->getClientOriginalName();
       $request->file('registration_image')->move(public_path('course_images'), $filename);
        $data['image'] = $filename;
    }else {
        // الإبقاء على الصورة القديمة
        $data['image'] = $course->image;
    }

    $course->update($data);

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
}

public function edit(Course $course)
{
   

    // جلب جميع الدورات لعرض الجدول
    $courses = Course::where('idUser', Auth::id())->get();

    // عرض الصفحة مع تمرير الدورة قيد التعديل
    return view('student.courses', [
        'courses' => $courses,
        'editingCourse' => $course,
    ]);
}

}