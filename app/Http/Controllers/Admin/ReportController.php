<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');

        $query = User::members();

        if (in_array($status, ['active', 'inactive', 'pending'])) {
            $query->where('membership_status', $status);
        }

        $members = $query->orderBy('name')->get();

        $summary = [
            'total'    => User::members()->count(),
            'active'   => User::members()->where('membership_status', 'active')->count(),
            'inactive' => User::members()->where('membership_status', 'inactive')->count(),
            'pending'  => User::members()->where('membership_status', 'pending')->count(),
        ];

        return view('admin.reports.index', compact('members', 'summary', 'status'));
    }
}