<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $certificate->student->nama_lengkap }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .page-break {
                page-break-after: always;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
        }
        
        .certificate-page {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            position: relative;
            background: #fff;
        }
        
        /* Halaman 1 - Depan */
        .front-page {
            text-align: center;
            border: 10px double #4169E1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6e9ff 100%);
        }
        
        .logo {
            margin-bottom: 20px;
        }
        
        .logo img {
            width: 100px;
            height: auto;
        }
        
        .title {
            font-size: 32pt;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 50px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .divider {
            width: 60%;
            height: 2px;
            background: linear-gradient(to right, transparent, #4169E1, transparent);
            margin: 30px 0;
        }
        
        .presented-to {
            font-size: 14pt;
            color: #555;
            margin-bottom: 15px;
        }
        
        .student-name {
            font-size: 28pt;
            font-weight: bold;
            color: #4169E1;
            margin: 20px 0;
            font-style: italic;
        }
        
        .completion-text {
            font-size: 14pt;
            color: #333;
            margin-bottom: 10px;
        }
        
        .course-name {
            font-size: 20pt;
            font-weight: bold;
            color: #1a1a1a;
            margin: 15px 0;
        }
        
        .period {
            font-size: 12pt;
            color: #666;
            margin-top: 10px;
        }
        
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            width: 80%;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 2px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .date {
            margin-top: 40px;
            font-size: 12pt;
            color: #666;
        }
        
        /* Halaman 2 - Belakang */
        .back-page {
            padding: 0;
        }
        
        .header {
            text-align: center;
            padding: 30px 0;
            background: linear-gradient(135deg, #4169E1 0%, #6a5acd 100%);
            color: white;
            margin-bottom: 30px;
        }
        
        .header h2 {
            font-size: 24pt;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 12pt;
        }
        
        .content {
            padding: 20px 40px;
        }
        
        .student-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .student-info td {
            padding: 8px 0;
        }
        
        .student-info td:first-child {
            width: 150px;
            font-weight: bold;
            color: #555;
        }
        
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .grades-table th,
        .grades-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .grades-table th {
            background: #4169E1;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11pt;
        }
        
        .grades-table tr:hover {
            background: #f8f9fa;
        }
        
        .grade-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 10pt;
        }
        
        .grade-a { background: #d4edda; color: #155724; }
        .grade-b { background: #cce5ff; color: #004085; }
        .grade-c { background: #fff3cd; color: #856404; }
        .grade-d { background: #ffe5cc; color: #856404; }
        .grade-e { background: #f8d7da; color: #721c24; }
        
        .total-row {
            background: #4169E1 !important;
            color: white;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            padding: 30px;
            color: #999;
            font-size: 10pt;
            border-top: 2px solid #eee;
            margin-top: 40px;
        }
        
        .certificate-number {
            text-align: center;
            margin-top: 30px;
            font-size: 10pt;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- Halaman 1: Depan (Kelulusan) -->
    <div class="certificate-page front-page">
        <div class="logo"><img src="{{ asset('Logo.png') }}" alt=""></div>
        
        <h1 class="title">Sertifikat Kelulusan</h1>
        
        <div class="divider"></div>
        
        <p class="presented-to">Diberikan kepada:</p>
        
        <p class="student-name">{{ strtoupper($certificate->student->nama_lengkap) }}</p>
        
        <p class="completion-text">Telah menyelesaikan kursus</p>
        
        <p class="course-name">{{ $certificate->class->course->nama_bahasa }}</p>
        <p class="period">{{ $certificate->class->periode }}</p>
        
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    <strong>Guru Pengampu</strong>
                </div>
                <p style="margin-top: 5px; font-size: 11pt;">{{ $certificate->class->guru->nama_lengkap }}</p>
            </div>
        </div>
        
        <div class="date">
            <p>Tanggal Terbit: <strong>{{ $certificate->tgl_terbit->format('d F Y') }}</strong></p>
        </div>
    </div>
    
    <!-- Page Break untuk Print -->
    <div class="page-break"></div>
    
    <!-- Halaman 2: Belakang (Rincian Nilai) -->
    <div class="certificate-page back-page">
        <div class="header">
            <h2>Rincian Nilai</h2>
            <p>Detail Penilaian Per Element</p>
        </div>
        
        <div class="content">
            <div class="student-info">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>: <strong>{{ $certificate->student->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <td>Kursus</td>
                        <td>: <strong>{{ $certificate->class->course->nama_bahasa }}</strong></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>: <strong>{{ $certificate->class->periode }}</strong></td>
                    </tr>
                    <tr>
                        <td>Nomor Sertifikat</td>
                        <td>: <strong>{{ $certificate->nomor_sertifikat }}</strong></td>
                    </tr>
                </table>
            </div>
            
            <table class="grades-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Element</th>
                        <th style="width: 25%;">Nilai Angka</th>
                        <th style="width: 25%;">Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $skills = [
                            'nilai_reading' => 'Reading',
                            'nilai_writing' => 'Writing',
                            'nilai_listening' => 'Listening',
                            'nilai_speaking' => 'Speaking',
                            'nilai_grammar' => 'Grammar'
                        ];
                        
                        $getGrade = function($value) {
                            if (!$value) return '-';
                            return match(true) {
                                $value >= 90 => '<span class="grade-badge grade-a">A</span>',
                                $value >= 80 => '<span class="grade-badge grade-b">B</span>',
                                $value >= 70 => '<span class="grade-badge grade-c">C</span>',
                                $value >= 60 => '<span class="grade-badge grade-d">D</span>',
                                default => '<span class="grade-badge grade-e">E</span>',
                            };
                        };
                    @endphp
                    
                    @foreach($skills as $field => $name)
                        <tr>
                            <td><strong>{{ $name }}</strong></td>
                            <td>{{ $certificate->$field ?? '-' }}</td>
                            <td>{!! $certificate->$field ? $getGrade($certificate->$field) : '-' !!}</td>
                        </tr>
                    @endforeach
                    
                    <tr class="total-row">
                        <td><strong>RATA-RATA TOTAL</strong></td>
                        <td><strong>{{ number_format($certificate->rata_rata_total ?? 0, 2) }}</strong></td>
                        <td>
                            @if($certificate->rata_rata_total)
                                @php
                                    $finalGrade = match(true) {
                                        $certificate->rata_rata_total >= 90 => 'A',
                                        $certificate->rata_rata_total >= 80 => 'B',
                                        $certificate->rata_rata_total >= 70 => 'C',
                                        $certificate->rata_rata_total >= 60 => 'D',
                                        default => 'E',
                                    };
                                    $gradeClass = match($finalGrade) {
                                        'A' => 'grade-a',
                                        'B' => 'grade-b',
                                        'C' => 'grade-c',
                                        'D' => 'grade-d',
                                        default => 'grade-e',
                                    };
                                @endphp
                                <span class="grade-badge {{ $gradeClass }}">{{ $finalGrade }}</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="certificate-number">
                <p>Nomor Sertifikat: <strong>{{ $certificate->nomor_sertifikat }}</strong></p>
                <p style="margin-top: 10px;">Sertifikat ini diterbitkan secara elektronik dan sah tanpa tanda tangan dan stempel.</p>
            </div>
        </div>
        
        <div class="footer">
            <p>LMS Bahasa - Learning Management System</p>
            <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
    
    <script>
        // Auto print dialog saat halaman dimuat
        window.onload = function() {
            // Tunggu sebentar agar halaman siap
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
