<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'division_id']);

        $employees = Employee::filter($filters)
            ->with('division')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [
                'employees' => $employees->items(),
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'total_pages' => $employees->lastPage(),
                'total_items' => $employees->total(),
                'per_page' => $employees->perPage(),
            ],
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAllDivisions(Request $request)
    {
        $divisions = Division::filterByName($request->input('name'))->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Divisions retrieved successfully',
            'data' => [
                'divisions' => $divisions->items(),
            ],
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
                'last_page' => $divisions->lastPage(),
            ],
        ]);
    }
}
