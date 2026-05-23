<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:super_admin,admin,user',
        ]);

        // منع الأدمن من إضافة سوبر أدمن
        if ($request->role === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with('alert_error', 'لا تملك صلاحية إضافة سوبر أدمن!');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        AuditLog::log(auth()->user()->name, 'إضافة موظف', 'الموظفين', 'الموظف: ' . $user->name . ' (' . $user->role . ')');

        return redirect()->back()->with('success', 'تم إضافة الموظف بنجاح ✅');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        AuditLog::log(auth()->user()->name, 'إعادة ضبط كلمة سر', 'الموظفين', 'الموظف: ' . $user->name);

        return redirect()->back()->with('success', 'تم إعادة ضبط كلمة السر للموظف: ' . $user->name . ' ✅');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // منع الحذف الذاتي
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('alert_error', 'لا يمكنك حذف حسابك الحالي!');
        }

        // منع الأدمن من حذف السوبر أدمن
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with('alert_error', 'لا يمكن للأدمن حذف السوبر أدمن!');
        }

        AuditLog::log(auth()->user()->name, 'حذف موظف', 'الموظفين', 'الموظف: ' . $user->name);

        $user->delete();
        return redirect()->back()->with('success', 'تم حذف الموظف بنجاح 🗑');
    }
}
