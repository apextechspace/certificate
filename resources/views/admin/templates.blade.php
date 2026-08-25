@extends('layouts::admin')

@section('page_title', 'Templates')
@section('page_subtitle', 'Configure certificate template designs')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-3 space-y-6">
            <div class="card overflow-hidden animate-slide-up">
                <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-neutral-900">Template Preview</h3>
                        <p class="text-xs text-neutral-500 mt-0.5">Live preview of the active certificate design with dynamic field overlay</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge badge-success">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>
                            Live Preview
                        </span>
                    </div>
                </div>
                <div class="p-6 bg-neutral-50">
                    <div class="aspect-[1/1.414] max-w-3xl mx-auto rounded-lg shadow-elevated overflow-hidden bg-white animate-scale-in cert-template-container">
                        <img
                            src="{{ url('/api/certificate/UMB5-GAI-2026-000001/render') }}"
                            alt="UmeraBoost 5.0 Certificate Template"
                            class="w-full h-full object-cover"
                            draggable="false"
                        />
                    </div>
                    <div class="mt-5 flex flex-wrap items-center justify-center gap-3 text-[11px]">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-umbera-50 border border-umbera-100">
                            <span class="w-2 h-2 rounded-full bg-umbera-500 animate-pulse"></span>
                            <span class="font-semibold text-umbera-700">Name Field</span>
                            <span class="text-umbera-500 font-mono">Overlay @ {{ $mock['certificate_template']['overlay']['name']['top_percent'] }}%</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-neutral-100 border border-neutral-200">
                            <span class="w-2 h-2 rounded-full bg-neutral-600 animate-pulse"></span>
                            <span class="font-semibold text-neutral-700">Course Field</span>
                            <span class="text-neutral-500 font-mono">Overlay @ {{ $mock['certificate_template']['overlay']['course']['top_percent'] }}%</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-success-50 border border-success-100">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-600)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <span class="font-semibold text-success-700">Artwork Locked</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-5 border-l-4 animate-slide-up" style="border-left-color: #8B0000;">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center" style="background-color: #fef2f2; color: #8B0000;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><circle cx="12" cy="16" r="1"/><path d="M12 17v1"/></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-neutral-900">Locked Artwork Notice</h4>
                        <p class="mt-1 text-sm text-neutral-600 leading-relaxed">
                            The certificate artwork, logos, decorative borders, and official seals are managed and locked by Umera Business School's branding office. Template editors may customize <strong>text layouts, font sizes, and dynamic data fields</strong> only. To request artwork changes, contact the branding team.
                        </p>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="badge badge-umbera">Locked: Logo</span>
                            <span class="badge badge-umbera">Locked: Seals</span>
                            <span class="badge badge-umbera">Locked: Borders</span>
                            <span class="badge badge-neutral">Editable: Text Fields</span>
                            <span class="badge badge-neutral">Editable: Layout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between animate-slide-up">
                <div>
                    <h3 class="font-semibold text-neutral-900">All Templates</h3>
                    <p class="text-xs text-neutral-500 mt-0.5">Manage certificate templates</p>
                </div>
                <button class="btn btn-outline btn-sm" onclick="Umera.showToast('Template upload coming soon', 'info')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    New Template
                </button>
            </div>

            <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.05s">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Template</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $t)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg shrink-0 border border-neutral-200 bg-gradient-to-br from-neutral-50 to-umbera-50 flex items-center justify-center">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                                        </div>
                                        <span class="font-medium text-neutral-800 text-sm">{{ $t->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-neutral text-xs">UmeraBoost 5.0</span>
                                </td>
                                <td>
                                    @if($t->is_active ?? true)
                                        <span class="badge badge-success">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-neutral">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-neutral-500 text-sm">{{ optional($t->created_at)->format('M d, Y') ?? 'N/A' }}</td>
                                <td>
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="btn btn-sm btn-ghost p-2" title="Preview" onclick="Umera.showToast('Previewing template', 'info')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button class="btn btn-sm btn-ghost p-2" title="Edit text fields" onclick="Umera.showToast('Opening editor', 'info')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        <button class="btn btn-sm btn-ghost p-2" title="Duplicate" onclick="Umera.showToast('Template duplicated', 'success')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        </button>
                                        <button class="btn btn-sm btn-ghost p-2" title="Settings" onclick="Umera.showToast('Template settings', 'info')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-neutral-500">No templates found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
