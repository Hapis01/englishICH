<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Income Report</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; margin: 0; padding: 20px; color: #333; font-size: 11px; }
        .header { width: 100%; border-bottom: 2px solid #0B4637; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
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
        .kpi-box { background-color: #f8fafc; border-top: 3px solid #10B981; border-bottom: 1px solid #e2e8f0; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-radius: 4px; padding: 15px 10px; text-align: center; vertical-align: middle; width: 33%; }
        .kpi-value { font-size: 20px; font-weight: bold; color: #0B4637; margin: 0; }
        .kpi-label { font-size: 10px; color: #6b7280; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .chart-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; text-align: center; margin-bottom: 25px; }
        .chart-box img { max-width: 100%; height: auto; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .data-table th { background-color: #0B4637; color: white; padding: 8px; text-align: left; font-size: 10px; }
        .data-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; color: #374151; }
        .data-table tr:nth-child(even) td { background-color: #f8fafc; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer-signatures { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        .pagenum:before { content: counter(page); }
        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>

    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/FIN/' . date('Y') . '/001'])

    <div class="title-bar">Financial Income Report</div>
    
    <table class="meta-bar">
        <tr>
            <td>Period: <strong>{{ $periodLabel ?? 'All Time' }}</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y') }}</strong></td>
        </tr>
    </table>

    <div class="section-title">Income Overview</div>

    <table class="kpi-table">
        <tr>
            <td class="kpi-box">
                <p class="kpi-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                <p class="kpi-label">Total Income</p>
            </td>
            <td class="kpi-box">
                <p class="kpi-value" style="color: #10b981;">Rp {{ number_format($totalFull, 0, ',', '.') }}</p>
                <p class="kpi-label">Total Full Payments</p>
            </td>
            <td class="kpi-box">
                <p class="kpi-value" style="color: #3b82f6;">Rp {{ number_format($totalInstallment, 0, ',', '.') }}</p>
                <p class="kpi-label">Total Installments</p>
            </td>
        </tr>
    </table>

    @if(isset($barChartBase64) && $barChartBase64)
    <div class="section-title">Monthly Income Trend</div>
    <div class="chart-box">
        <img src="data:image/png;base64,{{ $barChartBase64 }}" alt="Monthly Income Trend Chart">
    </div>
    @endif

    <div class="section-title">Income Breakdown by Month</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Month & Year</th>
                <th class="text-right">Full Payments</th>
                <th class="text-right">Installments</th>
                <th class="text-right">Total Income</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach($monthlyIncome as $month => $data)
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $month }}</td>
                <td class="text-right">Rp {{ number_format($data['full'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($data['installment'], 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight: bold; color: #0B4637;">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title" style="page-break-before: always;">Income Breakdown by Class</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Class Name</th>
                <th class="text-right">Students Enrolled</th>
                <th class="text-right">Total Payments</th>
                <th class="text-right">Total Income Generated</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach($classIncome as $classData)
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $classData->name }}</td>
                <td class="text-right">{{ $classData->student_count }} Students</td>
                <td class="text-right">{{ $classData->total_payments }} Transactions</td>
                <td class="text-right" style="font-weight: bold; color: #0B4637;">Rp {{ number_format($classData->total_income, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Detailed Payment Log</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Date</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Payment Type</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach($payments as $payment)
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '-' }}</td>
                <td>{{ $payment->user ? $payment->user->name : 'Unknown' }}</td>
                <td>{{ $payment->schoolClass ? $payment->schoolClass->name : 'Unassigned' }}</td>
                <td>{{ ucfirst($payment->payment_type) }}</td>
                <td class="text-right">Rp {{ number_format($payment->payment_type === 'full' ? $payment->amount : $payment->installment_paid, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            @if($payments->isEmpty())
            <tr>
                <td colspan="6" class="text-center">No payments found for this period.</td>
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
        This document is an official financial report from English Club ICH Medan<br>
        &copy; {{ date('Y') }} English Club ICH Medan. All rights reserved.<br>
        Page <span class="pagenum"></span>
    </div>

</body>
</html>
