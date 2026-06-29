<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoich.png') }}">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-2xl w-full">
            @if($valid)
                <!-- Valid Certificate -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 p-8 text-white text-center">
                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h1 class="text-3xl font-bold mb-2">Certificate Verified ✓</h1>
                        <p class="text-green-100">This certificate is authentic and valid</p>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Certificate Number</p>
                            <p class="text-xl font-bold text-gray-900">{{ $certificate->certificate_number }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Student Name</p>
                                <p class="font-semibold text-gray-900">{{ $certificate->student->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Issue Date</p>
                                <p class="font-semibold text-gray-900">{{ $certificate->issue_date->format('F d, Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Course</p>
                            <p class="font-semibold text-gray-900">{{ $certificate->schoolClass->course->name }}</p>
                            <p class="text-sm text-gray-600">{{ $certificate->schoolClass->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Final Score</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($certificate->final_score, 1) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Grade</p>
                                <p class="text-3xl font-bold text-green-600">{{ $certificate->letter_grade }}</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t">
                            <p class="text-sm text-gray-600 text-center">
                                Issued by <span class="font-semibold">English Club ICH</span>
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Invalid Certificate -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-8 text-white text-center">
                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h1 class="text-3xl font-bold mb-2">Certificate Not Found</h1>
                        <p class="text-red-100">{{ $message }}</p>
                    </div>

                    <div class="p-8 text-center">
                        <p class="text-gray-600 mb-6">
                            The certificate you're trying to verify could not be found in our system or has been revoked.
                        </p>
                        <p class="text-sm text-gray-500">
                            If you believe this is an error, please contact English Club ICH.
                        </p>
                    </div>
                </div>
            @endif

            <div class="mt-6 text-center">
                <a href="/" class="text-blue-600 hover:text-blue-700 font-medium">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
