<?php

namespace App\Http\Controllers;

use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $regions = Regions::leftJoin('cities', 'regions.id', '=', 'cities.region_id')
            ->leftJoin('universities', 'cities.id', '=', 'universities.city_id')
            ->leftJoin('students', 'universities.id', '=', 'students.university_id')                        
            ->select('regions.id', 'regions.region', 'regions.created_at', 'regions.updated_at', 
                DB::raw('count(distinct students.id) as students_count'),
                DB::raw('count(distinct cities.id) as cities_count'), 
                DB::raw('count(distinct universities.id) as universities_count'))
            ->groupBy('regions.id')
            ->get();

        $response = [
            'regions' => $regions
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
