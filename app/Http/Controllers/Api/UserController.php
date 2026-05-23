<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();
        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:super_admin,admin,user',
        ]);

        if ($request->role === 'super_admin' && !Auth::user()->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'لا تملك صلاحية إضافة سوبر أدمن!'
            ], 403);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        AuditLog::log(Auth::user()->name, 'إضافة موظف (موبايل)', 'الموظفين', 'الموظف: ' . $user->name . ' (' . $user->role . ')');

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الموظف بنجاح ✅',
            'data' => $user
        ], 201);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكنك حذف حسابك الحالي!'
            ], 400);
        }

        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن للأدمن حذف السوبر أدمن!'
            ], 403);
        }

        AuditLog::log(Auth::user()->name, 'حذف موظف (موبايل)', 'الموظفين', 'الموظف: ' . $user->name);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الموظف بنجاح 🗑'
        ], 200);
    }
}
