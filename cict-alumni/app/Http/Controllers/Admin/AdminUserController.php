<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index()
    {
        // Order by adminID ascending so numbering is correct
        $admins = Admin::orderBy('adminID', 'asc')->get();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        // Only superadmin can create new admins
        if (auth('admin')->user()->role !== 'superadmin') {
            return redirect()->route('admin.admins.index')
                             ->with('error', 'You need higher authority to add new admins.');
        }

        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        // Only superadmin can store new admins
        if (auth('admin')->user()->role !== 'superadmin') {
            return redirect()->route('admin.admins.index')
                             ->with('error', 'You need higher authority to add new admins.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:superadmin,staff',
        ]);

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.admins.index')
                         ->with('success', 'Admin account created successfully.');
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        // Staff cannot edit superadmin
        if (auth('admin')->user()->role !== 'superadmin' && $admin->role === 'superadmin') {
            return redirect()->route('admin.admins.index')
                             ->with('error', 'You need higher authority to edit this admin.');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Staff cannot edit superadmin
        if (auth('admin')->user()->role !== 'superadmin' && $admin->role === 'superadmin') {
            return redirect()->route('admin.admins.index')
                             ->with('error', 'You need higher authority to edit this admin.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email,' . $admin->adminID . ',adminID',
            'role'     => 'required|in:superadmin,staff',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
                         ->with('success', 'Admin account updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->role === 'superadmin') {
            return redirect()->back()
                             ->with('error', 'You cannot delete another superadmin.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
                         ->with('success', 'Admin account deleted successfully.');
    }
}
