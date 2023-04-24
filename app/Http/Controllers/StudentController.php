<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::select('students.passport', 'students.name', 'universities.university_name', 'cities.city', 'regions.region')
        ->leftjoin('universities', 'universities.id', '=', 'students.university_id')
        ->leftjoin('cities', 'cities.id', '=', 'universities.city_id')
        ->leftjoin('regions', 'regions.id', '=', 'cities.region_id')
        ->orderBy('regions.id', 'asc')
        ->orderBy('cities.id', 'asc')
        ->orderBy('universities.id', 'asc')
        ->get();        

        $response = [
            'status' => 'success',
            'students' => $students
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function studentCheck(Request $request)
    {                
        $student = Students::where('passport', $request->passport)->first();        

        if (!$student) {
            $response = [
                'status' => 'success',
                'message' => 'Student available'
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Student already exists'
            ];

            return response()->json($response, 404);
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        try {
            $students = new Students();
            $students->passport = $request->passport;
            $students->name = $request->name;
            $students->birthday = $request->birthday;
            $students->birthplace = $request->birthplace;
            $students->sex = $request->sex;
            $students->origin = $request->origin;
            $students->major = $request->major;
            $students->degree = $request->degree;
            $students->start_year = $request->start_year;
            $students->finish_year = $request->finish_year;
            $students->wechat_id = $request->wechat_id;
            $students->phone = $request->phone;
            $students->emergency_phone = $request->emergency_phone;
            $students->email = $request->email;
            $students->scholarship = $request->scholarship;
            $students->scholarship_type = $request->scholarship_type;
            $students->agency = $request->agency;
            $students->university_id = $request->university_id;
            $students->save();

            $response = [
                'status' => 'success',
                'message' => 'Student created successfully'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
            return response()->json($response, 500);
        }


        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students)
    {
        //
    }
}
