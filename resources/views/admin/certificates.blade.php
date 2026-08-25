@extends('layouts::admin')

@section('page_title', 'Certificates')
@section('page_subtitle', 'Manage and track all issued certificates')

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="stat-card card-hover animate-slide-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Issued</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['issued']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-success-50 text-success-600 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.05s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Pending</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-warning-50 text-warning-600 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Revoked</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['revoked']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-error-50 text-error-600 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.15s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-umbera-50 text-umbera-500 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters + Table --}}
    <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-5 py-4 border-b border-neutral-100">
            <form method="GET" action="{{ route('admin.certificates') }}" class="flex flex-wrap items-center gap-3 w-full">
                <div class="relative max-w-md flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 pointer-events-none">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search certificate ID, participant..." class="input-field pl-10" />
                </div>
                <select name="status" class="input-field w-auto min-w-[130px] text-sm py-2">
                    <option value="">All Status</option>
                    <option value="issued"  {{ request('status') === 'issued'  ? 'selected' : '' }}>Issued</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.certificates') }}" class="btn btn-secondary btn-sm">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Certificate ID</th>
                        <th>Participant</th>
                        <th>Course</th>
                        <th>Issue Date</th>
                        <th>Status</th>
                        <th>Downloads</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($certificates as $cert)
                    <tr>
                        <td>
                            <span class="font-mono text-sm font-medium text-neutral-700">{{ $cert->certificate_number }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-umbera-500 text-white flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($cert->recipient_name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-neutral-800">{{ $cert->recipient_name }}</span>
                            </div>
                        </td>
                        <td class="text-neutral-600 text-sm max-w-[180px] truncate">{{ $cert->course_name }}</td>
                        <td class="text-neutral-600 text-sm">{{ $cert->issued_at?->format('M d, Y') ?? '—' }}</td>
                        <td>
                            @if ($cert->status === 'issued')
                                <span class="badge badge-success">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Issued
                                </span>
                            @elseif ($cert->status === 'revoked')
                                <span class="badge badge-error">Revoked</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-sm font-medium text-neutral-700">{{ $cert->downloads->count() }}</span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ url('/certificate/' . $cert->certificate_number) }}" target="_blank"
                                   class="btn btn-sm btn-ghost p-2" title="View public page">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @if ($cert->status === 'issued')
                                    <form method="POST" action="{{ route('admin.certificates.revoke', $cert->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to revoke this certificate? This action cannot be undone.')">
                                        @csrf
                                        <button class="btn btn-sm btn-ghost p-2 text-error-600 hover:bg-error-50" title="Revoke">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-neutral-400 py-10">No certificates found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-5 py-4 border-t border-neutral-100">
            <div class="text-sm text-neutral-500">
                Showing <span class="font-medium text-neutral-700">{{ $certificates->firstItem() ?? 0 }}</span>
                to <span class="font-medium text-neutral-700">{{ $certificates->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-neutral-700">{{ number_format($certificates->total()) }}</span> certificates
            </div>
            <div>{{ $certificates->links() }}</div>
        </div>
    </div>
</div>
@endsection
