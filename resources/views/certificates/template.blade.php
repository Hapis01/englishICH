<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            background: #ffffff;
            color: #333;
        }
        .outer-border {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 1070px;
            height: 740px;
            background: white;
            box-sizing: border-box;
        }
        .blue-border {
            width: 100%;
            height: 100%;
            border: 6px solid #0e2a5d;
            box-sizing: border-box;
            position: relative;
        }
        .gold-border {
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 2px solid #d4af37;
            text-align: center;
            background: #ffffff;
        }
        
        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            opacity: 0.05;
        }
        .watermark img {
            width: 450px;
            height: auto;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 40px;
        }

        /* Top Header */
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .logo {
            width: 70px;
            height: 70px;
            background: #0e2a5d;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            font-weight: bold;
            line-height: 70px;
            text-align: center;
            display: inline-block;
            vertical-align: middle;
        }
        .org-name {
            display: inline-block;
            vertical-align: middle;
            font-size: 32px;
            color: #0e2a5d;
            margin-left: 15px;
            font-family: 'Times New Roman', serif;
        }
        
        .qr-box {
            text-align: center;
            width: 80px;
        }
        .qr-text {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
            font-family: 'Arial', sans-serif;
        }

        .decorative-line {
            width: 60px;
            height: 3px;
            background: #d4af37;
            margin: 10px auto 20px auto;
        }

        /* Title */
        h1 {
            font-size: 54px;
            color: #0e2a5d;
            margin: 0;
            font-weight: normal;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 18px;
            color: #666;
            margin: 15px 0 20px 0;
            font-style: italic;
        }

        /* Student Name */
        .name-wrapper {
            margin: 10px 0 25px 0;
        }
        .name {
            font-size: 48px;
            color: #0e2a5d;
            font-weight: bold;
            display: inline-block;
            padding: 0 40px 10px 40px;
            border-bottom: 2px solid #0e2a5d;
            min-width: 400px;
        }

        /* Description */
        .description {
            font-size: 18px;
            color: #333;
            line-height: 1.6;
            margin: 0 auto 30px auto;
            max-width: 800px;
        }
        .course-highlight {
            color: #0e2a5d;
            font-weight: bold;
        }

        /* Meta Info Table */
        .meta-table {
            width: 70%;
            margin: 0 auto 40px auto;
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
        .meta-table th {
            color: #999;
            font-weight: normal;
            padding-bottom: 5px;
        }
        .meta-table td {
            color: #333;
            text-align: center;
            font-weight: bold;
        }

        /* Signatures */
        .footer-signatures {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            padding: 0 80px;
        }
        .sig-table {
            width: 100%;
        }
        .sig-block {
            width: 250px;
            display: inline-block;
            text-align: center;
            font-family: 'Arial', sans-serif;
        }
        .sig-line {
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }
        .sig-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .sig-title {
            font-size: 11px;
            color: #666;
        }

    </style>
</head>
<body>
    <div class="outer-border">
        <div class="blue-border">
            <div class="gold-border">
                
                <div class="watermark">
                    <img src="{{ public_path('images/logoich.png') }}" alt="Watermark">
                </div>

                <div class="content">
                    <table class="header-table">
                        <tr>
                            <td width="80"></td>
                            <td align="center">
                                <img src="{{ public_path('images/logoich.png') }}" style="width:60px; height:60px; object-fit:contain; vertical-align: middle;">
                                <div class="org-name">ICH English Club Medan</div>
                            </td>
                            <td class="qr-box" valign="top" width="80">
                                @if($certificate->qr_code)
                                    <img src="data:image/svg+xml;base64,{{ $certificate->qr_code }}" width="60" height="60">
                                    <div class="qr-text">Scan to verify</div>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="decorative-line"></div>

                    <h1>Certificate of Completion</h1>
                    <div class="subtitle">This certifies that</div>

                    <div class="name-wrapper">
                        <div class="name">{{ $certificate->student->name }}</div>
                    </div>

                    <div class="description">
                        has successfully completed the <span class="course-highlight">{{ $certificate->schoolClass->course->name }}</span> at ICH English 
                        Club Medan and demonstrated dedication, participation, and achievement throughout the 
                        course, earning a final grade of <span class="course-highlight">{{ $certificate->letter_grade }} ({{ $certificate->grade_description }})</span>.
                    </div>

                    <table class="meta-table">
                        <tr>
                            <th>Certificate Number</th>
                            <th>Completion Date</th>
                            <th>Final Grade</th>
                        </tr>
                        <tr>
                            <td>{{ $certificate->certificate_number }}</td>
                            <td>{{ $certificate->issue_date->format('F j, Y') }}</td>
                            <td>{{ $certificate->letter_grade }} ({{ $certificate->grade_description }})</td>
                        </tr>
                    </table>
                </div>

                <div class="footer-signatures">
                    <table class="sig-table">
                        <tr>
                            <td align="center" style="width: 50%;">
                                <div class="sig-block">
                                    <div class="sig-line"></div>
                                    <div class="sig-name">{{ $certificate->schoolClass->teacher->name ?? 'Course Teacher' }}</div>
                                    <div class="sig-title">Lead Instructor</div>
                                </div>
                            </td>
                            <td align="center" style="width: 50%;">
                                <div class="sig-block">
                                    <div class="sig-line"></div>
                                    <div class="sig-name">ADLI QARIN, S.S., M.Ikom</div>
                                    <div class="sig-title">Chairman, ICH English Club Medan</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
