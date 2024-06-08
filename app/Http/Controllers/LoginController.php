<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_submit(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role_id == "1") {
                $dashboard = "dashboard";
                return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => route($dashboard)]);
            } else {
                return response()->json(['status' => false, 'msg' => "You are not authorized to access this dashboard."]);
            }
        } else {
            return response()->json(['status' => false, 'msg' => "Credentials not matched !"]);
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_submit(Request $request)
    {
        $rules = [
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'required|alpha|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{1,20}$/',
                'max:20'
            ],
            'confirm_password' => 'required|same:password|max:20',
            'phone' => 'required|numeric|unique:users,phone',
            'address' => 'required|max:200'
        ];

        $messages = [
            'phone.numeric' => 'Mobile number must be numeric.',
            'phone.unique' => 'The mobile number has already been taken.',
            'password.regex' => 'Password must contain at least one uppercase letter, ' .
                'one lowercase letter, and one special character, ' .
                'and be up to 20 characters long.',
            'confirm_password.same' => 'Password confirmation does not match the password.',
            'password.max' => 'Password may not be greater than 20 characters.',
            'confirm_password.max' => 'Password confirmation may not be greater than 20 characters.',
            'phone.max' => 'Mobile number may not be greater than 10 characters.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        }

        $data = $request->all();
        $data['role_id'] = 1;
        $register = $this->models['user']->create($data);

        if ($register) {
            return response()->json(['status' => true, 'msg' => "Registration successfully", 'location' => route('login')]);
        } else {
            return response()->json(['status' => false, 'msg' => "Registration failed"]);
        }
    }

    public function dashboard()
    {
        $user = $this->models['user']->count();
        $data = [
            'user' => $user,
        ];
        return view('dashboard', compact('data'));
    }

    public function profile()
    {
        $profile = $this->models['user']->where('id', auth()->id())->first();
        return view('profile', compact('profile'));
    }


    public function update_profile(Request $request)
    {
        $rules = [
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'required|alpha|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . auth()->id(),
            'phone' => 'required|numeric|max:9999999999|unique:users,phone,' . auth()->id(),
            'address' => 'required|max:200'
        ];
        
        $messages = [
            'phone.numeric' => 'Mobile number must be numeric.',
            'phone.unique' => 'The mobile number has already been taken.',
            'phone.max' => 'Mobile number may not be greater than 10 characters.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user = Auth::user();

        if ($request->hasFile('profile')) {
            if ($user->profile && File::exists(public_path('img') . '/' . $user->profile)) {
                File::delete(public_path('img') . '/' . $user->profile);
            }

            $fileName = uniqid() . '.' . $request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->move(public_path('img'), $fileName);
            $data['profile'] = $fileName;
        }

        if ($user->update($data)) {
            return response()->json([
                'status'  => 'true',
                'message' => 'Updated successfully',
                'location' => route('profile'),
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Update failed.']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
