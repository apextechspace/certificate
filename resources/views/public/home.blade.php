@extends('layouts::guest')

@section('title', 'Find Your Certificate — Umera Business School')

@section('content')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-umbera-50/60 via-white to-white pointer-events-none"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-umbera-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-20 w-80 h-80 bg-umbera-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 lg:py-28">
        <div class="max-w-3xl mx-auto text-center animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-umbera-50 border border-umbera-100 mb-6">
                <span class="w-2 h-2 rounded-full bg-umbera-500 animate-pulse"></span>
                <span class="text-sm font-medium text-umbera-700">{{ $stats['certificates_issued'] }}+ certificates issued</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-serif text-neutral-900 leading-tight tracking-tight">
                Find Your Official
                <span class="text-umbera-500">Umera Certificate</span>
            </h1>
            <p class="mt-6 text-lg md:text-xl text-neutral-600 leading-relaxed max-w-2xl mx-auto">
                Access, download, and share your verified credentials from Umera Business School.
                Enter your registered email below to locate your certificate instantly.
            </p>
        </div>

        <div class="mt-14 max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
            <div class="card p-8 md:p-10 shadow-elevated border-0 bg-white/95 backdrop-blur-sm">

                <form id="lookup-form" onsubmit="return handleLookup(event)" class="space-y-5">
                    <div>
                        <label for="lookup-email" class="block text-sm font-semibold text-neutral-800 mb-2">
                            Registered Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-neutral-400">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="lookup-email"
                                required
                                placeholder="you@example.com"
                                class="input-field pl-12 py-3.5 text-base"
                            />
                        </div>
                        <p class="mt-2.5 text-xs text-neutral-500">
                            Use the email you registered with for UmeraBoost 5.0.
                        </p>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-full py-3.5 text-base">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        Find My Certificate
                    </button>
                </form>

                <div id="lookup-loading" class="hidden text-center py-8 animate-fade-in">
                    <div class="flex flex-col items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-umbera-50 flex items-center justify-center">
                            <div class="spinner text-umbera-500" style="width: 2rem; height: 2rem;"></div>
                        </div>
                        <div>
                            <h3 class="font-serif text-xl font-semibold text-neutral-900">Searching our records…</h3>
                            <p class="mt-1.5 text-sm text-neutral-500">Verifying your credentials, please wait.</p>
                        </div>
                        <div class="w-full max-w-xs">
                            <div class="h-1.5 w-full bg-neutral-100 rounded-full overflow-hidden">
                                <div class="h-full bg-umbera-500 rounded-full animate-pulse" style="width: 65%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="lookup-result" class="hidden">

                    <div id="lookup-found" class="hidden animate-scale-in">
                        <div class="flex flex-col items-center text-center py-4">
                            <div class="w-16 h-16 rounded-2xl bg-success-50 flex items-center justify-center mb-5">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-success-600)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <h3 class="font-serif text-2xl font-semibold text-neutral-900">Certificate Found!</h3>
                            <p class="mt-2 text-neutral-600 max-w-md">
                                We found an active certificate for <span class="font-semibold text-neutral-900">Student Name</span>.
                            </p>

                            <div id="certificates-list-container" class="mt-6 w-full space-y-4">
                                <!-- Dynamic certificate cards will be appended here -->
                            </div>

                            <button data-lookup-reset class="mt-5 text-sm text-neutral-500 hover:text-umbera-500 font-medium transition-colors">
                                &larr; Search another email
                            </button>
                        </div>
                    </div>

                    <div id="lookup-notfound" class="hidden animate-scale-in">
                        <div class="flex flex-col items-center text-center py-4">
                            <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mb-5">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-neutral-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                    <line x1="8" y1="11" x2="14" y2="11"/>
                                </svg>
                            </div>
                            <h3 class="font-serif text-2xl font-semibold text-neutral-900">No Certificate Found</h3>
                            <p class="mt-2 text-neutral-600 max-w-md">
                                We couldn't locate a certificate matching this email in our records.
                            </p>

                            <div class="mt-6 w-full card p-5 text-left bg-neutral-50">
                                <div class="text-sm font-semibold text-neutral-800 mb-3">Troubleshooting tips:</div>
                                <ul class="space-y-2.5 text-sm text-neutral-600">
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-umbera-500 mt-0.5 font-bold">&bull;</span>
                                        Double-check the spelling of your email address
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-umbera-500 mt-0.5 font-bold">&bull;</span>
                                        Try the alternate email you might have registered with
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-umbera-500 mt-0.5 font-bold">&bull;</span>
                                        Check your spam folder for our certificate notification email
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-7 w-full grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <button data-lookup-reset class="btn btn-primary justify-center py-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></svg>
                                    Try Again
                                </button>
                                <a href="mailto:cert@umbs.ng" class="btn btn-secondary justify-center py-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Contact Support
                                </a>
                            </div>
                        </div>
                    </div>

                    <div id="lookup-ineligible" class="hidden animate-scale-in">
                        <div class="flex flex-col items-center text-center py-4">
                            <div class="w-16 h-16 rounded-2xl bg-warning-50 flex items-center justify-center mb-5">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                                    <line x1="12" y1="9" x2="12" y2="13"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                            </div>
                            <h3 class="font-serif text-2xl font-semibold text-neutral-900">Certificate Not Yet Available</h3>
                            <p class="mt-2 text-neutral-600 max-w-md">
                                Your record was found, but eligibility for a certificate is currently under review.
                            </p>

                            <div class="mt-6 w-full card p-5 text-left bg-gradient-to-br from-warning-50 to-white border-warning-100 border-opacity-50">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-warning-100 flex items-center justify-center shrink-0">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning-600)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </div>
                                    <div class="text-sm">
                                        <div class="font-semibold text-neutral-800">Why the delay?</div>
                                        <p class="mt-1 text-neutral-600 leading-relaxed">
                                            Certificates are issued upon meeting all program requirements:
                                            minimum attendance, assessment scores, and coursework completion.
                                            Our team is reviewing records and finalizing eligibility.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-7 w-full grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <button data-lookup-reset class="btn btn-secondary justify-center py-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></svg>
                                    Check Again Later
                                </button>
                                <a href="mailto:cert@umbs.ng" class="btn btn-outline justify-center py-3">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Inquiry Status
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-center items-center gap-x-6 gap-y-2 text-xs text-neutral-500">
                <div class="flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Secure & encrypted lookup
                </div>
                <div class="flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    GDPR compliant
                </div>
                <div class="flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success-500"><polyline points="20 6 9 17 4 12"/></svg>
                    No spam, ever
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-20 border-t border-neutral-100 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center mb-14">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-umbera-50 text-umbera-700 text-xs font-semibold uppercase tracking-wider mb-5">
                Why trust us
            </div>
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-neutral-900">
                Credentials You Can <span class="text-umbera-500">Trust</span>
            </h2>
            <p class="mt-4 text-neutral-600 text-lg leading-relaxed">
                Every Umera certificate is digitally signed, verifiable, and secured on our platform.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            <div class="card p-7 card-hover">
                <div class="w-12 h-12 rounded-xl bg-umbera-50 flex items-center justify-center mb-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h3 class="font-serif text-xl font-semibold text-neutral-900 mb-2">Tamper-Proof Verification</h3>
                <p class="text-neutral-600 leading-relaxed text-sm">
                    Every certificate has a unique ID and QR code. Instantly verify authenticity with employers, institutions, or anyone worldwide.
                </p>
            </div>

            <div class="card p-7 card-hover">
                <div class="w-12 h-12 rounded-xl bg-umbera-50 flex items-center justify-center mb-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><path d="M12 17v3"/><path d="M10 20h4"/></svg>
                </div>
                <h3 class="font-serif text-xl font-semibold text-neutral-900 mb-2">Bank-Level Security</h3>
                <p class="text-neutral-600 leading-relaxed text-sm">
                    Your data is encrypted at rest and in transit. We follow industry best practices to protect your personal information.
                </p>
            </div>

            <div class="card p-7 card-hover">
                <div class="w-12 h-12 rounded-xl bg-umbera-50 flex items-center justify-center mb-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-umbera-500)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                </div>
                <h3 class="font-serif text-xl font-semibold text-neutral-900 mb-2">Download & Share</h3>
                <p class="text-neutral-600 leading-relaxed text-sm">
                    Get high-resolution PDFs for printing and one-click sharing to LinkedIn, WhatsApp, email, or direct verification links.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-20 border-t border-neutral-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center">
                <div class="font-serif text-4xl md:text-5xl font-bold text-umbera-500">{{ $stats['participants'] }}+</div>
                <div class="mt-2 text-sm text-neutral-600 font-medium">Participants</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-4xl md:text-5xl font-bold text-umbera-500">{{ $stats['certificates_issued'] }}+</div>
                <div class="mt-2 text-sm text-neutral-600 font-medium">Certificates Issued</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-4xl md:text-5xl font-bold text-umbera-500">4+</div>
                <div class="mt-2 text-sm text-neutral-600 font-medium">Courses Available</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-4xl md:text-5xl font-bold text-umbera-500">100%</div>
                <div class="mt-2 text-sm text-neutral-600 font-medium">Verified</div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-20 border-t border-neutral-100 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-neutral-900">
                Frequently Asked Questions
            </h2>
        </div>
        <div class="space-y-4">
            <div class="card p-6">
                <div class="font-semibold text-neutral-900 mb-2">How long does it take to receive a certificate?</div>
                <p class="text-sm text-neutral-600 leading-relaxed">Certificates are issued within 5-10 business days after the program concludes, provided you meet all eligibility criteria.</p>
            </div>
            <div class="card p-6">
                <div class="font-semibold text-neutral-900 mb-2">Can I update my name on the certificate?</div>
                <p class="text-sm text-neutral-600 leading-relaxed">Name corrections are allowed within 30 days of issuance. Contact our support with proof of identity for name change requests.</p>
            </div>
            <div class="card p-6">
                <div class="font-semibold text-neutral-900 mb-2">Is there an expiry date on certificates?</div>
                <p class="text-sm text-neutral-600 leading-relaxed">Umera certificates of completion do not expire. They are permanent records of your achievement with our institution.</p>
            </div>
        </div>
    </div>
