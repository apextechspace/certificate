@extends('layouts::admin')

@section('page_title', 'Participants')
@section('page_subtitle', 'Manage and review all program participants')

@section('content')
<div class="space-y-6 animate-fade-in">

    @if (session('success'))
    <div class="p-4 bg-success-50 border border-success-200 text-success-700 rounded-xl text-sm flex items-center gap-2 animate-slide-up">
        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filters --}}
    <div class="card p-5 animate-slide-up">
        <form method="GET" action="{{ route('admin.participants') }}" class="flex flex-col lg:flex-row lg:items-center gap-4">
            <div class="relative flex-1 max-w-2xl">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 pointer-events-none">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="input-field pl-10" />
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <select name="program_id" class="input-field w-auto min-w-[140px]">
                    <option value="">All Programs</option>
                    @foreach ($programs as $p)
                    <option value="{{ $p->id }}" {{ request('program_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                <select name="course_id" class="input-field w-auto min-w-[140px]">
                    <option value="">All Courses</option>
                    @foreach ($courses as $c)
                    <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <select name="eligibility" class="input-field w-auto min-w-[140px]">
                    <option value="">All Eligibility</option>
                    <option value="eligible" {{ request('eligibility') === 'eligible' ? 'selected' : '' }}>Eligible</option>
                    <option value="not_eligible" {{ request('eligibility') === 'not_eligible' ? 'selected' : '' }}>Not Eligible</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.participants') }}" class="btn btn-secondary btn-sm">Reset</a>
                <a href="{{ route('admin.imports') }}" class="btn btn-secondary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Program</th>
                        <th>Eligibility</th>
                        <th>Certificate</th>
                        <th>Downloaded</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $participant)
                    @php
                        $reg  = $participant->registrations->first();
                        $eligResult = $reg?->eligibilityResult;
                        $cert = $reg?->certificate;
                        $isEligible  = $eligResult?->eligible;
                        $certStatus  = $cert?->status ?? 'none';
                        $downloaded  = $cert?->downloads->isNotEmpty() ?? false;
                    @endphp
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-umbera-500 text-white flex items-center justify-center font-semibold text-sm shrink-0">
                                    {{ strtoupper(substr($participant->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-neutral-900">{{ $participant->name }}</div>
                                    @if ($cert)
                                    <div class="text-xs font-mono text-neutral-400">{{ $cert->certificate_number }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-neutral-600">{{ $participant->email }}</td>
                        <td class="text-neutral-600 truncate max-w-[160px]">{{ $reg?->course?->name ?? '—' }}</td>
                        <td>
                            <span class="badge badge-neutral">{{ $reg?->program?->name ?? '—' }}</span>
                        </td>
                        <td>
                            @if ($eligResult === null)
                                <span class="badge badge-neutral">Not Evaluated</span>
                            @elseif ($isEligible)
                                <span class="badge badge-success">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Eligible
                                </span>
                            @else
                                <span class="badge badge-error">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    Not Eligible
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($certStatus === 'issued')
                                <span class="badge badge-success">Issued</span>
                            @elseif ($certStatus === 'revoked')
                                <span class="badge badge-error">Revoked</span>
                            @else
                                <span class="badge badge-neutral">None</span>
                            @endif
                        </td>
                        <td>
                            @if ($downloaded)
                                <span class="badge badge-success">Yes</span>
                            @elseif ($certStatus === 'issued')
                                <span class="badge badge-warning">No</span>
                            @else
                                <span class="text-neutral-400">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.participants.show', $participant->id) }}" class="btn btn-sm btn-ghost p-2 text-blue-600 hover:text-blue-700" title="View profile">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @if($cert)
                                <a href="{{ route('admin.participants.download', [$participant->id, $cert->id]) }}" class="btn btn-sm btn-ghost p-2 text-success-600 hover:text-success-700" title="Download certificate">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.participants.resend', [$participant->id, $cert->id]) }}" class="inline">
                                    @csrf
                                    <button class="btn btn-sm btn-ghost p-2 text-neutral-400 hover:text-neutral-700" title="Resend email">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5h11C20 5 22 7 22 9.5v7.5Z"/><polyline points="22,9 12,15 2,9"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-neutral-400 py-10">
                            No participants found. <a href="{{ route('admin.imports') }}" class="text-umbera-500 hover:underline">Import participants</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-5 py-4 border-t border-neutral-100">
            <div class="text-sm text-neutral-500">
                Showing <span class="font-medium text-neutral-700">{{ $participants->firstItem() ?? 0 }}</span>
                to <span class="font-medium text-neutral-700">{{ $participants->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-neutral-700">{{ number_format($participants->total()) }}</span> participants
            </div>
            <div>{{ $participants->links() }}</div>
        </div>
    </div>
</div>
@endsection
