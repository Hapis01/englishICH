<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentGrade::whereNotNull('certificate_number')->with(['student', 'schoolClass.course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('certificate_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('schoolClass', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $certificates = $query->latest('issue_date')->paginate(15)->withQueryString();
        
        $pendingGrades = StudentGrade::with(['student', 'schoolClass.course'])
            ->where('published', true)
            ->whereNull('certificate_number')
            ->latest('grade_date')
            ->get();

        return view('admin.certificates.index', compact('certificates', 'pendingGrades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:student_grades,id',
        ]);

        $grade = StudentGrade::findOrFail($request->grade_id);
        
        // Check if certificate already exists
        if ($grade->certificate_number) {
            return back()->with('error', 'A certificate already exists for this student in this class.');
        }

        $token = \Illuminate\Support\Str::random(32);
        $url = route('verify.certificate', $token);
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate($url));

        $grade->update([
            'certificate_number' => 'CERT-' . date('Ym') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'issue_date' => now(),
            'certificate_status' => 'active',
            'verification_token' => $token,
            'qr_code' => $qrCode,
        ]);

        return back()->with('success', 'Certificate successfully generated and published.');
    }

    public function revoke(Request $request, $id)
    {
        $grade = StudentGrade::findOrFail($id);
        if ($grade->certificate_status === 'active') {
            $grade->update(['certificate_status' => 'revoked']);
            return back()->with('success', 'Certificate successfully revoked.');
        } else {
            $grade->update(['certificate_status' => 'active']);
            return back()->with('success', 'Certificate successfully activated.');
        }
    }
    public function destroy($id)
    {
        $grade = StudentGrade::findOrFail($id);
        
        $grade->update([
            'certificate_number' => null,
            'issue_date' => null,
            'verification_token' => null,
            'qr_code' => null,
            'certificate_status' => 'active'
        ]);

        return back()->with('success', 'Certificate successfully deleted.');
    }
}
