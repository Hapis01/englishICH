<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Attendance Report</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; margin: 0; padding: 20px; color: #333; font-size: 11px; }
        .header { width: 100%; border-bottom: 2px solid #0B4637; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .logo-box { width: 50px; height: 50px; background-color: #0B4637; background-image: linear-gradient(135deg, #0B4637, #10B981); color: white; text-align: center; border-radius: 8px; font-size: 24px; font-weight: bold; line-height: 50px; }
        .company-name { font-size: 20px; font-weight: bold; color: #0B4637; margin: 0; }
        .company-details { font-size: 10px; color: #666; margin: 5px 0 0 0; }
        .doc-no { text-align: right; font-size: 10px; color: #666; }
        .doc-no span { font-weight: bold; color: #0B4637; font-size: 12px; display: block; margin-top: 5px; }
        
        .title-bar { background-color: #0B4637; background-image: linear-gradient(to right, #0B4637, #10B981); color: white; padding: 10px; text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .meta-bar { width: 100%; font-size: 10px; color: #666; margin-bottom: 20px; }
        .meta-bar td { padding: 0; }
        .meta-bar .right { text-align: right; }

        .class-info { margin-bottom: 20px; font-size: 11px; color: #4b5563; }
        .class-info table { width: 100%; }
        .class-info td { padding: 3px 0; }
        .class-info strong { color: #111827; }

        .section-title { font-size: 13px; font-weight: bold; color: #0B4637; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 15px; margin-top: 25px; }

        .kpi-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin-bottom: 30px; margin-left: -10px; margin-right: -10px; }
        .kpi-box { background-color: #f8fafc; border-top: 3px solid #10B981; border-bottom: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-radius: 4px; padding: 15px 10px; text-align: center; vertical-align: middle; }
        .kpi-value { font-size: 24px; font-weight: bold; color: #0B4637; margin: 0; }
        .kpi-label { font-size: 10px; color: #6b7280; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .icon-blue { background-color: #e0e7ff; color: #4f46e5; }
        .icon-cyan { background-color: #cffafe; color: #0891b2; }
        .icon-green { background-color: #dcfce7; color: #16a34a; }
        .icon-yellow { background-color: #fef3c7; color: #d97706; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th { background-color: #0B4637; color: white; padding: 10px 8px; text-align: left; font-size: 10px; vertical-align: bottom; }
        .data-table td { padding: 10px 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; color: #374151; }
        .data-table tr:nth-child(even) td { background-color: #f8fafc; }
        
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 9px; font-weight: bold; }
        .badge-perfect { background-color: #dcfce7; color: #166534; }
        .badge-excellent { background-color: #dbeafe; color: #1e40af; }
        .badge-verygood { background-color: #cffafe; color: #0f766e; }
        .badge-good { background-color: #fef3c7; color: #b45309; }

        .text-green { color: #16a34a; font-weight: bold; }
        .text-red { color: #dc2626; font-weight: bold; }

        .disclaimer { border-left: 3px solid #d4af37; padding-left: 15px; font-size: 10px; font-style: italic; color: #6b7280; margin-bottom: 50px; background-color: #fefce8; padding: 10px 10px 10px 15px; }

        .footer-signatures { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .signature-block-left { width: 200px; text-align: center; float: left; margin-left: 30px; }
        .signature-block-right { width: 200px; text-align: center; float: right; margin-right: 30px; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        
        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>

    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/ATT/' . date('Y') . '/001'])

    <div class="title-bar">Student Attendance Report</div>
    
    <table class="meta-bar">
        <tr>
            <td>Period: <strong>January - June {{ date('Y') }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>

    <div class="class-info">
        <table>
            <tr>
                <td width="50%">Class Name: <strong>{{ $class->name }} ({{ $class->course->name ?? '' }})</strong></td>
                <td>Program Type: <strong>{{ ucfirst($class->learning_method) }}</strong></td>
            </tr>
            <tr>
                <td>Teacher: <strong>{{ $class->teacher->name ?? 'Unassigned' }}</strong></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="kpi-table">
        <tr>

        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalStudents }}</p>
            <p class="kpi-label">Total Students</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalMeetings }}</p>
            <p class="kpi-label">Total Meetings</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalPresent }}</p>
            <p class="kpi-label">Total Present</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $overallRate }}%</p>
            <p class="kpi-label">Attendance Rate</p>
        </td>
    
        </tr>
    </table>


    <div class="section-title">Attendance Distribution</div>
    <div style="text-align: center; margin-bottom: 25px;">
        <img src="data:image/png;base64,{{ $pieChartBase64 }}" alt="Attendance Pie Chart" style="max-width: 300px; height: auto;">
    </div>

    <div class="section-title">Detailed Attendance Records</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Student<br>Name</th>
                <th>Student<br>ID</th>
                <th>Total<br>Meetings</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Attendance<br>%</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studentRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record['name'] }}</td>
                <td style="color:#6b7280">{{ $record['id'] }}</td>
                <td align="center">{{ $record['meetings'] }}</td>
                <td align="center" class="text-green">{{ $record['present'] }}</td>
                <td align="center" class="{{ $record['absent'] > 0 ? 'text-red' : '' }}">{{ $record['absent'] }}</td>
                <td align="center">{{ $record['rate'] }}%</td>
                <td align="center">
                    @php
                        $badgeClass = 'badge-good';
                        if ($record['status'] == 'Perfect') $badgeClass = 'badge-perfect';
                        elseif ($record['status'] == 'Excellent') $badgeClass = 'badge-excellent';
                        elseif ($record['status'] == 'Very Good') $badgeClass = 'badge-verygood';
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $record['status'] }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="disclaimer">
        Based on the attendance records maintained by English Club ICH Medan, the information contained in this report is true and can be used as an official document for academic and administrative purposes.
    </div>

    <div class="footer-signatures">
        <div class="signature-block-left">
            <div style="font-size:10px; color:#666; margin-bottom:10px;">Course Teacher</div>
            <div class="signature-line" style="margin-top: 80px;">{{ $class->teacher->name ?? 'Unassigned' }}</div>
        </div>
        <div class="signature-block-right">
            <div style="font-size:10px; color:#666; margin-bottom:10px;">Approved by,</div>
            <div style="font-weight:bold; font-size:11px;">Leader</div>
            <div style="font-size:9px; color:#999;">English Club ICH Medan</div>
            <div class="signature-line" style="margin-top:50px;">ADLI QARIN, S.S., M.Ikom</div>
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
