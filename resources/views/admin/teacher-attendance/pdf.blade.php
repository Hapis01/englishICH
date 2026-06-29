<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teacher Attendance Report</title>
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

        .filter-info { background-color: #f0fdf4; border-left: 4px solid #10B981; padding: 10px; margin-bottom: 20px; font-size: 10px; }
        .filter-info strong { color: #0B4637; }

        .summary-box { width: 100%; margin-bottom: 20px; }
        .summary-box td { padding: 10px; text-align: center; }
        .summary-item { display: inline-block; padding: 8px 15px; border-radius: 5px; }
        .summary-present { background-color: #d1fae5; color: #065f46; }
        .summary-late { background-color: #fef3c7; color: #92400e; }
        .summary-absent { background-color: #fee2e2; color: #991b1b; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #d1d5db; padding: 8px; font-size: 10px; }
        .data-table th { background-color: #0B4637; color: white; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        .data-table tr:nth-child(even) { background-color: #f9fafb; }
        .data-table tr:hover { background-color: #f3f4f6; }

        .status-present { color: #065f46; font-weight: bold; }
        .status-late { color: #92400e; font-weight: bold; }
        .status-absent { color: #991b1b; font-weight: bold; }
        .status-invalid { color: #6b7280; font-weight: bold; }

        .footer-signatures { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .signature-block { width: 200px; text-align: center; float: right; }
        .signature-stamp { width: 60px; height: 60px; border: 2px solid #cbd5e1; border-radius: 50%; margin: 10px auto; color: #cbd5e1; font-size: 24px; line-height: 60px; text-align: center; opacity: 0.5; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-weight: bold; font-size: 11px; }

        .official-footer { margin-top: 30px; padding: 15px; background-color: #f9fafb; border-top: 2px solid #0B4637; text-align: center; font-size: 10px; color: #666; font-style: italic; }

        .page-footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>
    @include('admin.reports.pdf.partials.letterhead', ['docNo' => 'RPT/TATT/' . date('Y') . '/' . str_pad(rand(1,999), 3, '0', STR_PAD_LEFT)])

    <div class="title-bar">LAPORAN RESMI ABSENSI GURU</div>

    <table class="meta-bar">
        <tr>
            <td>Report Type: <strong>Teacher Attendance Report</strong></td>
            <td class="right">Printed: <strong>{{ date('F j, Y H:i') }} WIB</strong></td>
        </tr>
    </table>

    @if(count($filterInfo) > 0)
    <div class="filter-info">
        <strong>Filters Applied:</strong>
        @if(isset($filterInfo['teacher'])) Teacher: <strong>{{ $filterInfo['teacher'] }}</strong> | @endif
        @if(isset($filterInfo['class'])) Class: <strong>{{ $filterInfo['class'] }}</strong> | @endif
        @if(isset($filterInfo['period'])) Period: <strong>{{ $filterInfo['period'] }}</strong> @endif
    </div>
    @endif

    <!-- Summary -->
    <table class="summary-box">
        <tr>
            <td>
                <div class="summary-item summary-present">
                    <strong>Total Hadir: {{ $totalPresent }}</strong>
                </div>
            </td>
            <td>
                <div class="summary-item summary-late">
                    <strong>Total Terlambat: {{ $totalLate }}</strong>
                </div>
            </td>
            <td>
                <div class="summary-item summary-absent">
                    <strong>Total Tidak Hadir: {{ $totalAbsent }}</strong>
                </div>
            </td>
            <td>
                <div class="summary-item" style="background-color: #e0e7ff; color: #3730a3;">
                    <strong>Persentase Kehadiran: {{ $attendanceRate }}%</strong>
                </div>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $att)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $att->teacher->name }}</td>
                <td>{{ $att->schoolClass->name }}</td>
                <td>{{ $att->date->format('d M Y') }}</td>
                <td style="text-align:center;">{{ $att->time_in ?? '-' }}</td>
                <td style="text-align:center;">{{ $att->time_out ?? '-' }}</td>
                <td style="text-align:center;" class="status-{{ strtolower($att->status) }}">{{ $att->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px;">No attendance records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Official Footer Text -->
    <div class="official-footer">
        Dokumen ini merupakan laporan resmi yang diterbitkan oleh English Club ICH Medan.
    </div>

    <!-- Signature Area -->
    <div class="footer-signatures">
        <div class="signature-block">
            <div style="font-size:10px; color:#666; margin-bottom:10px;">Disetujui oleh,</div>
            <div style="font-weight:bold; font-size:11px;">Leader</div>
            <div style="font-size:9px; color:#999;">English Club ICH Medan</div>
            <div class="signature-line">ADLI QARIN, S.S., M.Ikom</div>
            <div style="font-size:8px; color:#999; margin-top:5px;">Stempel Lembaga</div>
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
