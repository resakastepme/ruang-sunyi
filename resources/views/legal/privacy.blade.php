@extends('layouts.app')

@section('title', 'Privacy Policy - Nocturne Notes')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="mb-4">
                <h1 class="h3 fw-bold text-light mb-1">Privacy Policy</h1>
                <p class="text-muted small mb-0">Last updated: {{ $lastUpdated }}</p>
            </div>

            <div class="card bg-surface-card rounded-4 border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="legal-prose">
                        <p>
                            This Privacy Policy explains how <strong>Nocturne Notes</strong> ("we", "our", or "the
                            Service"), a personal website operated by {{ $owner?->name ?? 'the site owner' }}, collects,
                            uses, stores, and protects information when you use this website. By using the Service, you
                            agree to the practices described here.
                        </p>

                        <h2>1. Who We Are</h2>
                        <p>
                            Nocturne Notes is a single-author personal journal and notes website. Content is published
                            by the site owner; visitors may read notes publicly and leave optional comments without
                            creating an account.
                        </p>

                        <h2>2. Information We Collect</h2>
                        <ul>
                            <li>
                                <strong>Comments you submit.</strong> When you post a comment, we store the comment text,
                                an optional display name (you may post as "Anonymous"), and the time of submission. No
                                login or email is required to comment.
                            </li>
                            <li>
                                <strong>Messages ("Yap to me").</strong> Short anonymous messages you choose to send to
                                the owner.
                            </li>
                            <li>
                                <strong>Technical data.</strong> Standard session cookies required for security (e.g.,
                                CSRF protection) and basic server logs (such as IP address and browser type) kept for
                                security and abuse prevention.
                            </li>
                            <li>
                                <strong>Owner account.</strong> For the site owner only: name, username, email, optional
                                avatar and bio, and a securely hashed password.
                            </li>
                        </ul>

                        <h2 id="youtube">3. YouTube API Services</h2>
                        <p>
                            The Service uses <strong>YouTube API Services</strong> to let the site owner upload videos
                            (including videos recorded directly in the browser) to the owner's own YouTube channel, and
                            to embed those videos back into notes on this website.
                        </p>
                        <ul>
                            <li>
                                By using features that rely on these APIs, you agree to be bound by the
                                <a href="https://www.youtube.com/t/terms" target="_blank" rel="noopener">YouTube Terms of Service</a>.
                            </li>
                            <li>
                                This Service uses Google services. Please review the
                                <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google Privacy Policy</a>
                                to understand how Google handles your data.
                            </li>
                            <li>
                                <strong>What is accessed.</strong> Only the site owner authorizes access, via Google
                                OAuth 2.0, limited to the <code>youtube.upload</code> scope. We do not access, collect,
                                or store YouTube data belonging to visitors.
                            </li>
                            <li>
                                <strong>What we store.</strong> From the YouTube API we store only the resulting video
                                identifier (to embed the video) and the owner's OAuth refresh token, which is kept
                                securely on the server and used solely to upload on the owner's behalf.
                            </li>
                            <li>
                                <strong>How it is used.</strong> Uploaded videos default to <strong>unlisted</strong>
                                privacy and are used only to display the owner's own content on this website. We do not
                                sell, transfer, or use YouTube data for advertising.
                            </li>
                        </ul>
                        <p>
                            The site owner can revoke this application's access to their Google account at any time via
                            Google's security settings:
                            <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener">https://myaccount.google.com/permissions</a>.
                            Revoking access immediately stops any further use of YouTube API Services by this Service.
                        </p>

                        <h2>4. How We Use Information</h2>
                        <ul>
                            <li>To display notes, comments, and videos on the website.</li>
                            <li>To operate, secure, and maintain the Service and prevent spam or abuse.</li>
                            <li>To upload the owner's videos to YouTube as described above.</li>
                        </ul>

                        <h2>5. Data Retention &amp; Deletion</h2>
                        <ul>
                            <li>
                                Comments and messages are retained until removed by the site owner. Deleted records are
                                soft-deleted and may be permanently removed thereafter.
                            </li>
                            <li>
                                <strong>Request deletion.</strong> You may request removal of a comment or message you
                                submitted by contacting us at the email below; we will remove it within a reasonable
                                time.
                            </li>
                            <li>
                                YouTube-related stored data (video IDs and the owner's OAuth token) is deleted when the
                                owner revokes access or on request.
                            </li>
                        </ul>

                        <h2>6. Sharing &amp; Third Parties</h2>
                        <p>
                            We do not sell your personal information. Data may be processed by the services that make
                            this website work, including Google / YouTube (for video features) and our hosting provider.
                            These parties handle data under their own privacy policies.
                        </p>

                        <h2>7. Cookies</h2>
                        <p>
                            We use only essential cookies needed for session management and security. We do not use
                            cookies for advertising.
                        </p>

                        <h2>8. Children's Privacy</h2>
                        <p>
                            The Service is not directed to children under 13 (or the minimum age required in your
                            jurisdiction), and we do not knowingly collect their personal information.
                        </p>

                        <h2>9. Changes to This Policy</h2>
                        <p>
                            We may update this Privacy Policy from time to time. Material changes will be reflected by
                            updating the "Last updated" date above.
                        </p>

                        <h2>10. Contact</h2>
                        <p>
                            For any question or request regarding this policy or your data, contact us at
                            <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>.
                        </p>

                        <p class="mt-4">
                            <a href="{{ route('tos.index') }}">Terms of Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
