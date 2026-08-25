@extends('layouts::guest')

@section('title', $cert['name'] . ' — ' . $cert['type'] . ' | Umera Business School')

@section('content')
<section class="py-10 md:py-16 bg-gradient-to-b from-neutral-50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-success-50 border border-success-100 mb-4">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-success-600"><polyline points="20 6 9 17 4 12"/></svg>
                <span class="text-sm font-semibold text-success-700">Officially Issued Certificate</span>
            </div>
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-neutral-900 tracking-tight">
                Your Certificate is Ready
            </h1>
            <p class="mt-3 text-neutral-600 max-w-xl mx-auto">
                Congratulations, <span class="font-semibold text-neutral-800">{{ $cert['name'] }}</span>!
                Preview your official certificate below and choose your preferred action.
            </p>
        </div>

        <div class="flex justify-center animate-slide-up" style="animation-delay: 0.05s;">
            <div class="w-full max-w-3xl">
                <div class="card p-4 md:p-6 shadow-elevated bg-gradient-to-br from-neutral-100/50 via-white to-umbera-50/30">
                    <div class="relative aspect-[1/1.414] w-full rounded-lg overflow-hidden shadow-xl ring-1 ring-neutral-200 bg-white cert-template-container">
                        <img
                            src="{{ $cert['render_url'] }}"
                            alt="UmeraBoost 5.0 Certificate"
                            class="w-full h-full object-cover"
                            draggable="false"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 max-w-3xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
            <div class="card p-6 md:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div>
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1.5">Certificate ID</div>
                        <div class="font-mono text-sm font-semibold text-neutral-900">{{ $cert['certificate_id'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1.5">Issue Date</div>
                        <div class="text-sm font-semibold text-neutral-900">{{ $cert['issue_date'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1.5">Status</div>
                        <div>
                            <span class="badge badge-success">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Valid & Active
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1.5">Credential Type</div>
                        <div class="text-sm font-semibold text-neutral-900">{{ $cert['type'] }}</div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center flex-wrap">
                    <a href="{{ $cert['download_url'] }}" class="btn btn-primary btn-lg gap-3 px-8 py-3.5" download>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download PNG
                    </a>
                    <button onclick="Umera.openModal('share')" class="btn btn-secondary btn-lg gap-3 px-8 py-3.5">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        Share Certificate
                    </button>
                    <a href="{{ $cert['verify_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-lg gap-3 px-8 py-3.5">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        Public Verification Link
                    </a>
                    <button onclick="Umera.copyToClipboard('{{ $cert['certificate_id'] }}', 'Certificate ID copied!')" class="btn btn-ghost btn-lg gap-3 px-8 py-3.5 text-neutral-600">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Copy ID
                    </button>
                    @if(request()->has('debug'))
                        <a href="{{ url('/certificate/' . $cert['certificate_id']) }}" class="btn btn-secondary btn-lg border-dashed border-red-500 text-red-600 gap-3 px-8 py-3.5">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                            Disable Calibration Mode
                        </a>
                    @else
                        <a href="{{ url('/certificate/' . $cert['certificate_id'] . '?debug=1') }}" class="btn btn-secondary btn-lg border-dashed border-blue-500 text-blue-600 gap-3 px-8 py-3.5">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Enable Calibration Mode
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 max-w-3xl mx-auto animate-slide-up" style="animation-delay: 0.15s;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="card p-5 bg-gradient-to-br from-umbera-50/50 to-white border-umbera-100">
                    <div class="flex gap-4">
                        <div class="w-11 h-11 rounded-xl bg-umbera-100 flex items-center justify-center shrink-0">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-neutral-900 text-sm">Digitally Verified</div>
                            <p class="mt-1 text-xs text-neutral-600 leading-relaxed">This credential is cryptographically signed and registered in our official registry.</p>
                        </div>
                    </div>
                </div>
                <div class="card p-5 bg-gradient-to-br from-success-50/50 to-white border-success-100">
                    <div class="flex gap-4">
                        <div class="w-11 h-11 rounded-xl bg-success-100 flex items-center justify-center shrink-0">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-neutral-900 text-sm">Lifetime Access</div>
                            <p class="mt-1 text-xs text-neutral-600 leading-relaxed">Your certificate never expires. Return anytime to re-download or verify.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
