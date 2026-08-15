<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollSalary;
use Illuminate\Http\Request;

class HrisPayrollController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $employeesQuery = Employee::query();

        if ($schoolId !== 'all') {
            $employeesQuery->where('school_id', $schoolId);
        }

        $employees = $employeesQuery->get();
        
        $payrollLogsQuery = PayrollSalary::with('employee.school');
        if ($schoolId !== 'all') {
            $payrollLogsQuery->whereHas('employee', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $payrollLogs = $payrollLogsQuery->latest()->take(15)->get();

        if ($payrollLogs->isEmpty() && $employees->isNotEmpty()) {
            foreach ($employees->take(6) as $emp) {
                $basic = ($emp->role_type == 'TEACHER') ? 3500000 : 2800000;
                $allowance = 750000;
                $transport = 450000;
                $bpjs = 120000;
                $tax = 50000;
                $net = ($basic + $allowance + $transport) - ($bpjs + $tax);

                PayrollSalary::create([
                    'employee_id' => $emp->id,
                    'month_year' => '2026-08',
                    'basic_salary' => $basic,
                    'position_allowance' => $allowance,
                    'transport_allowance' => $transport,
                    'bpjs_deduction' => $bpjs,
                    'tax_deduction' => $tax,
                    'cash_advance_deduction' => 0,
                    'net_salary' => $net,
                    'status' => 'PAID',
                    'payment_date' => now()->toDateString(),
                ]);
            }
            $payrollLogs = PayrollSalary::with('employee.school')->latest()->take(15)->get();
        }

        $totalPayrollMonth = $payrollLogs->sum('net_salary');

        return view('admin.hris.payroll', compact('employees', 'payrollLogs', 'totalPayrollMonth', 'schoolId'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month_year' => 'required|string',
            'basic_salary' => 'required|numeric',
        ]);

        $basic = $request->basic_salary;
        $allowance = $request->position_allowance ?? 750000;
        $transport = $request->transport_allowance ?? 450000;
        $bpjs = $request->bpjs_deduction ?? 120000;
        $tax = $request->tax_deduction ?? 50000;
        $advance = $request->cash_advance_deduction ?? 0;
        $net = ($basic + $allowance + $transport) - ($bpjs + $tax + $advance);

        PayrollSalary::create([
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

        return redirect()->back()->with('success', '✓ E-Slip Gaji Pegawai berhasil di-generate!');
    }
}
