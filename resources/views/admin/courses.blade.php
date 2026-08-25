@extends('layouts::admin')
@section('title', 'Courses — Umera Certificate Manager')
@section('page_title', 'Courses')
@section('page_subtitle', 'Manage courses and track participant enrollment')

@section('content')


<div class="space-y-6 animate-slide-up">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-umbera-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ $stats['total_courses'] }}</div>
            <div class="text-xs font-medium text-neutral-500">Total Courses</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-success-600 mb-1">{{ $stats['active_courses'] }}</div>
            <div class="text-xs font-medium text-neutral-500">Active Courses</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-info-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-neutral-900 mb-1">{{ number_format($stats['participants']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Total Enrolled</div>
        </div>
        <div class="stat-card card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-warning-600 mb-1">{{ number_format($stats['certificates_issued']) }}</div>
            <div class="text-xs font-medium text-neutral-500">Certificates Issued</div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">All Courses</h3>
                <p class="text-sm text-neutral-500">Manage courses, eligibility rules, and templates</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Search courses..." class="input-field pl-9 text-sm py-2" style="width: 200px;" />
                </div>
                <select class="input-field text-sm py-2" style="width: auto;">
                    <option>All Programs</option>
                    <option>UmeraBoost 5.0</option>
                </select>
                <select class="input-field text-sm py-2" style="width: auto;">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Draft</option>
                    <option>Archived</option>
                </select>
                <button class="btn btn-sm btn-primary" onclick="openCreateModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Course
                </button>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.courses') }}" class="mb-4 flex flex-wrap gap-2">
            <input type="hidden" name="program_id" value="{{ request('program_id') }}">
            <input type="hidden" name="search" value="{{ request('search') }}">
        </form>

        <div class="overflow-x-auto -mx-6 -mb-6">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Program</th>
                        <th>Participants</th>
                        <th>Eligible</th>
                        <th>Certificates</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $c)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-lg bg-umbera-50 flex items-center justify-center font-serif font-bold text-umbera-500 text-sm shrink-0">
                                    {{ $c->slug }}
                                </div>
                                <div>
                                    <div class="font-semibold text-neutral-900">{{ $c->name }}</div>
                                    <div class="text-xs text-neutral-500 font-mono">Course Code: {{ $c->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-umbera">{{ $c->program->name ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="font-semibold text-neutral-900">{{ number_format($c->registrations_count) }}</div>
                            <div class="text-[11px] text-neutral-500">enrolled</div>
                        </td>
                        <td>
                            <div class="font-semibold text-success-600">—</div>
                            <div class="text-[11px] text-neutral-400">—</div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="font-semibold text-neutral-900">{{ number_format($c->certificates_count) }}</div>
                            </div>
                        </td>
                        <td>
                            @if($c->status === 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif($c->status === 'draft')
                                <span class="badge badge-warning">Draft</span>
                            @else
                                <span class="badge badge-neutral">Archived</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="inline-flex items-center gap-1">
                                <button class="btn btn-sm btn-ghost p-2" onclick="Umera.showToast('Viewing {{ $c->slug }}', 'info')" title="View">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="btn btn-sm btn-ghost p-2 text-blue-600 hover:text-blue-700" title="Edit course" onclick="openEditModal({{ $c->id }}, '{{ $c->program_id }}', '{{ addslashes($c->name) }}', '{{ $c->slug }}', '{{ $c->duration }}')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <form method="POST" action="/admin/courses/{{ $c->id }}" class="inline" onsubmit="return confirm('Delete this course?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-ghost p-2 text-red-600 hover:text-red-700" title="Delete course">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                                <a href="{{ route('admin.courses.export', $c->id) }}" class="btn btn-sm btn-ghost p-2" title="Export participants">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                </a>
                                <button class="btn btn-sm btn-ghost p-2 text-error-600 hover:bg-error-50" onclick="if(confirm('Archive this course?')) Umera.showToast('Course archived', 'warning')" title="Archive">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-neutral-500">No courses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 flex items-center justify-between">
            {{ $courses->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>

<!-- Create Course Modal -->
<div id="backdrop-create-course" class="modal-backdrop hidden" onclick="Umera.closeModal('create-course')"></div>
<div id="modal-create-course" class="modal-container hidden">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            <div class="flex items-start justify-between p-6 border-b border-neutral-200">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 font-serif">Create New Course</h2>
                    <p class="text-sm text-neutral-500 mt-1">Add a new course to a training program.</p>
                </div>
                <button type="button" class="btn btn-sm btn-ghost -mt-2 -mr-2" onclick="Umera.closeModal('create-course')" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Program</label>
                    <select name="program_id" required class="input-field w-full text-sm py-2">
                        <option value="">Select a Program</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Course Name</label>
                    <input type="text" name="name" required placeholder="e.g. Project Management (Beginner)" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Course Code / Slug</label>
                    <input type="text" name="slug" required placeholder="e.g. pm-beginner" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Duration (Optional)</label>
                    <input type="text" name="duration" placeholder="e.g. 4 weeks" class="input-field w-full text-sm py-2" />
                </div>
            </div>

            <div class="p-4 border-t border-neutral-100 bg-neutral-50 rounded-b-xl flex items-center justify-end gap-2">
                <button type="button" onclick="Umera.closeModal('create-course')" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Create Course</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Course Modal -->
<div id="backdrop-edit-course" class="modal-backdrop hidden" onclick="Umera.closeModal('edit-course')"></div>
<div id="modal-edit-course" class="modal-container hidden">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <form id="edit-course-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="flex items-start justify-between p-6 border-b border-neutral-200">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 font-serif">Edit Course</h2>
                    <p class="text-sm text-neutral-500 mt-1">Update course details.</p>
                </div>
                <button type="button" class="btn btn-sm btn-ghost -mt-2 -mr-2" onclick="Umera.closeModal('edit-course')" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Program</label>
                    <select id="edit-program-id" name="program_id" required class="input-field w-full text-sm py-2">
                        <option value="">Select a Program</option>
                        @foreach($programs as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Course Name</label>
                    <input id="edit-course-name" type="text" name="name" required placeholder="Course Name" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Course Code / Slug</label>
                    <input id="edit-course-slug" type="text" name="slug" required placeholder="Course Slug" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Duration (Optional)</label>
                    <input id="edit-course-duration" type="text" name="duration" placeholder="Duration" class="input-field w-full text-sm py-2" />
                </div>
            </div>

            <div class="p-4 border-t border-neutral-100 bg-neutral-50 rounded-b-xl flex items-center justify-end gap-2">
                <button type="button" onclick="Umera.closeModal('edit-course')" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        Umera.openModal('create-course');
    }

    function openEditModal(id, programId, name, slug, duration) {
        const form = document.getElementById('edit-course-form');
        form.action = `/admin/courses/${id}`;
        
        document.getElementById('edit-program-id').value = programId;
        document.getElementById('edit-course-name').value = name;
        document.getElementById('edit-course-slug').value = slug;
        document.getElementById('edit-course-duration').value = duration || '';
        
        Umera.openModal('edit-course');
    }
</script>
@endsection
