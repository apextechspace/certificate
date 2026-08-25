@extends('layouts::admin')
@section('title', 'Activity Logs — Umera Certificate Manager')
@section('page_title', 'Activity Logs')
@section('page_subtitle', 'Audit trail of all system and admin actions')

@section('content')
@php
    // $logs passed from controller
@endphp

<div class="space-y-6 animate-slide-up">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">14,827</div>
            <div class="text-xs font-medium text-neutral-500">Total Events</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-success-600 mb-1">12,943</div>
            <div class="text-xs font-medium text-neutral-500">Success Actions</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-error-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-error-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-error-600 mb-1">342</div>
            <div class="text-xs font-medium text-neutral-500">Failed Actions</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-info-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-info-600 mb-1">8</div>
            <div class="text-xs font-medium text-neutral-500">Admin Users</div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex flex-col lg:flex-row gap-3 mb-6">
            <div class="flex-1 relative">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Search actions, users, targets..." class="input-field pl-10" />
            </div>
            <div class="flex flex-wrap gap-2">
                <select class="input-field" style="width: auto; padding-top: 0.6rem; padding-bottom: 0.6rem;">
                    <option>All Status</option>
                    <option>Success</option>
                    <option>Error</option>
                    <option>Warning</option>
                    <option>Info</option>
                </select>
                <select class="input-field" style="width: auto; padding-top: 0.6rem; padding-bottom: 0.6rem;">
                    <option>All Actions</option>
                    <option>Certificate</option>
                    <option>Admin</option>
                    <option>Import</option>
                    <option>User</option>
                </select>
                <div class="flex bg-neutral-100 p-1 rounded-lg">
                    <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="px-3 py-1.5 text-xs font-medium rounded-md {{ !request('type') ? 'bg-white text-neutral-800 shadow-sm' : 'text-neutral-500 hover:text-neutral-700' }}">All</a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'admin']) }}" class="px-3 py-1.5 text-xs font-medium rounded-md {{ request('type') == 'admin' ? 'bg-white text-neutral-800 shadow-sm' : 'text-neutral-500 hover:text-neutral-700' }}">Admin</a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'system']) }}" class="px-3 py-1.5 text-xs font-medium rounded-md {{ request('type') == 'system' ? 'bg-white text-neutral-800 shadow-sm' : 'text-neutral-500 hover:text-neutral-700' }}">System</a>
                </div>
                @if(request('type') || request('search'))
                <a href="{{ route('admin.activity-logs') }}" class="btn btn-secondary">
                    Reset
                </a>
                @endif
                <a href="{{ request()->fullUrlWithQuery(array_merge(request()->query(), ['export' => 1])) }}" class="btn btn-primary" onclick="event.preventDefault(); window.location='{{ route('admin.activity-logs.export', request()->query()) }}'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                </a>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 mb-5 pb-5 border-b border-neutral-100">
            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-success-50 text-success-600 hover:bg-success-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-success-500"></span>
                Success (12,943)
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-error-50 text-error-600 hover:bg-error-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-error-500"></span>
                Error (342)
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-warning-50 text-warning-600 hover:bg-warning-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-warning-500"></span>
                Warning (891)
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-info-50 text-info-600 hover:bg-info-100 transition-colors">
                <span class="w-2 h-2 rounded-full bg-info-500"></span>
                Info (651)
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="overflow-x-auto -mx-6 -mb-6">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>User</th>
                        <th>Target</th>
                        <th>Date / Time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allActivity as $log)
                    <tr>
                        <td class="font-medium text-neutral-800">{{ $log['action'] }}</td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full {{ $log['user'] === 'Admin' ? 'bg-umbera-500 text-white' : ($log['user'] === 'Public Visitor' ? 'bg-neutral-200 text-neutral-600' : 'bg-info-100 text-info-600') }} flex items-center justify-center text-xs font-semibold">
                                    {{ substr($log['user'], 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-neutral-800">{{ $log['user'] }}</div>
                                    @if($log['user'] !== 'Admin' && $log['user'] !== 'Public Visitor')
                                        <div class="text-[11px] text-neutral-500">Participant</div>
                                    @elseif($log['user'] === 'Admin')
                                        <div class="text-[11px] text-umbera-500">Admin</div>
                                    @else
                                        <div class="text-[11px] text-neutral-500">Guest</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-neutral-600">{{ $log->description }}</td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                        <td>
                            @php
                                // We can infer status somewhat from action if we wanted, or just hardcode to success for now since most logs are info/success.
                                $status = match (strtolower(explode(' ', $log->action)[0])) {
                                    'login', 'create' => 'success',
                                    'delete', 'remove' => 'error',
                                    'update', 'edit' => 'warning',
                                    default => 'info',
                                };
                            @endphp
                            @if($status === 'success')
                                <span class="badge badge-success"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Success</span>
                            @elseif($status === 'error')
                                <span class="badge badge-error"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Error</span>
                            @elseif($status === 'warning')
                                <span class="badge badge-warning"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Warning</span>
                            @else
                                <span class="badge badge-info"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> Info</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-ghost p-1.5" onclick="Umera.showToast('Log details disabled', 'info')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-neutral-500">No activity logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100 flex items-center justify-between mt-5">
            {{ $logs->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
