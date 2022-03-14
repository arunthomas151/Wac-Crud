<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Mail\EmployeeMailAlert;
use App\Models\Designation;
use App\Models\Employee;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $designations = Designation::all();
        return view('layouts.dashboard', compact('designations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::all();
        return view('employee.add_employee', compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        $employee = new Employee;
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->designation = $request->input('designation');
        if ($request->hasfile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . $request->input('name') . '.' . $extension;
            $file->move('uploads/employees/', $fileName);
            $employee->profile_image = $fileName;
        }
        $created = $employee->save();

        $employee->password = Str::random(10);
        Mail::to($employee->email)->send(new EmployeeMailAlert($employee));




        if ($created) {
            return response()->json(['message' => 'Employee Added Successfully', 'status' => 201]);

        } else {
            return response()->json(['message' => $request, 'status' => 202]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * created by adarshepep@gmail.com on 14/03/2022
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee = Employee::find($request->id);
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->designation = $request->input('designation');
        if ($request->hasfile('profile_image')) {
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . $request->input('name') . '.' . $extension;
            $file->move('uploads/employees/', $fileName);
            $employee->profile_image = $fileName;
        }


        if ($employee->save()) {
            return response()->json(['message' => 'Employee Updated Successfully', 'status' => 201]);

        } else {
            return response()->json(['message' => $request, 'status' => 202]);
        }

    }

    /**
     * created by adarshepep@gmail.com on 14/03/2022
     * Remove the specified resource from storage.
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $employee = Employee::find($request->id);
        if($employee){
            File::delete(public_path("uploads/employees/".$employee->profile_image));
            $employee->delete();
        }
        return response()->json(['message' => 'Employee has been deleted successfully.', 'status' => 201]);

    }

    /**
     * created by adarshepep@gmail.com on 14/03/2022
     * Provide all employee details to list.
     *@param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function employeeTableAjax()
    {
        $employees = Employee::get();
        $object = [];
        foreach ($employees as $employee) {
            array_push($object, [
                "id" => $employee->id,
                "name" => $employee->name,
                "email" => $employee->email,
                "profile_image" => $employee->profile_image,
                "designation" => Designation::where('id', $employee->designation)->pluck('name')[0],
            ]);
        }
        return DataTables::of($object)
            ->make(true);

    }

    /**
     * created by adarshepep@gmail.com on 14/03/2022
     * Provide specific employee details to edit.
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function employeeDetails(Request $request)
    {
        return Employee::find($request->id);
    }

}
