@extends('layouts.student')

@section('title', 'Certificate Detail')
@section('page-title', 'Certificate Detail')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('student.certificates') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Certificates
        </a>
    </div>

    <!-- Certificate Preview -->
    <div class="w-full bg-gray-200 rounded-xl shadow-inner p-4 flex justify-center items-start overflow-hidden preview-wrapper">
        <style>
            .preview-wrapper {
                height: 480px; /* Base height for scale(0.6) */
            }
            .preview-cert {
                width: 1056px;
                height: 750px;
                background: white;
                position: relative;
                font-family: 'Times New Roman', serif;
                color: #333;
                transform-origin: top center;
                transform: scale(0.6);
            }
            @media (max-width: 1200px) {
                .preview-wrapper { height: 400px; }
                .preview-cert { transform: scale(0.5); }
            }
            @media (max-width: 900px) {
                .preview-wrapper { height: 320px; }
                .preview-cert { transform: scale(0.4); }
            }
            @media (max-width: 600px) {
                .preview-wrapper { height: 240px; }
                .preview-cert { transform: scale(0.3); }
            }
            @media (max-width: 400px) {
                .preview-wrapper { height: 180px; }
                .preview-cert { transform: scale(0.22); }
            }
            
            .preview-cert .outer-border {
                position: absolute;
                top: 25px;
                left: 25px;
                width: 1006px; /* 1056 - 50 */
                height: 700px; /* 750 - 50 */
                background: white;
                box-sizing: border-box;
            }
            .preview-cert .blue-border {
                width: 100%;
                height: 100%;
                border: 6px solid #0e2a5d;
                box-sizing: border-box;
                position: relative;
            }
            .preview-cert .gold-border {
                position: absolute;
                top: 8px;
                left: 8px;
                right: 8px;
                bottom: 8px;
                border: 2px solid #d4af37;
                text-align: center;
                background: #ffffff;
            }
            .preview-cert .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 0;
                opacity: 0.05;
            }
            .preview-cert .watermark img {
                width: 450px;
                height: auto;
            }
            .preview-cert .content {
                position: relative;
                z-index: 1;
                padding: 40px;
            }
            .preview-cert .header-table {
                width: 100%;
                margin-bottom: 10px;
                border-collapse: collapse;
            }
            .preview-cert .org-name {
                display: inline-block;
                vertical-align: middle;
                font-size: 32px;
                color: #0e2a5d;
                margin-left: 15px;
                font-family: 'Times New Roman', serif;
            }
            .preview-cert .qr-box {
                text-align: center;
                width: 80px;
            }
            .preview-cert .qr-text {
                font-size: 10px;
                color: #666;
                margin-top: 5px;
                font-family: 'Arial', sans-serif;
            }
            .preview-cert .decorative-line {
                width: 60px;
                height: 3px;
                background: #d4af37;
                margin: 10px auto 20px auto;
            }
            .preview-cert h1 {
                font-size: 54px;
                color: #0e2a5d;
                margin: 0;
                font-weight: normal;
                letter-spacing: 1px;
            }
            .preview-cert .subtitle {
                font-size: 18px;
                color: #666;
                margin: 15px 0 20px 0;
                font-style: italic;
            }
            .preview-cert .name-wrapper {
                margin: 10px 0 25px 0;
            }
            .preview-cert .name {
                font-size: 48px;
                color: #0e2a5d;
                font-weight: bold;
                display: inline-block;
                padding: 0 40px 10px 40px;
                border-bottom: 2px solid #0e2a5d;
                min-width: 400px;
            }
            .preview-cert .description {
                font-size: 18px;
                color: #333;
                line-height: 1.6;
                margin: 0 auto 30px auto;
                max-width: 800px;
            }
            .preview-cert .course-highlight {
                color: #0e2a5d;
                font-weight: bold;
            }
            .preview-cert .meta-table {
                width: 70%;
                margin: 0 auto 40px auto;
                font-family: 'Arial', sans-serif;
                font-size: 12px;
            }
            .preview-cert .meta-table th {
                color: #999;
                font-weight: normal;
                padding-bottom: 5px;
            }
            .preview-cert .meta-table td {
                color: #333;
                text-align: center;
                font-weight: bold;
            }
            .preview-cert .footer-signatures {
                position: absolute;
                bottom: 40px;
                left: 0;
                right: 0;
                padding: 0 80px;
            }
            .preview-cert .sig-table {
                width: 100%;
            }
            .preview-cert .sig-block {
                width: 250px;
                display: inline-block;
                text-align: center;
                font-family: 'Arial', sans-serif;
            }
            .preview-cert .sig-line {
                border-top: 1px solid #333;
                margin-bottom: 5px;
            }
            .preview-cert .sig-name {
                font-size: 14px;
                font-weight: bold;
                color: #333;
            }
            .preview-cert .sig-title {
                font-size: 11px;
                color: #666;
            }
        </style>

        <div class="preview-cert shadow-2xl">
            <div class="outer-border">
                <div class="blue-border">
                    <div class="gold-border">
                        
                        <div class="watermark">
                            <img src="{{ asset('images/logoich.png') }}" alt="Watermark">
                        </div>

                        <div class="content">
                            <table class="header-table">
                                <tr>
                                    <td width="80"></td>
                                    <td align="center">
                                        <img src="{{ asset('images/logoich.png') }}" style="width:60px; height:60px; object-fit:contain; vertical-align: middle;">
                                        <div class="org-name">ICH English Club Medan</div>
                                    </td>
                                    <td class="qr-box" valign="top" width="80">
                                        @if($certificate->qr_code)
                                            <img src="data:image/svg+xml;base64,{{ $certificate->qr_code }}" width="60" height="60">
                                            <div class="qr-text">Scan to verify</div>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="decorative-line"></div>

                            <h1>Certificate of Completion</h1>
                            <div class="subtitle">This certifies that</div>

                            <div class="name-wrapper">
                                <div class="name">{{ $certificate->student->name }}</div>
                            </div>

                            <div class="description">
                                has successfully completed the <span class="course-highlight">{{ $certificate->schoolClass->course->name }}</span> at ICH English 
                                Club Medan and demonstrated dedication, participation, and achievement throughout the 
                                course, earning a final grade of <span class="course-highlight">{{ $certificate->letter_grade }} ({{ $certificate->grade_description }})</span>.
                            </div>

                            <table class="meta-table">
                                <tr>
                                    <th>Certificate Number</th>
                                    <th>Completion Date</th>
                                    <th>Final Grade</th>
                                </tr>
                                <tr>
                                    <td>{{ $certificate->certificate_number }}</td>
                                    <td>{{ $certificate->issue_date->format('F j, Y') }}</td>
                                    <td>{{ $certificate->letter_grade }} ({{ $certificate->grade_description }})</td>
                                </tr>
                            </table>
                        </div>

                        <div class="footer-signatures">
                            <table class="sig-table">
                                <tr>
                                    <td align="center" style="width: 50%;">
                                        <div class="sig-block">
                                            <div class="sig-line"></div>
                                            <div class="sig-name">{{ $certificate->schoolClass->teacher->name ?? 'Course Teacher' }}</div>
                                            <div class="sig-title">Lead Instructor</div>
                                        </div>
                                    </td>
                                    <td align="center" style="width: 50%;">
                                        <div class="sig-block">
                                            <div class="sig-line"></div>
                                            <div class="sig-name">ADLI QARIN, S.S., M.Ikom</div>
                                            <div class="sig-title">Chairman, ICH English Club Medan</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Certificate Details</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Certificate Number:</span>
                    <span class="font-semibold text-gray-900">{{ $certificate->certificate_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Issue Date:</span>
                    <span class="font-semibold text-gray-900">{{ $certificate->issue_date->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($certificate->status === 'active') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($certificate->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Verification Token:</span>
                    <span class="font-mono text-xs text-gray-900">{{ Str::limit($certificate->verification_token, 20) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Course Information</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Course:</span>
                    <span class="font-semibold text-gray-900">{{ $certificate->schoolClass->course->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Class:</span>
                    <span class="font-semibold text-gray-900">{{ $certificate->schoolClass->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Instructor:</span>
                    <span class="font-semibold text-gray-900">{{ $certificate->schoolClass->teacher->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Final Score:</span>
                    <span class="text-2xl font-bold text-blue-600">{{ number_format($certificate->final_score, 1) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Download & Share</h3>
                <p class="text-sm text-gray-600">Download your certificate or share the verification link</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="copyVerificationLink()" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy Link
                </button>
                <a href="{{ route('student.certificates.download', $certificate) }}" 
                   class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyVerificationLink() {
    const link = "{{ route('verify.certificate', $certificate->verification_token) }}";
    navigator.clipboard.writeText(link).then(() => {
        alert('Verification link copied to clipboard!');
    });
}
</script>
@endsection
