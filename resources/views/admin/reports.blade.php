@extends('layouts::admin')
@section('title', 'Reports — Umera Certificate Manager')
@section('page_title', 'Reports')
@section('page_subtitle', 'Generate and export comprehensive reports')

@section('content')
@php
    // $stats passed from controller
@endphp

<div class="space-y-6 animate-slide-up">
    <div class="card p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <label class="text-[11px] font-semibold uppercase tracking-wider text-neutral-500 mb-1 block">From</label>
                    <div class="relative">
                        <input type="date" value="2026-09-01" class="input-field pl-9" style="padding-top: 0.6rem; padding-bottom: 0.6rem;" />
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" style="top: calc(50% + 6px);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                </div>
                <div class="relative">
                    <label class="text-[11px] font-semibold uppercase tracking-wider text-neutral-500 mb-1 block">To</label>
                    <div class="relative">
                        <input type="date" value="2026-10-15" class="input-field pl-9" style="padding-top: 0.6rem; padding-bottom: 0.6rem;" />
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" style="top: calc(50% + 6px);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ request()->fullUrlWithQuery(['period' => '7D']) }}" class="btn btn-sm {{ $period == '7D' ? 'btn-primary' : 'btn-ghost' }}">Last 7D</a>
                <a href="{{ request()->fullUrlWithQuery(['period' => '30D']) }}" class="btn btn-sm {{ $period == '30D' ? 'btn-primary' : 'btn-ghost' }}">Last 30D</a>
                <a href="{{ request()->fullUrlWithQuery(['period' => 'quarter']) }}" class="btn btn-sm {{ $period == 'quarter' ? 'btn-primary' : 'btn-ghost' }}">This Quarter</a>
                <a href="{{ request()->fullUrlWithQuery(['period' => 'all']) }}" class="btn btn-sm {{ $period == 'all' ? 'btn-primary' : 'btn-ghost' }}">All Time</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-neutral-50 border border-neutral-200 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-neutral-900 mb-1">{{ number_format($stats['total_participants']) }}</div>
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total Participants</div>
            <div class="mt-3 inline-flex items-center gap-1 text-xs text-success-600 font-semibold bg-success-50 px-2.5 py-1 rounded-full">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                +12.4% vs prev
            </div>
        </div>
        <div class="bg-neutral-50 border border-neutral-200 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-success-600 mb-1">{{ number_format($stats['certificates_issued']) }}</div>
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Certificates Issued</div>
            <div class="mt-3 inline-flex items-center gap-1 text-xs text-success-600 font-semibold bg-success-50 px-2.5 py-1 rounded-full">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                +8.7% vs prev
            </div>
        </div>
        <div class="bg-neutral-50 border border-neutral-200 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-umbera-500 mb-1">97.0%</div>
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Completion Rate</div>
            <div class="mt-3 inline-flex items-center gap-1 text-xs text-warning-600 font-semibold bg-warning-50 px-2.5 py-1 rounded-full">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                -0.3% vs prev
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card card-hover p-6 cursor-pointer group" onclick="Umera.showToast('Opening Program Report...', 'info')">
            <div class="w-12 h-12 rounded-xl bg-umbera-50 flex items-center justify-center mb-4 group-hover:bg-umbera-500 transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white transition-colors"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-1">Program Report</h3>
            <p class="text-sm text-neutral-500 mb-4">Program-level performance, enrollment trends, and completion metrics across all programs.</p>
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge badge-neutral">Enrollment</span>
                <span class="badge badge-neutral">Completion</span>
                <span class="badge badge-neutral">Cohort</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                <span class="text-xs text-neutral-500">{{ number_format($stats['certificates_issued']) }} issued</span>
                <span class="inline-flex items-center gap-1 text-sm font-medium text-success-600 group-hover:gap-2 transition-all">
                    Export CSV
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
            </div>
        </a>

        <a href="{{ route('admin.reports.export', ['type' => 'certificates']) }}" class="card card-hover p-6 cursor-pointer group block">
            <div class="w-12 h-12 rounded-xl bg-success-50 flex items-center justify-center mb-4 group-hover:bg-success-500 transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white transition-colors"><circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-1">Certificate Report</h3>
            <p class="text-sm text-neutral-500 mb-4">Export a complete CSV list of all issued certificates and participant data.</p>
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge badge-neutral">Issuance</span>
                <span class="badge badge-neutral">Downloads</span>
                <span class="badge badge-neutral">Verifications</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                <span class="text-xs text-neutral-500">{{ number_format($stats['certificates_issued']) }} issued</span>
                <span class="inline-flex items-center gap-1 text-sm font-medium text-umbera-500 group-hover:gap-2 transition-all">
                    Generate
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
            </div>
        </div>

        <div class="card card-hover p-6 cursor-pointer group" onclick="Umera.showToast('Opening Participant Report...', 'info')">
            <div class="w-12 h-12 rounded-xl bg-info-50 flex items-center justify-center mb-4 group-hover:bg-info-500 transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white transition-colors"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-1">Participant Report</h3>
            <p class="text-sm text-neutral-500 mb-4">Individual participant records, eligibility status, course performance, and engagement data.</p>
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge badge-neutral">Eligibility</span>
                <span class="badge badge-neutral">Performance</span>
                <span class="badge badge-neutral">Engagement</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                <span class="text-xs text-neutral-500">{{ number_format($stats['participants']) }} participants</span>
                <span class="inline-flex items-center gap-1 text-sm font-medium text-umbera-500 group-hover:gap-2 transition-all">
                    Generate
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Export Reports</h3>
                <p class="text-sm text-neutral-500">Download reports in your preferred format</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <label class="text-[11px] font-semibold uppercase tracking-wider text-neutral-500">Format:</label>
                <select class="input-field text-sm py-2" style="width: auto;">
                    <option>All Data</option>
                    <option>Summary Only</option>
                    <option>Detailed Records</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <label class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl cursor-pointer hover:border-umbera-500 hover:bg-umbera-50 transition-all has-[:checked]:border-umbera-500 has-[:checked]:bg-umbera-50">
                <input type="checkbox" checked class="w-4 h-4 accent-[var(--color-umbera-500)]" />
                <div>
                    <div class="font-semibold text-sm text-neutral-900">Program Report</div>
                    <div class="text-xs text-neutral-500">1.2 MB estimate</div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl cursor-pointer hover:border-umbera-500 hover:bg-umbera-50 transition-all has-[:checked]:border-umbera-500 has-[:checked]:bg-umbera-50">
                <input type="checkbox" checked class="w-4 h-4 accent-[var(--color-umbera-500)]" />
                <div>
                    <div class="font-semibold text-sm text-neutral-900">Certificate Report</div>
                    <div class="text-xs text-neutral-500">3.8 MB estimate</div>
                </div>
            </label>
            <label class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl cursor-pointer hover:border-umbera-500 hover:bg-umbera-50 transition-all has-[:checked]:border-umbera-500 has-[:checked]:bg-umbera-50">
                <input type="checkbox" class="w-4 h-4 accent-[var(--color-umbera-500)]" />
                <div>
                    <div class="font-semibold text-sm text-neutral-900">Participant Report</div>
                    <div class="text-xs text-neutral-500">5.4 MB estimate</div>
                </div>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-5 border-t border-neutral-100">
            <button class="btn btn-secondary" onclick="Umera.showToast('Schedule dialog opened', 'info')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Schedule Report
            </button>
            <button class="btn btn-outline" onclick="Umera.showToast('Exporting CSV...', 'info')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Export CSV
            </button>
            <button class="btn btn-outline" onclick="Umera.showToast('Exporting Excel...', 'info')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export Excel
            </button>
            <button class="btn btn-primary" onclick="Umera.showToast('Exporting PDF...', 'success')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </button>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Recent Exports</h3>
                <p class="text-sm text-neutral-500">Previously generated reports</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Type</th>
                        <th>Format</th>
                        <th>Period</th>
                        <th>Generated By</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-medium text-neutral-900">monthly_cert_report_oct.pdf</td>
                        <td><span class="badge badge-umbera">Certificate</span></td>
                        <td><span class="badge badge-neutral">PDF</span></td>
                        <td>Sep 01 – Oct 15, 2026</td>
                        <td>Admin</td>
                        <td>Oct 15, 2026 09:20</td>
                        <td><button class="btn btn-sm btn-ghost" onclick="Umera.showToast('Downloading...', 'success')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="font-medium text-neutral-900">program_performance_q4.csv</td>
                        <td><span class="badge badge-umbera">Program</span></td>
                        <td><span class="badge badge-neutral">CSV</span></td>
                        <td>Oct 01 – Oct 15, 2026</td>
                        <td>Admin</td>
                        <td>Oct 12, 2026 15:45</td>
                        <td><button class="btn btn-sm btn-ghost" onclick="Umera.showToast('Downloading...', 'success')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button></td>
                    </tr>
                    <tr>
                        <td class="font-medium text-neutral-900">participants_eligibility.xlsx</td>
                        <td><span class="badge badge-umbera">Participant</span></td>
                        <td><span class="badge badge-neutral">Excel</span></td>
                        <td>All Time</td>
                        <td>Admin</td>
                        <td>Oct 08, 2026 11:10</td>
                        <td><button class="btn btn-sm btn-ghost" onclick="Umera.showToast('Downloading...', 'success')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
