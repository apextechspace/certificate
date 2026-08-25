@extends('layouts::admin')

@section('page_title', 'Programs')
@section('page_subtitle', 'Manage programs, cohorts, and associated courses')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="stat-card card-hover animate-slide-up">
            <div>
                <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Active Programs</p>
                <p class="mt-2 text-3xl font-bold font-serif text-umbera-500">{{ $stats['active_programs'] }}</p>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.05s">
            <div>
                <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total Courses</p>
                <p class="mt-2 text-3xl font-bold font-serif text-neutral-900">{{ $stats['total_courses'] }}</p>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.1s">
            <div>
                <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Enrolled</p>
                <p class="mt-2 text-3xl font-bold font-serif text-neutral-900">{{ number_format($stats['enrolled']) }}</p>
            </div>
        </div>
        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.15s">
            <div>
                <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Certificates</p>
                <p class="mt-2 text-3xl font-bold font-serif text-neutral-900">{{ number_format($stats['certificates']) }}</p>
            </div>
        </div>
    </div>

    <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-5 py-4 border-b border-neutral-100">
            <div>
                <h3 class="font-semibold text-neutral-900">Programs</h3>
                <p class="text-xs text-neutral-500 mt-0.5">All training programs managed on this platform</p>
            </div>
            <button class="btn btn-primary btn-sm" onclick="openCreateModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                New Program
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Code</th>
                        <th>Year</th>
                        <th>Courses</th>
                        <th>Participants</th>
                        <th>Certificates</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $p)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center font-serif font-bold text-white" style="background-color: #8B0000;">
                                    {{ substr($p->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-neutral-800">{{ $p->name }}</div>
                                    <div class="text-xs text-neutral-500">Umera Business School</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="font-mono text-sm font-medium text-neutral-700">{{ $p->slug }}</span>
                        </td>
                        <td class="text-neutral-600">{{ $p->created_at->format('Y') }}</td>
                        <td>
                            <div class="flex flex-wrap gap-1">
                                <span class="badge badge-neutral text-xs">{{ $p->courses_count }} Courses</span>
                            </div>
                        </td>
                        <td class="text-neutral-700 font-medium">{{ number_format($p->registrations_count) }}</td>
                        <td class="text-neutral-700 font-medium">{{ number_format($p->certificates_count) }}</td>
                        <td>
                            @if ($p->status === 'active')
                                <span class="badge badge-success">
                                    <span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="badge badge-neutral">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <button class="btn btn-sm btn-ghost p-2" title="View program" onclick="Umera.showToast('Viewing {{ $p->name }}', 'info')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button class="btn btn-sm btn-ghost p-2" title="Manage courses" onclick="window.location='{{ url('/admin/courses?program_id='.$p->id) }}'">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </button>
                                <button class="btn btn-sm btn-ghost p-2 text-blue-600 hover:text-blue-700" title="Edit program" onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ $p->status }}', '{{ $p->start_date }}', '{{ $p->end_date }}')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <form method="POST" action="/admin/programs/{{ $p->id }}" class="inline" onsubmit="return confirm('Delete this program?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-ghost p-2 text-red-600 hover:text-red-700" title="Delete program">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-neutral-500">No programs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Program Modal -->
<div id="backdrop-create-program" class="modal-backdrop hidden" onclick="Umera.closeModal('create-program')"></div>
<div id="modal-create-program" class="modal-container hidden">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <form method="POST" action="{{ route('admin.programs.store') }}">
            @csrf
            <div class="flex items-start justify-between p-6 border-b border-neutral-200">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 font-serif">Create New Program</h2>
                    <p class="text-sm text-neutral-500 mt-1">Add a new educational cohort or program.</p>
                </div>
                <button type="button" class="btn btn-sm btn-ghost -mt-2 -mr-2" onclick="Umera.closeModal('create-program')" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Program Name</label>
                    <input type="text" name="name" required placeholder="e.g. UmeraBoost 6.0" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Code / Slug</label>
                    <input type="text" name="slug" placeholder="e.g. umeraboost-6-0" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Status</label>
                    <select name="status" required class="input-field w-full text-sm py-2">
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Start Date</label>
                        <input type="date" name="start_date" class="input-field w-full text-sm py-2" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">End Date</label>
                        <input type="date" name="end_date" class="input-field w-full text-sm py-2" />
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-neutral-100 bg-neutral-50 rounded-b-xl flex items-center justify-end gap-2">
                <button type="button" onclick="Umera.closeModal('create-program')" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Create Program</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Program Modal -->
<div id="backdrop-edit-program" class="modal-backdrop hidden" onclick="Umera.closeModal('edit-program')"></div>
<div id="modal-edit-program" class="modal-container hidden">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <form id="edit-program-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="flex items-start justify-between p-6 border-b border-neutral-200">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 font-serif">Edit Program</h2>
                    <p class="text-sm text-neutral-500 mt-1">Update program details.</p>
                </div>
                <button type="button" class="btn btn-sm btn-ghost -mt-2 -mr-2" onclick="Umera.closeModal('edit-program')" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Program Name</label>
                    <input id="edit-program-name" type="text" name="name" required placeholder="Program Name" class="input-field w-full text-sm py-2" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Status</label>
                    <select id="edit-program-status" name="status" required class="input-field w-full text-sm py-2">
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Start Date</label>
                        <input id="edit-program-start-date" type="date" name="start_date" class="input-field w-full text-sm py-2" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">End Date</label>
                        <input id="edit-program-end-date" type="date" name="end_date" class="input-field w-full text-sm py-2" />
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-neutral-100 bg-neutral-50 rounded-b-xl flex items-center justify-end gap-2">
                <button type="button" onclick="Umera.closeModal('edit-program')" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        Umera.openModal('create-program');
    }

    function openEditModal(id, name, status, startDate, endDate) {
        const form = document.getElementById('edit-program-form');
        form.action = `/admin/programs/${id}`;
        
        document.getElementById('edit-program-name').value = name;
        document.getElementById('edit-program-status').value = status;
        
        // Format dates if available to YYYY-MM-DD
        if (startDate) {
            document.getElementById('edit-program-start-date').value = startDate.substring(0, 10);
        } else {
            document.getElementById('edit-program-start-date').value = '';
        }
        
        if (endDate) {
            document.getElementById('edit-program-end-date').value = endDate.substring(0, 10);
        } else {
            document.getElementById('edit-program-end-date').value = '';
        }
        
        Umera.openModal('edit-program');
    }
</script>
@endsection
