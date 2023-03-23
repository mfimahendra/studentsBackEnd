<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = Cities::leftJoin('universities', 'universities.city_id', '=', 'cities.id')
            ->leftJoin('students', 'students.university_id', '=', 'universities.id')
            ->leftJoin('regions', 'cities.region_id', '=', 'regions.id')
            ->select(
                'cities.id',
                'cities.city',
                'cities.latitude',
                'cities.longitude',
                'regions.region',
                DB::raw('COUNT(DISTINCT universities.id) AS universities_count'),
                DB::raw('COUNT(DISTINCT students.passport) AS students_count')
            )
            ->groupBy('cities.id','cities.city', 'cities.latitude', 'cities.longitude', 'regions.region')
            ->get();

        $response = [
            'cities' => $cities
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
        // dd($request->all());

        try {

            if (Cities::where('city', $request->city)->exists()) {
                $response = [
                    'status' => 'error',
                    'message' => 'City already exists'
                ];

                return response()->json($response, 500);
            }

            $city_name = strtoupper($request->city);

            $city = new Cities();
            $city->city = $city_name;
            $city->latitude = $request->latitude;
            $city->longitude = $request->longitude;
            $city->region_id = $request->region_id;
            $city->save();

        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];

            return response()->json($response, 500);
        }

        $response = [
            'status' => 'success',
            'city' => $city
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($city)
    {        
        try {
            $city = Cities::where('city', $city)->first();

            if (!$city) {
                $response = [
                    'status' => 'error',
                    'message' => 'City not found'
                ];

                return response()->json($response, 404);
            }
            

        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];

            return response()->json($response, 500);
        }

        $response = [
            'status' => 'success',
            'city' => $city
        ];

        return response()->json($response, 200);
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
            $city = Cities::find($id);
            $city->city = $request->city;
            $city->latitude = $request->latitude;
            $city->longitude = $request->longitude;
            $city->region_id = $request->region_id;
            $city->save();

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
            if (!Cities::find($id)) {
                $response = [
                    'status' => 'error',
                    'message' => 'City not found'
                ];

                return response()->json($response, 404);
            }

            $city = Cities::find($id);
            $city->delete();

            $response = [
                'status' => 'success',
                'message' => 'City deleted successfully'
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
