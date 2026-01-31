<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    // 1. List all Employees
    public function index()
    {
        return Inertia::render('Employees/Index', [
            // Don't show the logged-in user (optional), or show everyone
            'employees' => User::latest()->get()
        ]);
    }

    // 2. Create a New Employee
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // If you have roles setup, you would do: $user->assignRole('staff');
        
        return redirect()->back()->with('success', 'Employee Created Successfully!');
    }

    // 3. Delete Employee
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Employee Deleted!');
    }
}