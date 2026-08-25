@extends('layouts::admin')

@section('page_title', 'Settings')
@section('page_subtitle', 'System configuration and preferences')

@section('content')
<div class="space-y-6 animate-fade-in">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-6">
        <h3 class="font-semibold text-neutral-900 mb-4">General Settings</h3>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4 max-w-lg">
            @csrf
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1">Organization Name</label>
                <input type="text" name="org_name" class="input-field" value="{{ old('org_name', $settings['org_name']) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1">Support Email</label>
                <input type="email" name="support_email" class="input-field" value="{{ old('support_email', $settings['support_email']) }}" required>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
