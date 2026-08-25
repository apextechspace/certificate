@extends('layouts::admin')
@section('page_title', 'Import Participants')
@section('page_subtitle', 'Upload and validate participant data in bulk')

@section('content')
<div class="space-y-6 animate-slide-up">

    @if (session('error'))
    <div class="p-4 bg-error-50 border border-error-200 text-error-700 rounded-xl text-sm flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Upload Card --}}
    <div class="card p-8">
        <h3 class="text-lg font-semibold text-neutral-900 mb-1">Upload Participant File</h3>
        <p class="text-sm text-neutral-500 mb-6">Select the program and upload your CSV or Excel file. Columns required: <code class="bg-neutral-100 px-1 rounded text-xs font-mono">name, email, phone, course_slug</code></p>

        <form id="import-form" method="POST" action="{{ route('admin.imports.upload') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Program selector --}}
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Program <span class="text-error-500">*</span></label>
                <select name="program_id" required class="input-field max-w-sm">
                    <option value="">Select a program...</option>
                    @foreach ($programs as $prog)
                    <option value="{{ $prog->id }}">{{ $prog->name }}</option>
                    @endforeach
                </select>
                @error('program_id') <p class="text-xs text-error-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dropzone --}}
            <div id="dropzone-zone" class="border-2 border-dashed border-neutral-300 bg-neutral-50 rounded-2xl p-12 text-center cursor-pointer transition-all hover:border-umbera-400 hover:bg-umbera-50/30">
                <input type="file" name="file" id="dropzone-input" class="hidden" accept=".csv,.xlsx,.xls" required />
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-umbera-50 flex items-center justify-center">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-neutral-900 mb-2">Drop your file here</h3>
                <p class="text-sm text-neutral-500 mb-1">or click to browse from your computer</p>
                <p class="text-xs text-neutral-400 mb-4">Supports CSV, XLSX, XLS &middot; Max 10MB</p>
                <p id="dropzone-info" class="text-sm font-medium text-umbera-600"></p>
                <div class="mt-5 inline-flex items-center gap-2 text-xs text-neutral-500 bg-white border border-neutral-200 rounded-lg px-3 py-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <a href="{{ route('admin.imports.template') }}" class="hover:text-umbera-500 transition-colors">Download sample template</a>
                </div>
            </div>
            @error('file') <p class="text-xs text-error-600">{{ $message }}</p> @enderror

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="document.getElementById('dropzone-input').value=''; document.getElementById('dropzone-info').textContent='';" class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Clear
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Validate & Preview
                </button>
            </div>
        </form>
    </div>

    {{-- Recent Imports --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-neutral-900">Recent Imports</h3>
        </div>
        @if ($recentImports->isEmpty())
        <p class="text-sm text-neutral-400 text-center py-6">No imports yet. Upload a file above to get started.</p>
        @else
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Imported</th>
                        <th>Duplicates</th>
                        <th>Errors</th>
                        <th>By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentImports as $log)
                    @php $meta = $log->metadata ?? []; @endphp
                    <tr>
                        <td class="font-medium">{{ $log->description }}</td>
                        <td>{{ $meta['imported'] ?? '—' }}</td>
                        <td>{{ $meta['duplicates'] ?? '—' }}</td>
                        <td>{{ $meta['errored'] ?? '—' }}</td>
                        <td>{{ $log->user?->name ?? '—' }}</td>
                        <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Umera.handleDrop('dropzone-zone', 'dropzone-input');
        document.getElementById('dropzone-input').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                document.getElementById('dropzone-info').textContent = '📎 ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            }
        });
    });
</script>
@endsection
