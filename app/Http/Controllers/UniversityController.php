<?php

namespace App\Http\Controllers;

use App\Models\Universities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $cities = Cities::select('cities.id', 'cities.city', 'cities.latitude', 'cities.longitude', 'regions.region')
        // ->leftJoin('regions', 'cities.region_id', '=', 'regions.id')        
        // ->get();        

        $universities = Universities::
        leftJoin('cities', 'universities.city_id', '=', 'cities.id')
        ->leftJoin('regions', 'cities.region_id', '=', 'regions.id')        
        ->leftJoin('students', 'students.university_id', '=', 'universities.id')
        ->select(
            'universities.id', 
            'universities.university_name', 
            'universities.latitude',
            'universities.longitude',
            'cities.city',
            'regions.region',
            DB::raw('COUNT(DISTINCT students.passport) AS students_count')
            )
        ->groupBy('universities.id', 'universities.university_name', 'cities.city', 'regions.region')
        ->get();
        $response = [
            'stats' => 'success',
            'universities' => $universities
        ];

        return response()->json($response, 200);
    }

    public function indexCity($city)
    {
        $city = (int)$city;
        $universities = Universities::
        leftJoin('cities', 'universities.city_id', '=', 'cities.id')
        ->leftJoin('regions', 'cities.region_id', '=', 'regions.id')        
        ->leftJoin('students', 'students.university_id', '=', 'universities.id')
        ->select(
            'universities.id', 
            'universities.university_name', 
            'universities.latitude',
            'universities.longitude',
            'cities.city',
            'regions.region',            
            )
        ->where('cities.id', $city)
        ->groupBy('universities.id', 'universities.university_name', 'cities.city', 'regions.region')
        ->get();
        $response = [
            'stats' => 'success',
            'universities' => $universities
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $university_name = strtoupper($request->university_name);

        try {

            if(Universities::where('university_name', $university_name)->exists()) {
                $response = [
                    'status' => 'error',
                    'message' => 'University already exists'
                ];

                return response()->json($response, 500);
            }

            $university = new Universities();
            $university->university_name = $university_name;
            $university->city_id = $request->city_id;
            $university->save();

            $response = [
                'status' => 'success',
                'message' => 'University added successfully',
                'university' => $university

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($university_name)
    {
        try {
            $university = Universities::where('university_name', $university_name)->first();

            $response = [
                'status' => 'success',                
                'university' => $university
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $university = Universities::find($id);
            $university->university_name = $request->university_name;
            $university->city_id = $request->city_id;
            $university->save();

            $response = [
                'status' => 'success',
                'message' => 'University updated successfully',
                'university' => $university
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $university = Universities::find($id);
            $university->delete();

            $response = [
                'status' => 'success',
                'message' => 'University deleted successfully'
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
