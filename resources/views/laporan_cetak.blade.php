<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas RT</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #059669; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #047857; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-weight: bold; color: #555; }
        .summary-box { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-box td { border: 1px solid #ddd; padding: 10px; width: 33.3%; text-align: center; }
        .summary-box .title { font-size: 10px; color: #777; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .summary-box .amount { font-size: 18px; font-weight: bold; color: #000; }
        .summary-box .green { color: #059669; }
        .summary-box .red { color: #dc2626; }
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table-data th { background-color: #0f172a; color: white; padding: 8px; text-align: left; }
        .table-data td { border: 1px solid #ddd; padding: 8px; }
        .signature { width: 100%; margin-top: 50px; }
        .signature td { width: 50%; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Keuangan Kas RT</h1>
        <p>Sistem Informasi Manajemen E-KAS Perumahan Warga</p>
        <p style="font-size: 10px; font-weight: normal; margin-top: 5px;">Periode: {{ now()->translatedFormat('F Y') }} | Dicetak pada: {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <h3 style="color: #0f172a; border-left: 4px solid #059669; padding-left: 8px;">Ringkasan Bulan Ini</h3>
    <table class="summary-box">
        <tr>
            <td>
                <span class="title">Total Pemasukan</span>
                <span class="amount green">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="title">Total Pengeluaran</span>
                <span class="amount red">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</span>
            </td>
            <td style="background-color: #ecfdf5;">
                <span class="title">Surplus / Saldo Bulan Ini</span>
                <span class="amount" style="color: #047857;">Rp {{ number_format($pemasukanBulanIni - $pengeluaranBulanIni, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <h3 style="color: #0f172a; border-left: 4px solid #059669; padding-left: 8px;">Rincian Pemasukan Iuran</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Tanggal Bayar</th>
                <th style="width: 45%;">Nama Warga</th>
                <th style="width: 25%;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataIuran as $index => $iuran)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $iuran->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $iuran->user->name ?? 'Warga' }}</td>
                <td>Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; font-style: italic; color: #999;">Belum ada pemasukan bulan ini</td>
            </tr>
            @endforelse
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="3" style="text-align: right;">Total Kas Masuk :</td>
                <td>Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3 style="color: #0f172a; border-left: 4px solid #dc2626; padding-left: 8px;">Rincian Pengeluaran Kas</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%; background-color: #7f1d1d;">No</th>
                <th style="width: 25%; background-color: #7f1d1d;">Tanggal Keperluan</th>
                <th style="width: 45%; background-color: #7f1d1d;">Nama Pengeluaran / Keterangan</th>
                <th style="width: 25%; background-color: #7f1d1d;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataPengeluaran as $index => $pengeluaran)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $pengeluaran->tanggal->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $pengeluaran->judul }}</strong>
                    @if($pengeluaran->keterangan)
                        <br><span style="font-size: 10px; color: #666;">{{ $pengeluaran->keterangan }}</span>
                    @endif
                </td>
                <td>Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; font-style: italic; color: #999;">Belum ada pengeluaran bulan ini</td>
            </tr>
            @endforelse
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="3" style="text-align: right;">Total Kas Keluar :</td>
                <td>Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="signature">
        <tr>
            <td>
                <p>Mengetahui,</p>
                <p><strong>Ketua RT</strong></p>
                <br><br><br>
                <p style="text-decoration: underline;">( Bpk. Imam )</p>
            </td>
            <td>
                <p>Bekasi, {{ now()->format('d M Y') }}</p>
                <p><strong>Bendahara RT</strong></p>
                <br><br><br>
                <p style="text-decoration: underline;">( {{ auth()->user()->name }} )</p>
            </td>
        </tr>
    </table>

</body>
</html>