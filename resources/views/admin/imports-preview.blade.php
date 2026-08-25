@extends('layouts::admin')
@section('page_title', 'Import Preview')
@section('page_subtitle', 'Review and confirm participant import')

@section('content')
<div class="space-y-6 animate-slide-up">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-neutral-50 border border-neutral-200 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-neutral-900">{{ $importData['total'] }}</div>
            <div class="text-xs text-neutral-500 font-medium mt-1">Total Records</div>
        </div>
        <div class="bg-success-50 border border-success-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-success-600">{{ count($importData['valid']) }}</div>
            <div class="text-xs text-success-600 font-medium mt-1">Valid</div>
        </div>
        <div class="bg-warning-50 border border-warning-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-warning-600">{{ count($importData['duplicates']) }}</div>
            <div class="text-xs text-warning-600 font-medium mt-1">Duplicates (will skip)</div>
        </div>
        <div class="bg-error-50 border border-error-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-error-600">{{ count($importData['errored']) }}</div>
            <div class="text-xs text-error-600 font-medium mt-1">Errors</div>
        </div>
    </div>

    {{-- File info --}}
    <div class="card p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-umbera-50 text-umbera-500 flex items-center justify-center shrink-0">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div class="flex-1">
            <p class="font-medium text-neutral-900">{{ $importData['filename'] }}</p>
            <p class="text-xs text-neutral-500">{{ $importData['total'] }} rows detected · Program ID: {{ $importData['program_id'] }}</p>
        </div>
        <a href="{{ route('admin.imports') }}" class="btn btn-secondary btn-sm">Upload Different File</a>
    </div>

    {{-- Errors section --}}
    @if (count($importData['errored']) > 0)
    <div class="card p-5">
        <h3 class="font-semibold text-neutral-900 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-error-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ count($importData['errored']) }} rows with errors (will be skipped)
        </h3>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead><tr><th>Row</th><th>Name</th><th>Email</th><th>Errors</th></tr></thead>
                <tbody>
                    @foreach (array_slice($importData['errored'], 0, 20) as $err)
                    <tr>
                        <td class="font-mono text-xs">{{ $err['row'] }}</td>
                        <td>{{ $err['name'] ?: '—' }}</td>
                        <td>{{ $err['email'] ?: '—' }}</td>
                        <td><span class="text-error-600 text-xs">{{ implode('; ', $err['errors']) }}</span></td>
                    </tr>
                    @endforeach
                    @if (count($importData['errored']) > 20)
                    <tr><td colspan="4" class="text-center text-neutral-400 text-xs">… and {{ count($importData['errored']) - 20 }} more errors</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Duplicates --}}
    @if (count($importData['duplicates']) > 0)
    <div class="card p-5">
        <h3 class="font-semibold text-neutral-900 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-warning-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ count($importData['duplicates']) }} duplicate emails (will be skipped automatically)
        </h3>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead><tr><th>Row</th><th>Name</th><th>Email</th><th>Course</th></tr></thead>
                <tbody>
                    @foreach (array_slice($importData['duplicates'], 0, 10) as $dup)
                    <tr>
                        <td class="font-mono text-xs">{{ $dup['row'] }}</td>
                        <td>{{ $dup['name'] }}</td>
                        <td>{{ $dup['email'] }}</td>
                        <td>{{ $dup['course'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Valid Preview --}}
    <div class="card p-5">
        <h3 class="font-semibold text-neutral-900 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-success-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ count($importData['valid']) }} valid records ready to import
        </h3>
        @if (count($importData['valid']) > 0)
        <div class="overflow-x-auto mb-4">
            <table class="data-table">
                <thead><tr><th>Row</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th></tr></thead>
                <tbody>
                    @foreach (array_slice($importData['valid'], 0, 15) as $row)
                    <tr>
                        <td class="font-mono text-xs">{{ $row['row'] }}</td>
                        <td class="font-medium">{{ $row['name'] }}</td>
                        <td>{{ $row['email'] }}</td>
                        <td>{{ $row['phone'] ?: '—' }}</td>
                        <td class="text-sm">{{ $row['course'] }}</td>
                    </tr>
                    @endforeach
                    @if (count($importData['valid']) > 15)
                    <tr><td colspan="5" class="text-center text-neutral-400 text-xs">… and {{ count($importData['valid']) - 15 }} more valid records</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-3 justify-end">
            <a href="{{ route('admin.imports') }}" class="btn btn-secondary">Cancel</a>
            @if (count($importData['valid']) > 0)
            <form method="POST" action="{{ route('admin.imports.confirm') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirm Import ({{ count($importData['valid']) }} records)
                </button>
            </form>
            @else
            <p class="text-sm text-neutral-500 self-center">No valid records to import.</p>
            @endif
        </div>
    </div>
</div>
@endsection
