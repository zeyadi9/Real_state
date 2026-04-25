<?php

namespace App\Http\Controllers;

use App\Exports\OvertimeExport;
use App\Models\Overtime;
use App\Support\PayrollPeriod;
use App\Support\SubmissionWindow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuditLog;

class OvertimeController extends Controller
{
    public function overtime()
    {
        $userId = Auth::id();
        $period = PayrollPeriod::current();
        
        // Sum of hours in current cycle (accepted + pending)
        $monthUsage = Overtime::where('user_id', $userId)
            ->whereBetween('date', [$period['start']->toDateString(), $period['end']->toDateString()])
            ->where('status', '!=', 'refused')
            ->sum('total_hours');

        return view('overtime', [
            'dateBounds' => SubmissionWindow::bounds(),
            'otLimit' => 5,
            'otUsage' => round($monthUsage, 2),
        ]);
    }

    public function overtime_post(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'day' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i|after:from',
        ]);

        $from = \Carbon\Carbon::createFromFormat('H:i', $request->from);
        $to = \Carbon\Carbon::createFromFormat('H:i', $request->to);
        $total_hours = round($from->diffInMinutes($to) / 60, 2);

        $userId = Auth::id();
        $period = PayrollPeriod::fromRequest($request->date);

        // Check Monthly Overtime Limit (Max 5 hours)
        $monthUsage = Overtime::where('user_id', $userId)
            ->whereBetween('date', [$period['start']->toDateString(), $period['end']->toDateString()])
            ->where('status', '!=', 'refused')
            ->sum('total_hours');

        if (($monthUsage + $total_hours) > 5) {
            $remaining = 5 - $monthUsage;
            if ($remaining < 0) $remaining = 0;
            return redirect()->back()->with('alert_error', "⚠️ عذراً، لقد تخطيت الحد المسموح به للإضافي هذا الشهر (5 ساعات). المتبقي لك هو {$remaining} ساعة فقط.")->withInput();
        }

        SubmissionWindow::assertDateWithinAllowedWindow($request->date, 'Overtime date');

        $from = \Carbon\Carbon::createFromFormat('H:i', $request->from);
        $to = \Carbon\Carbon::createFromFormat('H:i', $request->to);
        $total_hours = round($from->diffInMinutes($to) / 60, 2);

        $name = (Auth::user()->email === 'guest@gamma.com' && $request->has('name')) 
            ? $request->name 
            : Auth::user()->name;

        $over = Overtime::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'date' => $request->date,
            'day' => $request->day,
            'total_hours' => $total_hours,
            'reason' => $request->reason,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        if ($over) {
            AuditLog::log(Auth::user()->name, 'Created', 'Overtime', $name, "Hours: {$total_hours}, Date: {$request->date}");
            return redirect()->route('home')->with('success', 'Overtime submitted successfully!');
        }

        return redirect()->route('Overtime')->withErrors(['error' => 'Overtime submission failed']);
    }

public function accept($id)
{
    Overtime::findOrFail($id)->update([
        'status'      => 'accepted',
        'actioned_by' => Auth::user()->name,
    ]);

    $ov = Overtime::find($id);
    AuditLog::log(Auth::user()->name, 'Accepted', 'Overtime', $ov->name, "Hours: {$ov->total_hours}, Date: {$ov->date}");

    return redirect()->route('view_Overtime')->with('success', 'Overtime accepted.');
}

public function refuse(Request $request, $id)
{
    $request->validate(['refuse_reason' => 'required|string|max:500']);
    Overtime::findOrFail($id)->update([
        'status'        => 'refused',
        'refuse_reason' => $request->refuse_reason,
        'actioned_by'   => Auth::user()->name,
    ]);

    $ov = Overtime::find($id);
    AuditLog::log(Auth::user()->name, 'Refused', 'Overtime', $ov->name, "Reason: {$request->refuse_reason}, Date: {$ov->date}");

    return redirect()->route('view_Overtime')->with('success', 'Overtime refused.');
}

    public function export(Request $request)
    {
        $period = PayrollPeriod::fromRequest($request->query('period_start'));
        $periodStart = $period['start'];
        $periodEnd = $period['end'];

        $overtimeQuery = Overtime::with('user')
            ->whereBetween('date', [
                $periodStart->toDateString(),
                $periodEnd->toDateString(),
            ]);

        $monthlyTotalsQuery = Overtime::with('user')
            ->whereBetween('date', [
                $periodStart->toDateString(),
                $periodEnd->toDateString(),
            ])
            ->where('status', 'accepted');

        if (Auth::user()->role !== 'super_admin') {
            $overtimeQuery->where('user_id', Auth::id());
            $monthlyTotalsQuery->where('user_id', Auth::id());
        }

        $overtime = $overtimeQuery
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        $monthlyTotals = $monthlyTotalsQuery
            ->selectRaw('name, SUM(total_hours) as total')
            ->groupBy('name')
            ->get();

        $filename = 'overtime_' . $periodStart->format('Y_m_d') . '_to_' . $periodEnd->format('Y_m_d') . '.xlsx';

        return Excel::download(
            new OvertimeExport($overtime, $monthlyTotals, $periodStart, $periodEnd),
            $filename
        );
    }
}
