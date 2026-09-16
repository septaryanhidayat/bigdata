<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollSalary;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class HrisPayrollController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $employeesQuery = Employee::query();

        if ($schoolId) {
            $employeesQuery->where('school_id', $schoolId);
        }

        $employees = $employeesQuery->get();
        
        $payrollLogsQuery = PayrollSalary::with('employee.school');
        if ($schoolId) {
            $payrollLogsQuery->whereHas('employee', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $payrollLogs = $payrollLogsQuery->latest()->take(25)->get();

        $totalPayrollMonth = $payrollLogs->sum('net_salary');

        return view('admin.hris.payroll', compact('employees', 'payrollLogs', 'totalPayrollMonth', 'schoolId'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month_year' => 'required|string|regex:/^\d{4}-\d{2}$/',
            'basic_salary' => 'required|numeric|min:0',
            'position_allowance' => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'bpjs_deduction' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'cash_advance_deduction' => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $employee->school_id && $employee->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Pegawai ini bukan dari unit sekolah Anda.');
        }

        $basic = (float) $request->basic_salary;
        $allowance = (float) ($request->position_allowance ?? 0);
        $transport = (float) ($request->transport_allowance ?? 0);
        $bpjs = (float) ($request->bpjs_deduction ?? 0);
        $tax = (float) ($request->tax_deduction ?? 0);
        $advance = (float) ($request->cash_advance_deduction ?? 0);
        $net = max(0, ($basic + $allowance + $transport) - ($bpjs + $tax + $advance));

        $payroll = PayrollSalary::create([
            'employee_id' => $request->employee_id,
            'month_year' => $request->month_year,
            'basic_salary' => $basic,
            'position_allowance' => $allowance,
            'transport_allowance' => $transport,
            'bpjs_deduction' => $bpjs,
            'tax_deduction' => $tax,
            'cash_advance_deduction' => $advance,
            'net_salary' => $net,
            'status' => 'PAID',
            'payment_date' => now()->toDateString(),
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'GENERATE SLIP GAJI',
                'model_type' => 'PayrollSalary',
                'model_id' => $payroll->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', "✓ E-Slip Gaji Pegawai {$employee->full_name} untuk periode {$request->month_year} berhasil diterbitkan!");
    }

    public function destroy($id)
    {
        $payroll = PayrollSalary::with('employee')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $payroll->employee && $payroll->employee->school_id && $payroll->employee->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus slip gaji unit ini.');
        }

        $payroll->delete();
        return redirect()->back()->with('success', '✓ Data slip gaji berhasil dihapus.');
    }
}
