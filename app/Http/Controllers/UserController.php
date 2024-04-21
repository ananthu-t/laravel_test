<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        $departments = Department::get();
        $designations = Designation::get();
        $users = User::with(['Designation','Department'])->get();
        return view('user',compact('departments','designations','users'));
    }

    public function store(Request $request){

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department_id' => [
                'required',
                Rule::exists('departments', 'id'),
            ],
            'designation_id' => [
                'required',
                Rule::exists('designations', 'id'),
            ],
            'phone' => 'required|string|max:9',
        ];
    
        $messages = [
            'department_id.exists' => 'The selected department does not exist.',
            'designation_id.exists' => 'The selected designation does not exist.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json(['status'=>0,'message'=>$validator->errors()->first()], 200);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password='000';
        $user->department_id = $request->department_id;
        $user->designation_id = $request->designation_id;
        $user->phone_number = $request->phone;
        $user->save();

        return response()->json(['status'=>1,'message' => 'User created successfully'], 200);
    }
}
