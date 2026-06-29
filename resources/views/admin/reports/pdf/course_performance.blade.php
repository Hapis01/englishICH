<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Performance Report</title>
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

        .section-title { font-size: 13px; font-weight: bold; color: #0B4637; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 15px; margin-top: 25px; }

        .kpi-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin-bottom: 30px; margin-left: -10px; margin-right: -10px; }
        .kpi-box { background-color: #f8fafc; border-top: 3px solid #10B981; border-bottom: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-radius: 4px; padding: 15px 10px; text-align: center; vertical-align: middle; }
        .kpi-value { font-size: 24px; font-weight: bold; color: #0B4637; margin: 0; }
        .kpi-label { font-size: 10px; color: #6b7280; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .icon-blue { background-color: #e0e7ff; color: #4f46e5; }
        .icon-green { background-color: #dcfce7; color: #16a34a; }
        .icon-yellow { background-color: #fef3c7; color: #d97706; }

        .chart-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; text-align: center; margin-bottom: 25px; }
        .chart-box img { max-width: 100%; height: auto; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .data-table th { background-color: #0B4637; color: white; padding: 8px; text-align: left; font-size: 10px; }
        .data-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; color: #374151; }
        .data-table tr:nth-child(even) td { background-color: #f8fafc; }
        
        .badge { padding: 2px 6px; border-radius: 12px; font-size: 8px; font-weight: bold; }
        .badge-excellent { background-color: #dcfce7; color: #166534; }
        .badge-good { background-color: #dbeafe; color: #1e40af; }

        .text-blue { color: #2563eb; font-weight: bold; }
        .text-green { color: #16a34a; font-weight: bold; }

        .recommendations { border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 25px; font-size: 10px; }
        .recommendations h4 { color: #0B4637; margin: 0 0 5px 0; font-size: 11px; }
        .recommendations p { margin: 0 0 10px 0; line-height: 1.5; color: #4b5563; }

        .disclaimer { border-left: 3px solid #d4af37; padding-left: 15px; font-size: 10px; font-style: italic; color: #6b7280; margin-bottom: 40px; background-color: #fefce8; padding: 10px 10px 10px 15px; }

        .footer-signatures { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        
        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>

    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/PER/' . date('Y') . '/001'])

    <div class="title-bar">Course Performance Report</div>
    
    <table class="meta-bar">
        <tr>
            <td>Period: <strong>January - June {{ date('Y') }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>

    <div class="section-title">Key Performance Indicators</div>

    <table class="kpi-table">
        <tr>

        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalClasses }}</p>
            <p class="kpi-label">Total Classes</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalStudents }}</p>
            <p class="kpi-label">Total Students</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $totalTeachers }}</p>
            <p class="kpi-label">Teachers</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $avgAttendance }}%</p>
            <p class="kpi-label">Avg Attendance</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $completionRate }}%</p>
            <p class="kpi-label">Completion Rate</p>
        </td>
        <td class="kpi-box">
            
            <p class="kpi-value">{{ $satisfaction }}%</p>
            <p class="kpi-label">Satisfaction</p>
        </td>
    
        </tr>
    </table>


    <div class="section-title">Performance Trends (January - June {{ date('Y') }})</div>
    <div class="chart-box">
        <img src="data:image/png;base64,{{ $trendChartBase64 }}" alt="Performance Trends Chart">
    </div>

    <div class="section-title">Class-Level Performance Analysis</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Class Level</th>
                <th>Total Students</th>
                <th>Average Score</th>
                <th>Completion Rate</th>
                <th>Performance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classData as $index => $class)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $class['level'] }}</td>
                <td align="center">{{ $class['students'] }}</td>
                <td align="center" class="{{ $class['score'] >= 90 ? 'text-green' : 'text-blue' }}">{{ $class['score'] }}%</td>
                <td align="center">{{ $class['completion'] }}%</td>
                <td align="center">
                    <span class="badge {{ strtolower($class['performance']) == 'excellent' ? 'badge-excellent' : 'badge-good' }}">
                        {{ $class['performance'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="chart-box">
        <img src="data:image/png;base64,{{ $barChartBase64 }}" alt="Class Performance Bar Chart">
    </div>

    <div class="section-title">Strategic Recommendations</div>
    <div class="recommendations">
        <h4>Strengths</h4>
        <p>Consistently high student satisfaction scores ({{ $satisfaction }}% in June {{ date('Y') }}). Positive upward trend across key performance indicators. High completion rates for top-tier classes.</p>
        
        <h4>Areas for Improvement</h4>
        <p>Classes with lower performance metrics require additional support resources. Consider implementing peer mentoring programs to leverage advanced students' success.</p>
        
        <h4>Future Initiatives</h4>
        <p>Expand successful teaching methodologies from high-performing classes to all levels. Develop targeted intervention programs for students at risk of non-completion.</p>
    </div>

    <div class="disclaimer">
        This comprehensive performance report provides data-driven insights into the academic effectiveness and operational success of English Club ICH Medan. The findings are intended to guide strategic planning and continuous improvement initiatives.
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
