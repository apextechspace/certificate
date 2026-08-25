@extends('layouts::admin')

@section('page_title', 'Eligibility')
@section('page_subtitle', 'Track and manage participant eligibility status')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card card-hover animate-slide-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total</p>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 font-serif">{{ number_format($stats['total']) }}</p>
                    <p class="mt-1 text-xs text-neutral-500">Participants assessed</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-info-50 text-info-500 flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.05s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Eligible</p>
                    <p class="mt-2 text-3xl font-bold font-serif text-success-600">{{ number_format($stats['eligible']) }}</p>
                    <p class="mt-1 text-xs text-neutral-500">{{ round(($stats['eligible'] / max(1, $stats['total'])) * 100, 1) }}% of total</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-success-50 text-success-600 flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Not Eligible</p>
                    <p class="mt-2 text-3xl font-bold font-serif text-error-600">{{ number_format($stats['not_eligible']) }}</p>
                    <p class="mt-1 text-xs text-neutral-500">{{ round(($stats['not_eligible'] / max(1, $stats['total'])) * 100, 1) }}% of total</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-error-50 text-error-600 flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card card-hover animate-slide-up" style="animation-delay: 0.15s">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Pending Review</p>
                    <p class="mt-2 text-3xl font-bold font-serif text-warning-600">{{ number_format($stats['pending']) }}</p>
                    <p class="mt-1 text-xs text-neutral-500">{{ round(($stats['pending'] / max(1, $stats['total'])) * 100, 1) }}% of total</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-warning-50 text-warning-600 flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-success-50 border border-success-200 text-success-700 flex items-start gap-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
                <p class="font-semibold">Success</p>
                <p class="text-sm mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-5 py-4 border-b border-neutral-100">
            <div>
                <h3 class="font-semibold text-neutral-900">Eligibility Details</h3>
                <p class="text-xs text-neutral-500 mt-0.5">Participant criteria breakdown</p>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('admin.eligibility.check') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Run Check
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Course</th>
                        <th>Registration</th>
                        <th>Attendance</th>
                        <th>Assessment</th>
                        <th>Completion</th>
                        <th>Eligibility</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $r)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-umbera-500 text-white flex items-center justify-center font-semibold text-sm shrink-0">
                                    {{ strtoupper(substr($r->participant->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-neutral-800">{{ $r->participant->name }}</span>
                            </div>
                        </td>
                        <td class="text-neutral-600">{{ $r->course->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $r->registration_status === 'enrolled' || $r->registration_status === 'completed' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($r->registration_status) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ ($r->eligibilityResult->attendance_status ?? '') === 'Present' ? 'badge-success' : 'badge-neutral' }}">{{ $r->eligibilityResult->attendance_status ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ ($r->eligibilityResult->assessment_status ?? '') === 'Passed' ? 'badge-success' : 'badge-neutral' }}">{{ $r->eligibilityResult->assessment_status ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ ($r->eligibilityResult->completion_status ?? '') === 'Completed' ? 'badge-success' : 'badge-neutral' }}">{{ $r->eligibilityResult->completion_status ?? '—' }}</span>
                        </td>
                        <td>
                            @if ($r->eligibilityResult)
                                @if ($r->eligibilityResult->eligible)
                                    <span class="badge badge-success">Eligible</span>
                                @else
                                    <span class="badge badge-error">Not Eligible</span>
                                @endif
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-ghost text-blue-600 hover:text-blue-700 p-2" 
                                onclick="openEditModal(
                                    {{ $r->id }},
                                    '{{ addslashes($r->participant->name) }}',
                                    '{{ $r->eligibilityResult->attendance_status ?? 'Absent' }}',
                                    '{{ $r->eligibilityResult->assessment_status ?? 'Pending' }}',
                                    '{{ $r->eligibilityResult->completion_status ?? 'Pending' }}',
                                    {{ ($r->eligibilityResult->manual_override ?? false) ? 1 : 0 }},
                                    {{ ($r->eligibilityResult->eligible ?? false) ? 1 : 0 }},
                                    '{{ addslashes($r->eligibilityResult->reason ?? '') }}'
                                )" 
                                title="Edit eligibility details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-neutral-500">No registrations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($registrations->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 flex items-center justify-between">
            {{ $registrations->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>

<!-- Edit Eligibility Modal -->
<div id="backdrop-edit-eligibility" class="modal-backdrop hidden" onclick="Umera.closeModal('edit-eligibility')"></div>
<div id="modal-edit-eligibility" class="modal-container hidden">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <form id="edit-eligibility-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="flex items-start justify-between p-6 border-b border-neutral-200">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 font-serif">Edit Eligibility Result</h2>
                    <p class="text-sm text-neutral-500 mt-1">Manual assessment details for <span id="override-participant-name" class="font-semibold text-neutral-800"></span></p>
                </div>
                <button type="button" class="btn btn-sm btn-ghost -mt-2 -mr-2" onclick="Umera.closeModal('edit-eligibility')" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Attendance</label>
                        <select id="edit-attendance" name="attendance_status" class="input-field w-full text-sm py-2">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Assessment</label>
                        <select id="edit-assessment" name="assessment_status" class="input-field w-full text-sm py-2">
                            <option value="Passed">Passed</option>
                            <option value="Failed">Failed</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Completion</label>
                        <select id="edit-completion" name="completion_status" class="input-field w-full text-sm py-2">
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 py-2">
                    <input type="checkbox" id="edit-override" name="manual_override" value="1" class="h-4 w-4 rounded border-neutral-300 text-umbera-600 focus:ring-umbera-500" onchange="toggleManualOverride(this.checked)" />
                    <label for="edit-override" class="text-sm font-medium text-neutral-800">
                        Enable Manual Override
                    </label>
                </div>

                <div id="manual-eligibility-control" class="hidden border-t border-neutral-100 pt-4">
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Final Override Decision</label>
                    <select id="edit-eligible" name="eligible" class="input-field w-full text-sm py-2">
                        <option value="1">Force Mark as ELIGIBLE</option>
                        <option value="0">Force Mark as NOT ELIGIBLE</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-neutral-700 uppercase tracking-wider block mb-2">Reason / Override Note (Optional)</label>
                    <textarea id="edit-reason" name="reason" rows="3" placeholder="Explain the reason for manual override or status change..." class="input-field w-full text-sm py-2"></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-neutral-100 bg-neutral-50 rounded-b-xl flex items-center justify-end gap-2">
                <button type="button" onclick="Umera.closeModal('edit-eligibility')" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(regId, participantName, attendance, assessment, completion, override, eligible, reason) {
        const form = document.getElementById('edit-eligibility-form');
        form.action = `/admin/eligibility/${regId}`;
        
        document.getElementById('override-participant-name').textContent = participantName;
        document.getElementById('edit-attendance').value = attendance;
        document.getElementById('edit-assessment').value = assessment;
        document.getElementById('edit-completion').value = completion;
        
        const overrideCheckbox = document.getElementById('edit-override');
        overrideCheckbox.checked = override === 1;
        toggleManualOverride(override === 1);
        
        document.getElementById('edit-eligible').value = eligible ? "1" : "0";
        document.getElementById('edit-reason').value = reason || '';
        
        Umera.openModal('edit-eligibility');
    }

    function toggleManualOverride(isOverride) {
        const controlDiv = document.getElementById('manual-eligibility-control');
        if (isOverride) {
            controlDiv.classList.remove('hidden');
        } else {
            controlDiv.classList.add('hidden');
            // Auto update eligibility select based on regular logic
            const attendance = document.getElementById('edit-attendance').value;
            const assessment = document.getElementById('edit-assessment').value;
            const completion = document.getElementById('edit-completion').value;
            const isEligible = (attendance === 'Present' && assessment === 'Passed' && completion === 'Completed');
            document.getElementById('edit-eligible').value = isEligible ? "1" : "0";
        }
    }

    // Auto-update eligibility select on selector change if manual override is not enabled
    document.querySelectorAll('#edit-attendance, #edit-assessment, #edit-completion').forEach(el => {
        el.addEventListener('change', () => {
            if (!document.getElementById('edit-override').checked) {
                const attendance = document.getElementById('edit-attendance').value;
                const assessment = document.getElementById('edit-assessment').value;
                const completion = document.getElementById('edit-completion').value;
                const isEligible = (attendance === 'Present' && assessment === 'Passed' && completion === 'Completed');
                document.getElementById('edit-eligible').value = isEligible ? "1" : "0";
            }
        });
    });
</script>
@endsection