</section>

<script>
async function handleLookup(e) {
    e.preventDefault();
    
    const email = document.getElementById('lookup-email').value;
    const form = document.getElementById('lookup-form');
    const loading = document.getElementById('lookup-loading');
    const result = document.getElementById('lookup-result');
    
    // Hide previous results
    form.classList.add('hidden');
    result.classList.add('hidden');
    document.querySelectorAll('#lookup-found, #lookup-notfound, #lookup-ineligible').forEach(el => el.classList.add('hidden'));
    
    // Show loading
    loading.classList.remove('hidden');
    
    try {
        const response = await fetch('{{ route('lookup') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
        });
        
        const data = await response.json();
        
        // Hide loading
        loading.classList.add('hidden');
        result.classList.remove('hidden');
        
        if (data.state === 'found') {
            document.getElementById('lookup-found').classList.remove('hidden');
            
            const count = data.certificates.length;
            const headingText = count > 1 ? `${count} Certificates Found!` : 'Certificate Found!';
            const subheadText = count > 1 
                ? `We found ${count} active certificates for <span class="font-semibold text-neutral-900">${data.certificates[0].name}</span>.`
                : `We found an active certificate for <span class="font-semibold text-neutral-900">${data.certificates[0].name}</span>.`;
            
            document.querySelector('#lookup-found h3').innerText = headingText;
            document.querySelector('#lookup-found h3').nextElementSibling.innerHTML = subheadText;
            
            const container = document.getElementById('certificates-list-container');
            container.innerHTML = ''; // Clear previous contents
            
            data.certificates.forEach((cert, idx) => {
                const card = document.createElement('div');
                card.className = 'w-full card p-5 bg-gradient-to-br from-umbera-50 to-white border-umbera-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-left animate-slide-up';
                card.style.animationDelay = `${idx * 0.05}s`;
                
                card.innerHTML = `
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto object-contain shrink-0" alt="Umera Logo" />
                        <div class="min-w-0">
                            <div class="text-[10px] font-semibold text-umbera-600 uppercase tracking-wider">Certificate of Completion</div>
                            <div class="font-serif text-base font-semibold text-neutral-900 mt-0.5 truncate">${cert.name}</div>
                            <div class="text-sm text-neutral-600 mt-0.5 line-clamp-1">${cert.course}</div>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="badge badge-success text-[10px] px-2 py-0.5">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Verified
                                </span>
                                <span class="text-[10px] text-neutral-500 font-mono">${cert.certificate_id}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex sm:flex-col justify-end gap-2 shrink-0 w-full sm:w-auto">
                        <a href="${cert.cert_url}" class="btn btn-primary btn-sm justify-center py-2 text-xs">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            View
                        </a>
                        <button onclick="Umera.openModal('share'); document.getElementById('share-verify-link').value = '${window.location.origin}/verify/${cert.certificate_id}'; document.getElementById('share-cert-id').innerText = '${cert.certificate_id}'; document.querySelector('#modal-share .font-serif.text-lg').innerText = '${cert.name}'; document.querySelector('#modal-share .text-sm.text-neutral-600').innerText = '${cert.course} — UmeraBoost 5.0';" class="btn btn-secondary btn-sm justify-center py-2 text-xs">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            Share
                        </button>
                    </div>
                `;
                container.appendChild(card);
            });
        } else if (data.state === 'ineligible') {
            document.getElementById('lookup-ineligible').classList.remove('hidden');
        } else {
            document.getElementById('lookup-notfound').classList.remove('hidden');
        }
        
    } catch (error) {
        console.error('Lookup failed:', error);
        Umera.showToast('Something went wrong. Please try again.', 'error');
        loading.classList.add('hidden');
        form.classList.remove('hidden');
    }
    
    return false;
}

// Reset functionality
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-lookup-reset]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('lookup-result').classList.add('hidden');
            const form = document.getElementById('lookup-form');
            form.classList.remove('hidden');
            form.reset();
            document.getElementById('lookup-email').focus();
        });
    });
});
</script>
@endsection
