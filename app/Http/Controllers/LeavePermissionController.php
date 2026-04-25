<?php
namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\LeavesExport;
use App\Exports\PermissionsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Support\SubmissionWindow;
use App\Models\AuditLog;
use App\Models\User;


class LeavePermissionController extends Controller
{


public function permission_index()
{
    return view('ezn', ['dateBounds' => \App\Support\SubmissionWindow::bounds()]);
}
    // ---- LEAVE ----
    public function leave_index()
    {
        $userId = Auth::id();
        $period = \App\Support\PayrollPeriod::current();
        
        // Monthly usage (accepted + pending)
        $monthUsage = Leave::where('user_id', $userId)
            ->whereBetween('date', [$period['start']->toDateString(), $period['end']->toDateString()])
            ->where('status', '!=', 'refused')
            ->sum('days_count');

        // Yearly usage (accepted + pending)
        $yearUsage = Leave::where('user_id', $userId)
            ->whereYear('date', now()->year)
            ->where('status', '!=', 'refused')
            ->sum('days_count');

        return view('agaza', [
            'dateBounds' => SubmissionWindow::bounds(),
            'monthLimit' => 2,
            'monthUsage' => $monthUsage,
            'yearLimit' => 14,
            'yearUsage' => $yearUsage,
        ]);
    }

    public function leave_post(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'day'        => 'required|string',
            'reason'     => 'required|string|max:1000',
            'substitute' => 'required|string|max:255',
            'days_count' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $requestDate = \Carbon\Carbon::parse($request->date);
        $period = \App\Support\PayrollPeriod::fromRequest($request->date);

        // 1. Check Monthly Limit (Max 2 days per cycle)
        $monthUsage = Leave::where('user_id', $userId)
            ->whereBetween('date', [$period['start']->toDateString(), $period['end']->toDateString()])
            ->where('status', '!=', 'refused')
            ->sum('days_count');

        if (($monthUsage + $request->days_count) > 2) {
            return redirect()->back()->with('alert_error', "⚠️ تخطيت الحد المسموح به خلال الشهر وهو يومين، يرجى الرجوع إلى المسؤول.")->withInput();
        }

        // 2. Check Yearly Limit (Max 14 days per year)
        $yearUsage = Leave::where('user_id', $userId)
            ->whereYear('date', $requestDate->year)
            ->where('status', '!=', 'refused')
            ->sum('days_count');

        if (($yearUsage + $request->days_count) > 14) {
            return redirect()->back()->with('alert_error', "⚠️ عذراً، رصيد إجازاتك السنوي (14 يوم) قد انتهى.")->withInput();
        }

        SubmissionWindow::assertDateWithinAllowedWindow($request->date, 'Leave date');

        $name = (Auth::user()->email === 'guest@gamma.com' && $request->has('name')) 
            ? $request->name 
            : Auth::user()->name;

        Leave::create([
            'user_id'    => Auth::id(),
            'name'       => $name,
            'date'       => $request->date,
            'day'        => $request->day,
            'reason'     => $request->reason,
            'substitute' => $request->substitute,
            'days_count' => $request->days_count,
        ]);

        AuditLog::log(Auth::user()->name, 'Created', 'Leave', $name, "Date: {$request->date}");

        return redirect()->route('home')->with('success', 'Leave submitted successfully!');
    }

public function leave_accept($id)
{
    Leave::findOrFail($id)->update([
        'status'      => 'accepted',
        'actioned_by' => Auth::user()->name,
    ]);
    
    $leave = Leave::find($id);
    AuditLog::log(Auth::user()->name, 'Accepted', 'Leave', $leave->name, "Date: {$leave->date}");

    return redirect()->route('view_leave')->with('success', 'Leave accepted.');
}

public function leave_refuse(Request $request, $id)
{
    $request->validate(['refuse_reason' => 'required|string|max:500']);
    Leave::findOrFail($id)->update([
        'status'        => 'refused',
        'refuse_reason' => $request->refuse_reason,
        'actioned_by'   => Auth::user()->name,
    ]);

    $leave = Leave::find($id);
    AuditLog::log(Auth::user()->name, 'Refused', 'Leave', $leave->name, "Date: {$leave->date}, Reason: {$request->refuse_reason}");
    
    return redirect()->route('view_leave')->with('success', 'Leave refused.');
}

public function view_leave(Request $request)
{
    $period = \App\Support\PayrollPeriod::fromRequest($request->query('period_start'));
    $periodStart        = $period['start'];
    $periodEnd          = $period['end'];
    $previousPeriodStart = $period['previous_start']->format('Y-m-d');
    $nextPeriodStart     = $period['next_start']->format('Y-m-d');
    $isCurrentPeriod    = $period['is_current'];
    $periodLabel        = $period['label'];
    $selectedPeriodStart = $periodStart->format('Y-m-d');

    $users = [];
    if (in_array(Auth::user()->role, ['admin', 'super_admin'])) {
        $users = User::orderBy('name')->get();
        $query = Leave::whereBetween('date', [$periodStart, $periodEnd]);
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        $leaves = $query->latest()->get();
    } else {
        $leaves = Leave::where('user_id', Auth::id())
            ->whereBetween('date', [$periodStart, $periodEnd])
            ->latest()->get();
    }

    return view('view_agaza', compact(
        'leaves', 'users', 'periodStart', 'periodEnd', 'periodLabel',
        'isCurrentPeriod', 'previousPeriodStart', 'nextPeriodStart', 'selectedPeriodStart'
    ));
}

public function view_permission(Request $request)
{
    $period = \App\Support\PayrollPeriod::fromRequest($request->query('period_start'));
    $periodStart        = $period['start'];
    $periodEnd          = $period['end'];
    $previousPeriodStart = $period['previous_start']->format('Y-m-d');
    $nextPeriodStart     = $period['next_start']->format('Y-m-d');
    $isCurrentPeriod    = $period['is_current'];
    $periodLabel        = $period['label'];
    $selectedPeriodStart = $periodStart->format('Y-m-d');

    $users = [];
    if (in_array(Auth::user()->role, ['admin', 'super_admin'])) {
        $users = User::orderBy('name')->get();
        $query = Permission::whereBetween('date', [$periodStart, $periodEnd]);
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        $permissions = $query->latest()->get();

        $monthlyTotalsQuery = Permission::whereBetween('date', [$periodStart, $periodEnd])
            ->where('status', 'accepted');
        if ($request->has('user_id') && $request->user_id) {
            $monthlyTotalsQuery->where('user_id', $request->user_id);
        }
        $monthlyTotals = $monthlyTotalsQuery
            ->selectRaw('name, COUNT(*) as total')
            ->groupBy('name')
            ->orderByDesc('total')
            ->get();
    } else {
        $permissions = Permission::where('user_id', Auth::id())
            ->whereBetween('date', [$periodStart, $periodEnd])
            ->latest()->get();
        $monthlyTotals = collect();
    }

    return view('view_ezn', compact(
        'permissions', 'users', 'monthlyTotals', 'periodStart', 'periodEnd', 'periodLabel',
        'isCurrentPeriod', 'previousPeriodStart', 'nextPeriodStart', 'selectedPeriodStart'
    ));
}

