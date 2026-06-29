<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Statistics Report</title>
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
        .icon-red { background-color: #fee2e2; color: #ef4444; }
        .icon-cyan { background-color: #cffafe; color: #0891b2; }
        .icon-yellow { background-color: #fef3c7; color: #d97706; }

        .chart-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; text-align: center; margin-bottom: 25px; }
        .chart-box img { max-width: 100%; height: auto; }

        .split-layout { width: 100%; margin-bottom: 25px; }
        .split-left { width: 50%; vertical-align: middle; text-align: center; border: 1px solid #e2e8f0; border-radius: 8px 0 0 8px; padding: 20px; }
        .split-right { width: 50%; vertical-align: middle; border: 1px solid #e2e8f0; border-left: none; border-radius: 0 8px 8px 0; padding: 20px; }
        
        .legend-item { padding: 8px 10px; margin-bottom: 5px; background-color: #f8fafc; border-radius: 4px; font-size: 10px; display: block; }
        .legend-color { width: 10px; height: 10px; display: inline-block; margin-right: 8px; border-radius: 2px; }
        .legend-count { float: right; font-weight: bold; color: #111827; }

        .executive-summary { border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px; font-size: 10px; background-color: #fafaf9; }
        .executive-summary p { margin: 0 0 10px 0; line-height: 1.6; color: #374151; }

        .footer-signatures { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        
        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>

    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/POP/' . date('Y') . '/001'])

    <div class="title-bar">Population Demographics Report</div>
    
    <table class="meta-bar">
        <tr>
            <td>Period: <strong>January - June {{ date('Y') }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>

    <div class="section-title">Students Overview</div>

    <table class="kpi-table">
        <tr>
        <td class="kpi-box">
            <p class="kpi-value">{{ $totalStudents }}</p>
            <p class="kpi-label">Total<br>Students</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value text-green">{{ $activeStudents }}</p>
            <p class="kpi-label">Active<br>Students</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value text-red">{{ $inactiveStudents }}</p>
            <p class="kpi-label">Inactive<br>Students</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value text-blue">{{ $onlineStudents }}</p>
            <p class="kpi-label">Online<br>Students</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value">{{ $offlineStudents }}</p>
            <p class="kpi-label">Offline<br>Students</p>
        </td>
        </tr>
    </table>

    <div class="section-title">Teachers Overview</div>

    <table class="kpi-table">
        <tr>
        <td class="kpi-box">
            <p class="kpi-value">{{ $totalTeachers }}</p>
            <p class="kpi-label">Total<br>Teachers</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value text-green">{{ $activeTeachers }}</p>
            <p class="kpi-label">Active<br>Teachers</p>
        </td>
        <td class="kpi-box">
            <p class="kpi-value text-red">{{ $inactiveTeachers }}</p>
            <p class="kpi-label">Inactive<br>Teachers</p>
        </td>
        </tr>
    </table>

    <div class="section-title">Population Growth Trend</div>
    <div class="chart-box">
        <img src="data:image/png;base64,{{ $trendChartBase64 }}" alt="Growth Trend Chart">
    </div>

    <div class="section-title">Student Distribution by Class Level</div>
    <table class="split-layout" cellspacing="0" cellpadding="0">
        <tr>
            <td class="split-left">
                <img src="data:image/png;base64,{{ $pieChartBase64 }}" alt="Class Distribution Pie Chart" style="max-height: 200px;">
            </td>
            <td class="split-right">
                @foreach($levelStats as $stat)
                <div class="legend-item">
                    <span class="legend-color" style="background-color: {{ $stat['color'] }}"></span>
                    {{ $stat['name'] }}
                    <span class="legend-count">{{ $stat['total'] }} students</span>
                </div>
                @endforeach
            </td>
        </tr>
    </table>

    <div class="section-title">Executive Summary</div>
    <div class="executive-summary">
        <p>The population at English Club ICH Medan has shown consistent growth throughout the first half of {{ date('Y') }}, reaching a total of {{ $totalStudents }} students and {{ $totalTeachers }} teachers. This positive trend indicates strong market demand and effective marketing strategies.</p>
        
        <p>The distribution across program levels is well-balanced. The near-equal distribution between online ({{ $onlineStudents }} students) and offline ({{ $offlineStudents }} students) modes demonstrates the institution's successful implementation of hybrid learning options, providing flexibility to meet diverse student needs.</p>
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
