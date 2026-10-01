@extends('layouts.app')

@section('title', 'Terms of Service - Nocturne Notes')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="mb-4">
                <h1 class="h3 fw-bold text-light mb-1">Terms of Service</h1>
                <p class="text-muted small mb-0">Last updated: {{ $lastUpdated }}</p>
            </div>

            <div class="card bg-surface-card rounded-4 border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="legal-prose">
                        <p>
                            These Terms of Service ("Terms") govern your use of <strong>Nocturne Notes</strong> ("the
                            Service"), a personal website operated by {{ $owner?->name ?? 'the site owner' }}. By
                            accessing or using the Service, you agree to these Terms. If you do not agree, please do not
                            use the Service.
                        </p>

                        <h2>1. The Service</h2>
                        <p>
                            Nocturne Notes is a personal journal and notes website. The owner publishes written notes
                            and, through YouTube API Services, may publish videos. Visitors may read content and leave
                            optional comments without an account.
                        </p>

                        <h2>2. Acceptable Use</h2>
                        <ul>
                            <li>Do not post unlawful, hateful, harassing, infringing, or spam content in comments or messages.</li>
                            <li>Do not attempt to disrupt, attack, reverse engineer, or gain unauthorized access to the Service.</li>
                            <li>You are responsible for any content you submit, and you grant us permission to display and moderate it.</li>
                        </ul>
                        <p>
                            We may remove any content and restrict access at our discretion, including content that
                            violates these Terms.
                        </p>

                        <h2>3. Comments &amp; Submissions</h2>
                        <p>
                            Comments may be posted anonymously or with a display name you choose. Keep in mind that
                            anything you submit may be publicly visible. You retain ownership of what you write, but
                            grant the Service a non-exclusive right to display it on the website.
                        </p>

                        <h2>4. YouTube Content</h2>
                        <p>
                            Video features of the Service rely on <strong>YouTube API Services</strong>. By using or
                            viewing video features, you also agree to the
                            <a href="https://www.youtube.com/t/terms" target="_blank" rel="noopener">YouTube Terms of Service</a>,
                            and you acknowledge the
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google Privacy Policy</a>.
                            Videos are hosted on YouTube and remain subject to YouTube's own terms and policies.
                        </p>

                        <h2>5. Intellectual Property</h2>
                        <p>
                            All original notes, text, and site design are the property of the site owner unless otherwise
                            stated. You may not reproduce or redistribute content without permission, except as permitted
                            by law.
                        </p>

                        <h2>6. Disclaimer &amp; Limitation of Liability</h2>
                        <p>
                            The Service is provided "as is" and "as available", without warranties of any kind. To the
                            fullest extent permitted by law, the site owner is not liable for any damages arising from
                            your use of, or inability to use, the Service.
                        </p>

                        <h2>7. Changes to These Terms</h2>
                        <p>
                            We may update these Terms from time to time. Material changes will be reflected by updating
                            the "Last updated" date above. Continued use of the Service means you accept the revised
                            Terms.
                        </p>

                        <h2>8. Contact</h2>
                        <p>
                            Questions about these Terms? Contact us at
                            <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>.
                        </p>

                        <p class="mt-4">
                            <a href="{{ route('privacy.index') }}">Privacy Policy</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
