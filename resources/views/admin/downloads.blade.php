@extends('layouts::admin')
@section('title', 'Downloads — Umera Certificate Manager')
@section('page_title', 'Downloads')
@section('page_subtitle', 'Track certificate download activity and engagement')

@section('content')
@php
    $maxChartValue = !empty($chart) ? max(array_column($chart, 'value')) : 1;
    if ($maxChartValue == 0) $maxChartValue = 1; // Prevent division by zero
@endphp

<div class="space-y-6 animate-slide-up">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-umbera-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['certificates_issued']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Total Certificates</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-success-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                12.4%
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-info-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['total_downloads']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Total Downloads</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-success-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                28.7%
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['unique_downloads']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Unique Downloads</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-success-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                8.2%
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ $stats['download_rate'] }}%</div>
            <div class="text-xs font-medium text-neutral-500">Download Rate</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-success-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                3.1%
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-error-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-error-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['not_downloaded']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Not Downloaded</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-error-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                2.4%
            </div>
        </div>

        <div class="stat-card card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">3.1</div>
            <div class="text-xs font-medium text-neutral-500">Avg Downloads/Cert</div>
            <div class="mt-3 flex items-center gap-1 text-xs text-success-600 font-medium">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                0.4
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Download Trend</h3>
                <p class="text-sm text-neutral-500">Daily certificate downloads over time</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ request()->fullUrlWithQuery(['period' => '7D']) }}" class="btn btn-sm {{ request('period') == '7D' ? 'btn-secondary' : 'btn-ghost' }}">7D</a>
                <a href="{{ request()->fullUrlWithQuery(['period' => '30D']) }}" class="btn btn-sm {{ request('period') == '30D' ? 'btn-secondary' : 'btn-ghost' }}">30D</a>
                <a href="{{ request()->fullUrlWithQuery(['period' => '90D']) }}" class="btn btn-sm {{ request('period') == '90D' ? 'btn-secondary' : 'btn-ghost' }}">90D</a>
                @if(request('period') || request('search'))
                    <a href="{{ route('admin.downloads') }}" class="btn btn-sm btn-ghost text-error-600">Reset</a>
                @endif
            </div>
        </div>

        <div class="flex items-end gap-3 sm:gap-6 h-56 px-2 border-b border-neutral-200 pb-2">
            @foreach($chart as $point)
                @php
                    $heightPct = ($point['value'] / $maxChartValue) * 100;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <div class="text-[10px] font-semibold text-neutral-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $point['value'] }}</div>
                    <div class="w-full rounded-t-md bg-gradient-to-t from-umbera-500 to-umbera-400 transition-all hover:from-umbera-600 hover:to-umbera-500 cursor-pointer" style="height: {{ $heightPct }}%; min-height: 8px;"></div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-3 sm:gap-6 mt-2 px-2">
            @foreach($chart as $point)
                <div class="flex-1 text-center text-[11px] font-medium text-neutral-500">{{ $point['label'] }}</div>
            @endforeach
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Recent Downloads</h3>
                <p class="text-sm text-neutral-500">Latest certificate download activity</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ request()->fullUrlWithQuery(array_merge(request()->query(), ['export' => 1])) }}" class="btn btn-sm btn-secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export CSV
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Certificate ID</th>
                        <th>Program</th>
                        <th>Date &amp; Time</th>
                        <th>Device</th>
                        <th>Download #</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $d)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-umbera-500 text-white flex items-center justify-center text-sm font-semibold">{{ strtoupper(substr($d->certificate->recipient_name ?? 'U', 0, 1)) }}</div>
                                <div>
                                    <div class="font-medium text-neutral-900">{{ $d->certificate->recipient_name ?? 'Unknown' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="font-mono text-xs text-neutral-600">{{ $d->certificate->certificate_number ?? '—' }}</td>
                        <td>{{ $d->certificate->program->name ?? 'UmeraBoost 5.0' }}</td>
                        <td>{{ $d->downloaded_at ? $d->downloaded_at->format('M d, Y H:i') : $d->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @php
                                $device = 'Desktop';
                                if (str_contains(strtolower($d->user_agent), 'mobi')) $device = 'Mobile';
                                elseif (str_contains(strtolower($d->user_agent), 'tablet') || str_contains(strtolower($d->user_agent), 'ipad')) $device = 'Tablet';
                            @endphp
                            <span class="badge badge-neutral">{{ $device }}</span>
                        </td>
                        <td><span class="badge badge-umbera">{{ $d->download_method ?? 'portal' }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-neutral-500">No downloads found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($downloads->hasPages())
        <div class="px-5 py-4 border-t border-neutral-100 flex items-center justify-between mt-5">
            {{ $downloads->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
