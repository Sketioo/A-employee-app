<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
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
        try {
            $filters = $request->only(['name', 'division_id']);

            $employees = Employee::filter($filters)
                ->with('division')
                ->paginate(10);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan ditemukan',
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data karyawan.',
            ], 500);
        }
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
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['division_id'] = $validatedData['division'];
            unset($validatedData['division']);

            $employee = Employee::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil ditambahkan',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan karyawan.',
            ], 500);
        }
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
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $validatedData = $request->validated();

            if (isset($validatedData['division'])) {
                $validatedData['division_id'] = $validatedData['division'];
                unset($validatedData['division']);
            }

            $employee->update($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil diperbaharui',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbaharui data karyawan.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus karyawan',
            ], 500);
        }
    }

    public function getAllDivisions(Request $request)
    {
        try {
            $divisions = Division::filterByName($request->input('name'))->paginate(10);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Divisi ditemukan',
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data divisi.',
            ], 500);
        }
    }

}
