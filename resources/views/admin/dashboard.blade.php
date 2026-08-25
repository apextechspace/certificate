@extends('layouts::admin')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of certificate operations')

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.05s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Participants</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['participants']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-info-50 text-info-500 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Eligible</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['eligible']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-success-50 text-success-600 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.15s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Issued</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['certificates_issued']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-umbera-50 text-umbera-500 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.2s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Downloaded</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['downloaded']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-info-50 text-info-500 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.25s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Not Downloaded</p>
                    <p class="mt-2 text-2xl font-bold text-neutral-900 font-serif">{{ number_format($stats['not_downloaded']) }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-warning-50 text-warning-600 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.3s">
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
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Certificates --}}
        <div class="card p-6 animate-slide-up" style="animation-delay: 0.35s">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-semibold text-neutral-900">Recent Certificates</h3>
                    <p class="text-xs text-neutral-500 mt-0.5">Latest issued certificates</p>
                </div>
                <a href="{{ route('admin.certificates') }}" class="text-xs font-medium text-umbera-500 hover:text-umbera-600 transition-colors">View all</a>
            </div>
            <div class="space-y-3">
                @forelse ($recentCertificates as $cert)
                <div class="flex items-center gap-3 p-2 -mx-2 rounded-lg hover:bg-neutral-50 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-umbera-500 text-white flex items-center justify-center font-semibold text-sm shrink-0">
                        {{ strtoupper(substr($cert->recipient_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-800 truncate">{{ $cert->recipient_name }}</p>
                        <p class="text-xs text-neutral-500 truncate">{{ $cert->certificate_number }} · {{ $cert->course->name ?? $cert->course_name }}</p>
                    </div>
                    <div class="text-xs text-neutral-400 shrink-0">{{ $cert->issued_at?->diffForHumans() }}</div>
                </div>
                @empty
                <p class="text-sm text-neutral-400 text-center py-4">No certificates issued yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Programs Overview --}}
        <div class="card p-6 animate-slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-semibold text-neutral-900">Programs</h3>
                    <p class="text-xs text-neutral-500 mt-0.5">Active certificate programs</p>
                </div>
                <a href="{{ route('admin.programs') }}" class="text-xs font-medium text-umbera-500 hover:text-umbera-600 transition-colors">Manage</a>
            </div>
            <div class="space-y-3">
                @forelse ($programs as $prog)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-neutral-50 border border-neutral-100">
                    <div class="w-9 h-9 rounded-lg bg-umbera-100 text-umbera-600 flex items-center justify-center shrink-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-neutral-800 truncate">{{ $prog->name }}</p>
                        <p class="text-xs text-neutral-500">{{ $prog->courses_count }} courses · {{ $prog->registrations_count }} registrations</p>
                    </div>
                    <span class="badge {{ $prog->status === 'active' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($prog->status) }}</span>
                </div>
                @empty
                <p class="text-sm text-neutral-400 text-center py-4">No programs found.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="card p-6 animate-slide-up" style="animation-delay: 0.45s">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-semibold text-neutral-900">Recent Activity</h3>
                <p class="text-xs text-neutral-500 mt-0.5">Latest admin actions</p>
            </div>
            <a href="{{ route('admin.activity-logs') }}" class="text-xs font-medium text-umbera-500 hover:text-umbera-600 transition-colors">View all</a>
        </div>
        @forelse ($recentActivity as $item)
        <div class="flex gap-3 mb-3">
            <div class="w-8 h-8 rounded-full bg-umbera-50 text-umbera-500 shrink-0 flex items-center justify-center">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-neutral-800">{{ $item->action }}</p>
                <p class="text-xs text-neutral-500 truncate">{{ $item->description ?? $item->target_type }} · {{ $item->user?->name }}</p>
            </div>
            <div class="text-xs text-neutral-400 shrink-0">{{ $item->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <p class="text-sm text-neutral-400 text-center py-4">No activity recorded yet.</p>
        @endforelse
    </div>
</div>
@endsection
