<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Individual Report Card</title>
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
        .student-info { margin-bottom: 20px; width: 100%; border-collapse: collapse; }
        .student-info td { padding: 8px 0; border-bottom: 1px dashed #ccc; }
        .student-info td:first-child { font-weight: bold; width: 150px; color: #0B4637; }
        .grades-table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
        .grades-table th, .grades-table td { border: 1px solid #d1d5db; padding: 10px; text-align: center; }
        .grades-table th { background-color: #0B4637; color: white; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .grades-table .subject { text-align: left; font-weight: bold; background-color: #f9fafb; width: 50%; }
        .total-row { font-weight: bold; background-color: #e5e7eb; }
        .notes-section { margin-top: 20px; padding: 15px; background-color: #f9fafb; border-left: 4px solid #0B4637; }
        .notes-section h3 { margin-top: 0; color: #0B4637; font-size:12px; }
        .radar-box { width: 100%; text-align: center; margin: 20px 0; }
        .footer-signatures { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>
    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/GRD/' . date('Y') . '/' . str_pad($student->id, 3, "0", STR_PAD_LEFT)])
    <div class="title-bar">Individual Report Card</div>
    <table class="meta-bar">
        <tr>
            <td>Term: <strong>Final Semester {{ date('Y') }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>
    <table class="student-info">
        <tr>
            <td>Student Name</td>
            <td>: {{ $student->name }}</td>
            <td>Class Name</td>
            <td>: {{ $class->name }}</td>
        </tr>
        <tr>
            <td>Student Email</td>
            <td>: {{ $student->email }}</td>
            <td>Course Level</td>
            <td>: {{ $class->course->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Issue Date</td>
            <td>: {{ date('d F Y') }}</td>
            <td>Teacher</td>
            <td>: {{ $class->teacher->name ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th>Criteria</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="subject">Listening Comprehension</td>
                <td>{{ $grade->listening ?? '-' }}</td>
            </tr>
            <tr>
                <td class="subject">Speaking Skills</td>
                <td>{{ $grade->speaking ?? '-' }}</td>
            </tr>
            <tr>
                <td class="subject">Reading Comprehension</td>
                <td>{{ $grade->reading ?? '-' }}</td>
            </tr>
            <tr>
                <td class="subject">Writing Skills</td>
                <td>{{ $grade->writing ?? '-' }}</td>
            </tr>
            <tr>
                <td class="subject">Grammar</td>
                <td>{{ $grade->grammar ?? '-' }}</td>
            </tr>
            <tr>
                <td class="subject">Attendance & Participation</td>
                <td>{{ $grade->attendance ?? '-' }}</td>
            </tr>
            <tr class="total-row">
                <td class="subject" style="text-align: right;">FINAL AVERAGE SCORE</td>
                <td>{{ $grade->average ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="radar-box">
        <img src="data:image/png;base64,{{ $radarChartBase64 }}" style="width: 250px; height: 250px;">
    </div>

    <div class="notes-section">
        <h3>Teacher's Notes</h3>
        <p>{{ $grade->notes ?? 'No additional notes provided by the teacher.' }}</p>
    </div>

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