    public function permission_post(Request $request)
    {
        $request->validate([
            'date'            => 'required|date',
            'day'             => 'required|string',
            'reason'          => 'required|string|max:1000',
            'permission_type' => 'required|string|in:إذن تأخير,إذن انصراف باكر,إذن نسيان بصمة حضور,إذن نسيان بصمة انصراف',
            'from'            => 'nullable|date_format:H:i|required_if:permission_type,إذن تأخير,إذن انصراف باكر',
            'to'              => 'nullable|date_format:H:i|after:from|required_if:permission_type,إذن تأخير,إذن انصراف باكر',
        ]);

        SubmissionWindow::assertDateWithinAllowedWindow($request->date, 'Permission date');

        $name = (Auth::user()->email === 'guest@gamma.com' && $request->has('name')) 
            ? $request->name 
            : Auth::user()->name;

        Permission::create([
            'user_id'         => Auth::id(),
            'name'            => $name,
            'date'            => $request->date,
            'day'             => $request->day,
            'reason'          => $request->reason,
            'from'            => $request->from,
            'to'              => $request->to,
            'permission_type' => $request->permission_type,
        ]);

        AuditLog::log(Auth::user()->name, 'Created', 'Permission', $name, "Type: {$request->permission_type}, Date: {$request->date}");

        return redirect()->route('home')->with('success', 'Permission submitted successfully!');
    }

public function permission_accept($id)
{
    Permission::findOrFail($id)->update([
        'status'      => 'accepted',
        'actioned_by' => Auth::user()->name,
    ]);

    $p = Permission::find($id);
    AuditLog::log(Auth::user()->name, 'Accepted', 'Permission', $p->name, "Type: {$p->permission_type}, Date: {$p->date}");

    return redirect()->route('view_permission')->with('success', 'Permission accepted.');
}

public function permission_refuse(Request $request, $id)
{
    $request->validate(['refuse_reason' => 'required|string|max:500']);
    Permission::findOrFail($id)->update([
        'status'        => 'refused',
        'refuse_reason' => $request->refuse_reason,
        'actioned_by'   => Auth::user()->name,
    ]);

    $p = Permission::find($id);
    AuditLog::log(Auth::user()->name, 'Refused', 'Permission', $p->name, "Type: {$p->permission_type}, Date: {$p->date}, Reason: {$request->refuse_reason}");

    return redirect()->route('view_permission')->with('success', 'Permission refused.');
}





public function export_lev(Request $request)
{
    if (Auth::user()->role !== 'super_admin') abort(403);
    $leaves = Leave::whereYear('date', now()->year)->get();
    $filename = 'leaves_' . now()->format('Y') . '.xlsx';

    return Excel::download(
        new LeavesExport($leaves, now()->format('Y')),
        $filename
    );
}


public function export_per(Request $request)
{
    if (Auth::user()->role !== 'super_admin') abort(403);
    $periodStart = now()->startOfMonth();
    $periodEnd   = now()->endOfMonth();

    $permissions = Permission::whereBetween('date', [$periodStart, $periodEnd])->get();

    $monthlyTotals = Permission::whereBetween('date', [$periodStart, $periodEnd])
        ->where('status', 'accepted')
        ->selectRaw('name, COUNT(*) as total')
        ->groupBy('name')
        ->get();

    return Excel::download(
        new PermissionsExport($permissions, $monthlyTotals, $periodStart, $periodEnd),
        'permissions_' . $periodStart->format('M_Y') . '.xlsx'
    );
}
}