<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $response = array();
        $response['users'] = User::paginate(10);
        return view('backend.users.index', $response);
    }

    public function create()
    {
        $response = array();
        return view('backend.users.create', $response);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:6|max:50'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()) {
            return redirect()->back()->with(['successMessage'=>'New user created successfully.']);
        } else {
            return redirect()->back()->with(['errorMessage'=>'Error in user creation.']);
        }
    }

    public function edit($id)
    {
        $response = array();
        $user = User::where('id', $id)->first();
        if ($user) {
            $response['user'] = $user;
            return view('backend.users.edit', $response);
        } else {
            return redirect()->back()->with(['errorMessage'=>'User not exists']);
        }
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:6|max:50'
        ]);

        $user = User::where('id', $request->id)->first();

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if($user->save()) {
                return redirect()->back()->with(['successMessage'=>'User updated successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in User updation.']);
            }

        } else {
            return redirect()->back()->with(['errorMessage'=>'User not exists']);
        }

    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            if($user->delete()) {
                return redirect()->back()->with(['successMessage'=>'User deleted successfully.']);
            } else {
                return redirect()->back()->with(['errorMessage'=>'Error in user deletion.']);
            }
        } else {
            return redirect()->back()->with(['errorMessage'=>'User not exists']);
        }
    }
}

