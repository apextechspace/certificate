@extends('layouts::guest')

@section('title', 'Mark Your Attendance — Umera Business School')

@section('content')
@php
    $sessionsByCourse = \App\Models\TimetableSession::orderBy('session_date')->orderBy('start_time')->get()->groupBy('course_id');
@endphp

<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-umbera-50/60 via-white to-white pointer-events-none"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-umbera-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-20 w-80 h-80 bg-umbera-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="max-w-3xl mx-auto text-center animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-umbera-50 border border-umbera-100 mb-6">
                <span class="w-2 h-2 rounded-full bg-umbera-500 animate-pulse"></span>
                <span class="text-sm font-medium text-umbera-700">Live Session Attendance</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold font-serif text-neutral-900 leading-tight tracking-tight">
                Mark Your <span class="text-umbera-500">Attendance</span>
            </h1>
            <p class="mt-6 text-lg text-neutral-600 leading-relaxed max-w-2xl mx-auto">
                Select your course and session to mark your attendance. Attendance is monitored and automatically evaluated for certificate eligibility.
            </p>
        </div>

        <div class="mt-12 max-w-xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
            <div class="card p-8 md:p-10 shadow-elevated border-0 bg-white/95 backdrop-blur-sm">
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-success-50 border border-success-200 text-success-700 flex items-start gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <div>
                            <p class="font-semibold">Success</p>
                            <p class="text-sm mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-error-50 border border-error-200 text-error-700 flex items-start gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        <div>
                            <p class="font-semibold">Failure</p>
                            <p class="text-sm mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-error-50 border border-error-200 text-error-700">
                        <p class="font-semibold mb-1">Please correct the following errors:</p>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('attendance.mark') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-800 mb-2">
                            Registered Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-neutral-400">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                required
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                class="input-field pl-12 py-3 text-sm"
                            />
                        </div>
                        <p class="mt-1.5 text-xs text-neutral-500">
                            Use the email address you registered with to receive your certificate.
                        </p>
                    </div>

                    <div>
                        <label for="course_id" class="block text-sm font-semibold text-neutral-800 mb-2">
                            Course
                        </label>
                        <select name="course_id" id="course_id" required class="input-field text-sm py-3" onchange="updateSessionsDropdown()">
                            <option value="">Select your course</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->program->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="timetable_session_id" class="block text-sm font-semibold text-neutral-800 mb-2">
                            Timetable Session / Date
                        </label>
                        <select name="timetable_session_id" id="timetable_session_id" required class="input-field text-sm py-3">
                            <option value="">Select a session</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-full py-3.5 text-base">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Mark My Attendance
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    const sessionsMap = @json($sessionsByCourse);

    function updateSessionsDropdown() {
        const courseSelect = document.getElementById('course_id');
        const sessionSelect = document.getElementById('timetable_session_id');
        const selectedCourseId = courseSelect.value;

        // Clear previous options
        sessionSelect.innerHTML = '<option value="">Select a session</option>';

        if (!selectedCourseId || !sessionsMap[selectedCourseId]) {
            return;
        }

        const courseSessions = sessionsMap[selectedCourseId];
        courseSessions.forEach(session => {
            const option = document.createElement('option');
            option.value = session.id;
            
            // Format the date (e.g. Sept 3, 2026)
            const dateObj = new Date(session.session_date);
            const dateStr = dateObj.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            // Format times (e.g. 5:30 PM)
            const formatTime = (timeStr) => {
                const parts = timeStr.split(':');
                const hour = parseInt(parts[0]);
                const min = parts[1];
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const formattedHour = hour % 12 === 0 ? 12 : hour % 12;
                return `${formattedHour}:${min} ${ampm}`;
            };

            const timeStr = `${formatTime(session.start_time)} - ${formatTime(session.end_time)}`;
            option.textContent = `${dateStr} (${timeStr})`;
            sessionSelect.appendChild(option);
        });
    }

    // Run on load if course was pre-selected (validation error returns)
    window.onload = function() {
        if(document.getElementById('course_id').value) {
            updateSessionsDropdown();
            // Restore session choice if old input exists
            const oldSession = "{{ old('timetable_session_id') }}";
            if (oldSession) {
                document.getElementById('timetable_session_id').value = oldSession;
            }
        }
    }
</script>
@endsection
