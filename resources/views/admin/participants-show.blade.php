@extends('layouts::admin')
@section('title', $participant->name . ' — Participant Details')
@section('page_title', 'Participant Details')
@section('page_subtitle', 'View full enrollment and credential history')

@section('content')
<div class="space-y-6 animate-slide-up">
    
    <div class="card p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 rounded-full bg-umbera-100 flex items-center justify-center text-umbera-700 font-bold text-2xl font-serif">
                {{ substr($participant->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold font-serif">{{ $participant->name }}</h2>
                <div class="text-neutral-500 mt-1 flex items-center gap-4">
                    <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $participant->email }}</span>
                    @if($participant->phone_number)
                        <span><svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $participant->phone_number }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h3 class="text-lg font-semibold mt-8 mb-4">Enrollments & Credentials</h3>
    
    @forelse($participant->registrations as $reg)
        <div class="card p-6 mb-4 border-l-4 {{ $reg->certificate ? 'border-success-500' : 'border-neutral-300' }}">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div>
                    <h4 class="font-bold text-lg text-neutral-900">{{ $reg->course->name }}</h4>
                    <p class="text-sm text-neutral-500">{{ $reg->program->name }}</p>
                    <div class="text-xs text-neutral-400 mt-2">Enrolled on {{ $reg->enrolled_at ? \Carbon\Carbon::parse($reg->enrolled_at)->format('M d, Y') : 'N/A' }}</div>
                </div>
                
                @if($reg->certificate)
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-mono font-bold text-success-700">{{ $reg->certificate->certificate_number }}</div>
                            <div class="text-xs text-neutral-500">Issued: {{ $reg->certificate->issued_at ? $reg->certificate->issued_at->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        <a href="{{ route('admin.participants.download', [$participant->id, $reg->certificate->id]) }}" class="btn btn-sm btn-success gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download
                        </a>
                        <form method="POST" action="{{ route('admin.participants.resend', [$participant->id, $reg->certificate->id]) }}" class="inline">
                            @csrf
                            <button class="btn btn-sm btn-outline gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Resend
                            </button>
                        </form>
                    </div>
                @else
                    <span class="badge badge-warning">Pending Credential</span>
                @endif
            </div>
        </div>
    @empty
        <div class="p-8 text-center bg-neutral-50 rounded-xl border border-neutral-100">
            <p class="text-neutral-500">This participant has no course enrollments.</p>
        </div>
    @endforelse

</div>
@endsection
