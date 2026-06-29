<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentGrade;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * Display student's certificates.
     */
    public function index()
    {
        $student = Auth::user();
        
        $certificates = $student->receivedGrades()
            ->whereNotNull('certificate_number')
            ->where('certificate_status', 'active')
            ->with(['schoolClass.course'])
            ->latest()
            ->get();

        return view('student.certificates', compact('certificates'));
    }

    /**
     * Show certificate details.
     */
    public function show($id)
    {
        $certificate = StudentGrade::whereNotNull('certificate_number')->findOrFail($id);

        // Check if student owns this certificate
        if ($certificate->student_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        // Check if certificate is active
        if ($certificate->certificate_status !== 'active') {
            return redirect()->route('student.certificates')->with('error', 'This certificate has been revoked and is no longer accessible.');
        }

        $certificate->load(['schoolClass.course', 'student']);

        return view('student.certificate-detail', compact('certificate'));
    }

    /**
     * Download certificate as PDF.
     */
    public function download($id)
    {
        $certificate = StudentGrade::whereNotNull('certificate_number')->findOrFail($id);

        // Check if student owns this certificate
        if ($certificate->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if certificate is active
        if ($certificate->certificate_status !== 'active') {
            return back()->with('error', 'This certificate has been revoked.');
        }

        $certificate->load(['schoolClass.course', 'student']);

        // Generate PDF
        $pdf = Pdf::loadView('certificates.template', compact('certificate'));
        
        $fileName = 'Certificate_' . $certificate->certificate_number . '.pdf';
        
        return $pdf->download($fileName);
    }

    /**
     * Public certificate verification page.
     */
    public function verify($token)
    {
        $certificate = StudentGrade::where('verification_token', $token)->first();

        if (!$certificate) {
            return view('certificates.verify', [
                'valid' => false,
                'message' => 'Certificate not found.',
            ]);
        }

        if ($certificate->certificate_status !== 'active') {
            return view('certificates.verify', [
                'valid' => false,
                'message' => 'This certificate has been revoked.',
                'certificate' => $certificate,
            ]);
        }

        $certificate->load(['schoolClass.course', 'student']);

        return view('certificates.verify', [
            'valid' => true,
            'certificate' => $certificate,
        ]);
    }
}
