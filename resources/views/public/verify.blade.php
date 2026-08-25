@extends('layouts::guest')

@section('title', 'Verify Certificate — Umera Business School')

@section('content')
<section class="py-12 md:py-20 bg-gradient-to-b from-neutral-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10 animate-fade-in">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-6">
                <img src="{{ asset('images/logo.png') }}" class="h-11 w-auto object-contain shadow-lg rounded-xl" alt="Umera Logo" />
                <div class="text-left leading-tight">
                    <div class="font-serif font-bold text-xl text-neutral-900">Umera Business School</div>
                    <div class="text-xs text-neutral-500">Credential Verification Portal</div>
                </div>
            </a>
            <h1 class="font-serif text-3xl md:text-4xl lg:text-5xl font-bold text-neutral-900 tracking-tight">
                Certificate Verification
            </h1>
            <p class="mt-4 text-neutral-600 text-base md:text-lg max-w-2xl mx-auto">
                This is an official Umera Business School credential check.
                Below you will find the full details and current status of this certificate.
            </p>
        </div>

        @if($state === 'valid')
        <div class="animate-slide-up">
            <div class="rounded-t-2xl border-t-4 border-l-4 border-r-4 border-success-500 bg-gradient-to-r from-success-500 via-success-600 to-success-500 text-white px-6 md:px-10 py-6 md:py-8 shadow-lg overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/40 shrink-0">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="md:w-10 md:h-10">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="text-sm md:text-base font-semibold uppercase tracking-[0.18em] opacity-90 mb-1">Verification Status</div>
                        <div class="font-serif text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight">VALID &amp; OFFICIALLY ISSUED</div>
                        <div class="mt-2 text-sm md:text-base opacity-90">
                            This credential is authentic, active, and registered with Umera Business School.
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col items-center gap-1 px-5 py-3 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 shrink-0">
                        <div class="text-3xl md:text-4xl font-bold font-serif leading-none">{{ now()->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90">{{ now()->format('M Y') }}</div>
                        <div class="text-[10px] uppercase tracking-[0.2em] opacity-75">Checked on</div>
                    </div>
                </div>
            </div>

            <div class="card rounded-t-none border-t-0 shadow-elevated">
                <div class="p-6 md:p-10 border-b border-neutral-100 bg-gradient-to-br from-white via-white to-umbera-50/40">
                    <div class="flex flex-col md:flex-row gap-8 md:gap-10">
                        <div class="w-full md:w-40 h-56 md:h-auto shrink-0 rounded-xl bg-gradient-to-br from-umbera-500 to-umbera-700 flex items-center justify-center shadow-lg relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10">
                                <svg viewBox="0 0 100 140" class="w-full h-full">
                                    <path d="M0 20 L100 0 L100 120 L0 140 Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="relative text-center text-white p-5">
                                <img src="{{ asset('images/logo.png') }}" class="h-16 md:h-20 w-auto object-contain opacity-50 mx-auto" alt="Umera Logo" />
                                <div class="mt-3 text-[10px] md:text-xs uppercase tracking-[0.2em] font-semibold opacity-90">Umera Business School</div>
                                <div class="mt-1 text-[9px] md:text-[10px] opacity-70 tracking-wide">Official Credential</div>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 space-y-7">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-umbera-600 mb-2">{{ $cert['type'] }}</div>
                                <h2 class="font-serif text-3xl md:text-4xl font-bold text-neutral-900 leading-tight">
                                    {{ $cert['name'] }}
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Course of Study</div>
                                    <div class="text-sm font-semibold text-neutral-900 leading-snug">{{ $cert['course'] }}</div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Program</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $cert['program'] }}</div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Certificate ID</div>
                                    <div class="text-sm font-mono font-semibold text-neutral-900 tracking-wide">{{ $cert['certificate_id'] }}</div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Date Issued</div>
                                    <div class="text-sm font-semibold text-neutral-900">{{ $cert['issue_date'] }}</div>
                                </div>
                            </div>

                            <div class="pt-5 border-t border-neutral-100 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="rounded-xl bg-success-50/60 border border-success-100 px-4 py-3 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-success-100 flex items-center justify-center shrink-0">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-600)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-semibold uppercase tracking-wider text-success-700">Status</div>
                                        <div class="text-sm font-bold text-success-700">Active</div>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-umbera-50/60 border border-umbera-100 px-4 py-3 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-umbera-100 flex items-center justify-center shrink-0">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-semibold uppercase tracking-wider text-umbera-700">Issuer</div>
                                        <div class="text-sm font-bold text-umbera-700">Umera BS</div>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-info-50/60 border border-info-100 px-4 py-3 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-info-100 flex items-center justify-center shrink-0">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-semibold uppercase tracking-wider text-info-700">Validity</div>
                                        <div class="text-sm font-bold text-info-700">Permanent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 bg-neutral-50/70 border-t border-neutral-100 rounded-b-2xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center flex-wrap">
                        <a href="{{ url('/certificate/' . $cert['certificate_id']) }}" class="btn btn-primary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            View Full Certificate
                        </a>
                        <button onclick="Umera.openModal('share')" class="btn btn-secondary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            Share Verification
                        </button>
                        <button onclick="Umera.copyToClipboard('{{ $cert['verify_url'] }}', 'Verification link copied!')" class="btn btn-outline gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @elseif($state === 'revoked')
        <div class="animate-slide-up">
            <div class="rounded-t-2xl border-t-4 border-l-4 border-r-4 border-error-500 bg-gradient-to-r from-error-500 via-error-600 to-error-500 text-white px-6 md:px-10 py-6 md:py-8 shadow-lg overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/40 shrink-0">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="md:w-10 md:h-10">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="text-sm md:text-base font-semibold uppercase tracking-[0.18em] opacity-90 mb-1">Verification Status</div>
                        <div class="font-serif text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight">CERTIFICATE REVOKED</div>
                        <div class="mt-2 text-sm md:text-base opacity-90">
                            This credential has been officially revoked and is no longer considered valid.
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col items-center gap-1 px-5 py-3 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 shrink-0">
                        <div class="text-3xl md:text-4xl font-bold font-serif leading-none">{{ now()->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90">{{ now()->format('M Y') }}</div>
                        <div class="text-[10px] uppercase tracking-[0.2em] opacity-75">Checked on</div>
                    </div>
                </div>
            </div>

            <div class="card rounded-t-none border-t-0 shadow-elevated">
                <div class="p-6 md:p-10 border-b border-neutral-100 bg-gradient-to-br from-white via-white to-error-50/30">
                    <div class="rounded-2xl bg-error-50 border border-error-200 p-6 md:p-7 mb-8">
                        <div class="flex gap-4 md:gap-5 items-start">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-error-100 flex items-center justify-center shrink-0">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--color-error-600)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="md:w-7 md:h-7"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-serif text-xl md:text-2xl font-bold text-error-900">Why has this certificate been revoked?</h3>
                                <p class="mt-2 text-sm md:text-base text-error-800 leading-relaxed">
                                    A revoked certificate means that due to a review by the Umera Business School Credentials Board,
                                    this document has been formally invalidated. It should not be used as proof of completion,
                                    achievement, or qualification by any third party.
                                </p>
                                <ul class="mt-4 space-y-2 text-sm md:text-base text-error-700">
                                    <li class="flex items-start gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        Potential violation of program policies, academic integrity, or code of conduct
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        Incomplete, falsified, or inaccurate records discovered after issuance
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        Formal administrative decision by the Registrar's office
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Holder</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $cert['name'] }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Certificate ID</div>
                            <div class="text-sm font-mono font-semibold text-neutral-900 tracking-wide">{{ $cert['certificate_id'] }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Course</div>
                            <div class="text-sm font-semibold text-neutral-900 leading-snug">{{ $cert['course'] }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Original Issue Date</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $cert['issue_date'] }}</div>
                        </div>
                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 bg-neutral-50/70 border-t border-neutral-100 rounded-b-2xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center flex-wrap">
                        <a href="{{ url('/') }}" class="btn btn-primary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Search Another Certificate
                        </a>
                        <a href="mailto:cert@umbs.ng?subject=Certificate%20Revocation%20Inquiry%3A%20{{ urlencode($cert['certificate_id']) }}" class="btn btn-secondary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Contact Registrar
                        </a>
                        <button onclick="Umera.copyToClipboard('Revoked: {{ $cert['certificate_id'] }} verified on {{ now()->toDateString() }}', 'Status copied!')" class="btn btn-outline gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            Copy Status
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @elseif($state === 'revoked')
        <div class="animate-slide-up">
            <div class="rounded-t-2xl border-t-4 border-l-4 border-r-4 border-error-500 bg-gradient-to-r from-error-600 via-error-700 to-error-600 text-white px-6 md:px-10 py-6 md:py-8 shadow-lg overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/40 shrink-0">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="md:w-10 md:h-10">
                            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="text-sm md:text-base font-semibold uppercase tracking-[0.18em] opacity-90 mb-1">Verification Status</div>
                        <div class="font-serif text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight">CERTIFICATE REVOKED</div>
                        <div class="mt-2 text-sm md:text-base opacity-90">
                            This credential has been officially revoked by Umera Business School and is no longer valid.
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col items-center gap-1 px-5 py-3 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 shrink-0">
                        <div class="text-3xl md:text-4xl font-bold font-serif leading-none">{{ now()->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90">{{ now()->format('M Y') }}</div>
                        <div class="text-[10px] uppercase tracking-[0.2em] opacity-75">Checked on</div>
                    </div>
                </div>
            </div>

            <div class="card rounded-t-none border-t-0 shadow-elevated">
                <div class="p-6 md:p-10 border-b border-neutral-100 bg-gradient-to-br from-white via-white to-error-50/20">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-8 mb-10">
                        <div class="w-20 h-24 shrink-0 rounded-2xl bg-error-50 border-2 border-dashed border-error-200 flex items-center justify-center">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--color-error-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-serif text-2xl md:text-3xl font-bold text-neutral-900 mb-2">Revoked Credential</h3>
                            <p class="text-neutral-600 leading-relaxed">
                                This certificate was previously issued but has been invalidated. Please contact the registrar for more details regarding this specific credential.
                            </p>
                            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-error-50 border border-error-200">
                                <span class="text-xs font-semibold text-error-700 uppercase tracking-wider">Searched ID:</span>
                                <span class="font-mono text-sm font-bold text-error-800">{{ $cert['certificate_id'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 md:px-10 py-6 bg-neutral-50/70 border-t border-neutral-100 rounded-b-2xl text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary gap-2.5 px-7 py-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        Search Another Certificate
                    </a>
                </div>
            </div>
        </div>

        @elseif($state === 'notfound')
        <div class="animate-slide-up">
            <div class="rounded-t-2xl border-t-4 border-l-4 border-r-4 border-neutral-400 bg-gradient-to-r from-neutral-600 via-neutral-700 to-neutral-600 text-white px-6 md:px-10 py-6 md:py-8 shadow-lg overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/40 shrink-0">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="md:w-10 md:h-10">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="text-sm md:text-base font-semibold uppercase tracking-[0.18em] opacity-90 mb-1">Verification Status</div>
                        <div class="font-serif text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight">CERTIFICATE NOT FOUND</div>
                        <div class="mt-2 text-sm md:text-base opacity-90">
                            We could not locate a certificate matching the ID provided in our official registry.
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col items-center gap-1 px-5 py-3 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 shrink-0">
                        <div class="text-3xl md:text-4xl font-bold font-serif leading-none">{{ now()->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90">{{ now()->format('M Y') }}</div>
                        <div class="text-[10px] uppercase tracking-[0.2em] opacity-75">Checked on</div>
                    </div>
                </div>
            </div>

            <div class="card rounded-t-none border-t-0 shadow-elevated">
                <div class="p-6 md:p-10 border-b border-neutral-100 bg-gradient-to-br from-white via-white to-neutral-50">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-8 mb-10">
                        <div class="w-20 h-24 shrink-0 rounded-2xl bg-neutral-100 border-2 border-dashed border-neutral-300 flex items-center justify-center">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-400)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-serif text-2xl md:text-3xl font-bold text-neutral-900 mb-2">Unknown Credential ID</h3>
                            <p class="text-neutral-600 leading-relaxed">
                                This certificate ID does not exist in our official records. It may have been mistyped,
                                fabricated, or is referencing a credential that was never generated or issued by the
                                Umera Business School Registrar's Office.
                            </p>
                            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-neutral-100 border border-neutral-200">
                                <span class="text-xs font-semibold text-neutral-600 uppercase tracking-wider">Searched ID:</span>
                                <span class="font-mono text-sm font-bold text-neutral-800">{{ $cert['certificate_id'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-neutral-50 border border-neutral-200 p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 rounded-lg bg-neutral-200 flex items-center justify-center shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div class="text-sm font-bold text-neutral-900">Warning: Forged Document</div>
                            </div>
                            <p class="text-sm text-neutral-600 leading-relaxed">
                                If you are viewing this verification as part of a job application or credential check,
                                be advised this document is not issued by our institution. Exercise appropriate caution.
                            </p>
                        </div>
                        <div class="rounded-2xl bg-info-50 border border-info-200 p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 rounded-lg bg-info-100 flex items-center justify-center shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-info-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                </div>
                                <div class="text-sm font-bold text-info-900">Double-Check the ID</div>
                            </div>
                            <p class="text-sm text-info-800 leading-relaxed">
                                Certificate IDs follow the format:
                                <span class="font-mono text-xs font-semibold bg-white px-2 py-0.5 rounded border border-info-200">XXXX-XXX-YYYY-NNNNNN</span>.
                                Verify each segment with the issuer.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 bg-neutral-50/70 border-t border-neutral-100 rounded-b-2xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center flex-wrap">
                        <a href="{{ url('/') }}" class="btn btn-primary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></svg>
                            Try Certificate Lookup
                        </a>
                        <a href="{{ url('/verify/UMB5-GAI-2026-000001') }}" class="btn btn-secondary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            See a Valid Example
                        </a>
                        <a href="mailto:cert@umbs.ng" class="btn btn-outline gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Report an Issue
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="animate-slide-up">
            <div class="rounded-t-2xl border-t-4 border-l-4 border-r-4 border-warning-500 bg-gradient-to-r from-warning-500 via-warning-600 to-warning-500 text-white px-6 md:px-10 py-6 md:py-8 shadow-lg overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-5 md:gap-8">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/40 shrink-0">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="md:w-10 md:h-10">
                            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="text-sm md:text-base font-semibold uppercase tracking-[0.18em] opacity-95 mb-1">Verification Status</div>
                        <div class="font-serif text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight">VERIFICATION ERROR</div>
                        <div class="mt-2 text-sm md:text-base opacity-95">
                            We encountered a temporary problem while verifying this credential. Please try again shortly.
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col items-center gap-1 px-5 py-3 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 shrink-0">
                        <div class="text-3xl md:text-4xl font-bold font-serif leading-none">{{ now()->format('d') }}</div>
                        <div class="text-xs uppercase tracking-wider opacity-90">{{ now()->format('M Y') }}</div>
                        <div class="text-[10px] uppercase tracking-[0.2em] opacity-75">Checked on</div>
                    </div>
                </div>
            </div>

            <div class="card rounded-t-none border-t-0 shadow-elevated">
                <div class="p-6 md:p-10 border-b border-neutral-100 bg-gradient-to-br from-white via-white to-warning-50/30">
                    <div class="rounded-2xl bg-warning-50 border border-warning-200 p-6 md:p-7 mb-8">
                        <div class="flex gap-4 md:gap-5 items-start">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-warning-100 flex items-center justify-center shrink-0">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-600)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="md:w-7 md:h-7"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-serif text-xl md:text-2xl font-bold text-warning-900">Something went wrong on our end</h3>
                                <p class="mt-2 text-sm md:text-base text-warning-800 leading-relaxed">
                                    This isn't a certificate status — it's a platform issue. Our verification service may
                                    be temporarily unavailable. The certificate itself may still be perfectly valid.
                                </p>
                                <div class="mt-4 space-y-2 text-sm md:text-base text-warning-700">
                                    <div class="flex items-center gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>Please wait a moment and refresh the page.</span>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>Try using the certificate ID <strong class="font-mono">{{ $cert['certificate_id'] }}</strong> later.</span>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>If this persists, contact our support team for manual confirmation.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Attempted ID</div>
                            <div class="text-sm font-mono font-semibold text-neutral-900 tracking-wide">{{ $cert['certificate_id'] }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.16em] text-neutral-500 mb-1">Server Time</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ now()->toDateTimeString() }}</div>
                        </div>
                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 bg-neutral-50/70 border-t border-neutral-100 rounded-b-2xl">
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center flex-wrap">
                        <button onclick="location.reload()" class="btn btn-primary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></svg>
                            Retry Verification
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-secondary gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Look Up by Email
                        </button>
                        <a href="mailto:cert@umbs.ng" class="btn btn-outline gap-2.5 px-7 py-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Email Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-10 max-w-3xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
            <div class="card p-6 md:p-7 bg-gradient-to-br from-neutral-50 to-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-umbera-50 flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h4 class="font-serif text-lg font-bold text-neutral-900">About Umera Verifications</h4>
                </div>
                <p class="text-sm text-neutral-600 leading-relaxed">
                    This page is the authoritative source for credential verification from Umera Business School.
                    Any document, badge, or credential that links here via QR code or URL is intended to be checked
                    against our live registry. Employers, institutions, and verifiers are encouraged to save a
                    screenshot of this verification page or record the certificate ID for audit purposes.
                </p>
                <div class="mt-5 pt-5 border-t border-neutral-200 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-center gap-2.5 text-xs text-neutral-600">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500 shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        Verified source: cert.umbs.ng
                    </div>
                    <div class="flex items-center gap-2.5 text-xs text-neutral-600">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500 shrink-0"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        TLS encrypted &amp; auditable
                    </div>
                    <div class="flex items-center gap-2.5 text-xs text-neutral-600">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500 shrink-0"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Registry &copy; {{ date('Y') }} Umera BS
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
