@extends('layouts::admin')
@section('title', 'Verification — Umera Certificate Manager')
@section('page_title', 'Verification')
@section('page_subtitle', 'Monitor certificate verification attempts and results')

@section('content')
@php
    // $stats and $verifications are now passed from the controller
@endphp

<div class="space-y-6 animate-slide-up">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-umbera-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <span class="badge badge-info">All Time</span>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['total_verifications']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Total Attempts</div>
            <div class="mt-3 h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                <div class="h-full bg-umbera-500 rounded-full" style="width: 100%;"></div>
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <span class="badge badge-success">
                    {{ round(($stats['valid_verifications'] / $stats['total_verifications']) * 100, 1) }}%
                </span>
            </div>
            <div class="text-2xl font-bold text-success-600 mb-1">{{ number_format($stats['valid_verifications']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Valid Checks</div>
            <div class="mt-3 h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                <div class="h-full bg-success-500 rounded-full" style="width: {{ ($stats['valid_verifications'] / $stats['total_verifications']) * 100 }}%;"></div>
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-error-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-error-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <span class="badge badge-error">
                    {{ round(($stats['invalid_verifications'] / $stats['total_verifications']) * 100, 1) }}%
                </span>
            </div>
            <div class="text-2xl font-bold text-error-600 mb-1">{{ number_format($stats['invalid_verifications']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Invalid / Not Found</div>
            <div class="mt-3 h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                <div class="h-full bg-error-500 rounded-full" style="width: {{ ($stats['invalid_verifications'] / $stats['total_verifications']) * 100 }}%;"></div>
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <span class="badge badge-warning">
                    {{ round(($stats['revoked_checks'] / $stats['total_verifications']) * 100, 1) }}%
                </span>
            </div>
            <div class="text-2xl font-bold text-warning-600 mb-1">{{ number_format($stats['revoked_checks']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Revoked Checks</div>
            <div class="mt-3 h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                <div class="h-full bg-warning-500 rounded-full" style="width: {{ ($stats['revoked_checks'] / $stats['total_verifications']) * 100 }}%;"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card p-6 lg:col-span-2">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900">Recent Verifications</h3>
                    <p class="text-sm text-neutral-500">Latest certificate verification activity</p>
                </div>
                <div class="flex items-center gap-2">
                    <select class="input-field text-sm py-2" style="width: auto;">
                        <option>All Results</option>
                        <option>Valid</option>
                        <option>Invalid</option>
                        <option>Revoked</option>
                    </select>
                    <button class="btn btn-sm btn-secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Export
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Certificate ID</th>
                            <th>Result</th>
                            <th>Source</th>
                            <th>Verifier</th>
                            <th>Date &amp; Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($verifications as $v)
                        <tr>
                            <td class="font-mono text-xs">
                                <span class="font-medium text-neutral-800">{{ $v->certificate->certificate_number ?? '—' }}</span>
                            </td>
                            <td>
                                @if($v->status === 'Valid')
                                    <span class="badge badge-success">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Valid
                                    </span>
                                @elseif($v->status === 'Revoked')
                                    <span class="badge badge-warning">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        Revoked
                                    </span>
                                @else
                                    <span class="badge badge-error">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Not Found
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="inline-flex items-center gap-1.5 text-xs text-neutral-600">
                                    @if($v->source === 'QR Scan')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                                    @elseif($v->source === 'LinkedIn')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                    @elseif($v->source === 'WhatsApp')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                    @else
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    @endif
                                    {{ ucfirst($v->source) }}
                                </span>
                            <td>
                                @php
                                    $verifier = 'Public Portal';
                                    if (str_contains(strtolower($v->user_agent), 'mobi')) $verifier = 'Mobile Device';
                                    if (str_contains(strtolower($v->user_agent), 'linkedin')) $verifier = 'LinkedIn Bot';
                                @endphp
                                <span class="badge badge-neutral bg-neutral-100 text-neutral-600 border-none">{{ $verifier }}</span>
                            </td>
                            <td>{{ $v->verified_at ? $v->verified_at->format('M d, Y H:i') : $v->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-neutral-500">No verifications found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($verifications->hasPages())
            <div class="px-5 py-4 border-t border-neutral-100 flex items-center justify-between mt-5">
                {{ $verifications->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
        </div>

        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Verification Sources</h3>
                <div class="space-y-4">
                    @php
                        $sources = [
                            ['name' => 'Direct Link', 'count' => 2184, 'icon' => 'link', 'color' => 'umbera'],
                            ['name' => 'QR Scan', 'count' => 1247, 'icon' => 'qr', 'color' => 'info'],
                            ['name' => 'LinkedIn', 'count' => 498, 'icon' => 'linkedin', 'color' => 'success'],
                            ['name' => 'WhatsApp', 'count' => 156, 'icon' => 'whatsapp', 'color' => 'warning'],
                            ['name' => 'Other', 'count' => 67, 'icon' => 'dots', 'color' => 'neutral'],
                        ];
                        $totalSrc = array_sum(array_column($sources, 'count'));
                    @endphp
                    @foreach($sources as $s)
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-neutral-700">{{ $s['name'] }}</span>
                            <span class="text-xs text-neutral-500">{{ number_format($s['count']) }}</span>
                        </div>
                        <div class="h-2 bg-neutral-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-{{ $s['color'] }}-500" style="width: {{ ($s['count'] / $totalSrc) * 100 }}%;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card p-6 border-l-4 border-l-umbera-500">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-umbera-50 flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-neutral-900 mb-1">Security Notice</h4>
                        <p class="text-xs text-neutral-600 leading-relaxed mb-3">Invalid verification attempts have increased 18% this week. Consider rate-limiting to prevent abuse.</p>
                        <button class="btn btn-sm btn-outline" onclick="Umera.showToast('Security settings opened', 'info')">
                            Configure Limits
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
