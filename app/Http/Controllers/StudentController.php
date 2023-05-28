<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::select(
            'students.id',
            'students.passport', 
            'students.name', 
            'universities.university_name', 
            'cities.city', 
            'regions.region')
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
        DB::beginTransaction();
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
            $students->status = 'active';
            $students->created_at = date('Y-m-d H:i:s');
            $students->updated_at = date('Y-m-d H:i:s');
            $students->save();

            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Student created successfully',
                'data' => $students
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();
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
    public function show($students)
    {                
        try {
            $student = Students::
            leftjoin('universities', 'universities.id', '=', 'students.university_id')
            ->leftjoin('cities', 'cities.id', '=', 'universities.city_id')
            ->leftjoin('regions', 'regions.id', '=', 'cities.region_id')
            ->select(
                'students.passport', 
                'students.name',                 
                'students.birthday',
                'students.birthplace',
                'students.sex',
                'students.origin',
                'students.major',
                'students.degree',
                'students.start_year',
                'students.finish_year',
                'students.wechat_id',
                'students.phone',
                'students.emergency_phone',
                'students.email',
                'students.scholarship',
                'students.scholarship_type',
                'students.agency',
                'students.status',
                'universities.id as university_id', 
                'universities.university_name', 
                'cities.latitude',
                'cities.longitude',
                'cities.id as city_id',
                'cities.city',
                'regions.id as region_id',
                'regions.region'
                )
            ->where('students.passport', $students)            
            ->first();
            
            if (!$student) {
                $response = [
                    'status' => 'error',
                    'message' => 'Student not found'
                ];
                return response()->json($response, 404);
            }

            $response = [
                'status' => 'success',
                'message' => 'Student found',
                'student' => $student
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
    public function update(Request $request, $passport)
    {        
        try {
            $students = Students::where('passport', $passport)->first();            

            if (!$students) {
                $response = [
                    'status' => 'error',
                    'message' => 'Student not found'
                ];
                return response()->json($response, 404);
            }            
            // $students->passport = $request->passport;
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
            $students->status = 'active';
            $students->created_at = date('Y-m-d H:i:s');
            $students->updated_at = date('Y-m-d H:i:s');
            $students->save();

            $response = [
                'status' => 'success',
                'message' => 'Student updated successfully',
                'data' => $students
            ];

        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];

            return response()->json($response, 500);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        try {
            $students = Students::where('id', $id)->first();
            $students->delete();            
            $response = [
                'status' => 'success',
                'message' => 'Student deleted successfully'
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
}
