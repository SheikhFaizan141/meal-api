<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Not Valid Page
        $page = $request->query('page');
        if (!is_null($page)) {
            if (!is_numeric($page)) {
                return response()->json($data = [], $status = '404');
            }
        }
    
        // Filter using search meals
        $meal = Meal::latest()->filter(request(['q']))->paginate(8);
        // not good respose chage it to 200 and handle it on front end
        if ($meal->isEmpty()) {
            return response()->json($data = [], $status = '404');
        }


        return response()->json($meal);
        // return $meal;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal): JsonResponse
    {
        return response()->json($meal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
