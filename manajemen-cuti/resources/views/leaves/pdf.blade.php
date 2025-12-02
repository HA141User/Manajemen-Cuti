<!DOCTYPE html>
<html>
<head>
    <title>Surat Izin Cuti - {{ $leave->user->name }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 0; font-size: 10pt; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table td { vertical-align: top; padding: 2px 5px; }
        .label { width: 150px; }
        .footer { width: 100%; margin-top: 50px; }
        .signature { width: 33%; float: left; text-align: center; }
        .signature-name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PT. MAJU MUNDUR JAYA</h2>
        <p>Jl. Jendral Sudirman No. 123, Jakarta Selatan, DKI Jakarta</p>
        <p>Telp: (021) 12345678 | Email: hrd@company.com</p>
    </div>

    <div class="title">SURAT IZIN CUTI</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Departemen HRD PT. Maju Mundur Jaya menerangkan bahwa permohonan cuti dari karyawan:</p>

        <table class="table">
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $leave->user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIP / Username</td>
                <td>: {{ $leave->user->username }}</td>
            </tr>
            <tr>
                <td class="label">Divisi</td>
                <td>: {{ $leave->user->division ? $leave->user->division->name : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Cuti</td>
                <td>: {{ $leave->type === 'annual' ? 'Cuti Tahunan' : 'Cuti Sakit' }}</td>
            </tr>
        </table>

        <p>Telah <strong>DISETUJUI</strong> dengan rincian sebagai berikut:</p>

        <table class="table">
            <tr>
                <td class="label">Tanggal Mulai</td>
                <td>: {{ $leave->start_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Selesai</td>
                <td>: {{ $leave->end_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Total Durasi</td>
                <td>: {{ $leave->total_days }} Hari Kerja</td>
            </tr>
            <tr>
                <td class="label">Alasan Cuti</td>
                <td>: {{ $leave->reason }}</td>
            </tr>
        </table>

        <p>Demikian surat izin ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
        <p>Jakarta, {{ $leave->hrd_approval_date ? $leave->hrd_approval_date->format('d F Y') : date('d F Y') }}</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Pemohon,</p>
            <div class="signature-name">{{ $leave->user->name }}</div>
        </div>
        <div class="signature">
            <p>Mengetahui,</p>
            <div class="signature-name">{{ $leave->leaderApprover->name ?? '(Atasan Langsung)' }}</div>
        </div>
        <div class="signature">
            <p>Menyetujui,</p>
            <div class="signature-name">{{ $leave->hrdApprover->name ?? 'HR Manager' }}</div>
            <div>HR Department</div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>