<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status_map = [
                0 => 'InActive',
                1 => 'Active',
            ];

            try {
                $cacheKey = 'users_data';
                $data = Cache::remember($cacheKey, 600, function () {
                    $users = collect();

                    $this->models['user']::with('role')
                        ->orderBy('created_at', 'desc')
                        ->chunk(100, function ($chunk) use (&$users) {
                            foreach ($chunk as $user) {
                                $users->push($user);
                            }
                        });

                    return $users;
                });

                return $this->datatable['datatable']::of($data)
                    ->addColumn('role', function ($row) {
                        return $row->role->name ?? '';
                    })
                    ->addColumn('profile', function ($row) {
                        return '<img class="rounded" src="' . asset('public/user/' . ($row->profile ?? 'user.jpg')) . '" width="40" height="40">';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('user.edit', $row->id) . '" class="edit btn btn-warning btn-sm p-1"><i class="fas fa-edit"></i> </a>
                                <button class="delete btn btn-danger btn-sm p-1" data-id="' . $row->id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    })
                    ->addColumn('status', function ($row) use ($status_map) {
                        $status = $status_map[$row->status] ?? 'N/A';
                        $class = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';
                        return '<span class="' . $class . '">' . $status . '</span>';
                    })
                    ->rawColumns(['profile', 'status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }

        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $userId = $request->id;
        $validator = validator($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'role_id' => 'required',
            'phone' => 'required|min:10|max:10',
            'password' => 'required_if:id,null',
        ], [
            'phone.min' => 'Phone must be at least 10 characters long.',
            'phone.max' => 'Phone must not exceed 10 characters.',
            'password.required_if' => 'Password field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $data = $request->only('name', 'email', 'phone', 'role_id', 'status');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            $fileName = uniqid() . '.' . $request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->move(public_path('user'), $fileName);
            $data['profile'] = $fileName;
        }

        $userModel = $this->models['user']->findOrNew($userId);
        $userModel->fill($data)->save();

        return response()->json([
            'status' => true,
            'location' => route('user.index'),
            'message' => $userId ? 'User updated successfully!' : 'New User added to the table successfully!'
        ]);
    }

    public function edit($id)
    {
        $users = $this->models['user']->find($id);
        return view('user.create', compact('users'));
    }

    public function delete(Request $request)
    {
        $userId = $request->id;
        $user = $this->models['user']->find($userId);

        if (!$user) {
            return response()->json(['status' => false, 'message' => "User not found"]);
        }

        $profileImagePath = public_path('user/' . $user->profile);
        if (!empty($user->profile) && file_exists($profileImagePath)) {
            unlink($profileImagePath);
        }

        if ($user->delete()) {
            return response()->json(['status' => true, 'message' => "User Deleted Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Error Occurred, Please try again"]);
        }
    }
}
