<?php

namespace App\Http\Controllers\AdminSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::select('id', 'name', 'email', 'created_at')->latest()->get();
        $totalUsers = $users->count();
 
        return inertia('AdminSetting/Users/Index', compact('users', 'totalUsers'));

    }


      // ✅ Show create form
        public function create()
        {
            return inertia('AdminSetting/Users/Form', [
                'user' => null
            ]);
        }




    // ✅ Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

        // Show edit form
        public function edit($id)
        {
            $user = User::findOrFail($id);

            return inertia('AdminSetting/Users/Form', [
                'user' => $user
            ]);
        }

    // ✅ Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    // ✅ Delete user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}
