<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Summary Report</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; margin: 0; padding: 20px; color: #333; font-size: 11px; }
        .header { width: 100%; border-bottom: 2px solid #0B4637; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .company-name { font-size: 20px; font-weight: bold; color: #0B4637; margin: 0; }
        .company-details { font-size: 10px; color: #666; margin: 5px 0 0 0; }
        .doc-no { text-align: right; font-size: 10px; color: #666; }
        .doc-no span { font-weight: bold; color: #0B4637; font-size: 12px; display: block; margin-top: 5px; }
        
        .title-bar { background-color: #0B4637; background-image: linear-gradient(to right, #0B4637, #10B981); color: white; padding: 10px; text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .meta-bar { width: 100%; font-size: 10px; color: #666; margin-bottom: 30px; }
        .meta-bar td { padding: 0; }
        .meta-bar .right { text-align: right; }
        .info-box { margin-bottom: 20px; background-color: #f9fafb; padding: 15px; border-radius: 5px; border: 1px solid #e5e7eb; }
        .info-box strong { color: #0B4637; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background-color: #0B4637; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .footer-signatures { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>
    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/SUM/' . date('Y') . '/001'])
    <div class="title-bar">Student Summary Report</div>
    <table class="meta-bar">
        <tr>
            <td>Period: <strong>January - June {{ date('Y') }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>
    <div class="info-box">
        <p><strong>Class Name:</strong> {{ $class->name }}</p>
        <p><strong>Course:</strong> {{ $class->course->name ?? 'N/A' }}</p>
        <p><strong>Teacher:</strong> {{ $class->teacher->name ?? 'N/A' }}</p>
        <p><strong>Period:</strong> {{ $class->start_date ? $class->start_date->format('d M Y') : '-' }} to {{ $class->end_date ? $class->end_date->format('d M Y') : '-' }}</p>
        <p><strong>Total Students:</strong> {{ $class->students->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Student Name</th>
                <th width="30%">Email</th>
                <th width="30%">WhatsApp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($class->students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->whatsapp ?? '-' }}</td>
            </tr>
            @endforeach
            @if($class->students->count() == 0)
            <tr>
                <td colspan="4" style="text-align: center;">No students enrolled in this class.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer-signatures">
        <div class="signature-block">
            <div style="font-size:10px; color:#666; margin-bottom:10px;">Approved by,</div>
            <div style="font-weight:bold; font-size:11px;">Leader</div>
            <div style="font-size:9px; color:#999;">English Club ICH Medan</div>
            <div class="signature-line">ADLI QARIN, S.S., M.Ikom</div>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div class="page-footer">
        This document is an official report from English Club ICH Medan<br>
        &copy; {{ date('Y') }} English Club ICH Medan. All rights reserved.<br>
        Page <span class="pagenum"></span>
    </div>
</body>
</html>
