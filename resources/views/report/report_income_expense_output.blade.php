<!DOCTYPE html>
<html>
<head>
</head>
<body>

<div align="right"> Periode {{ $start }} sampai {{ $end }}</div>
<h1 align="center"> Laporan Pemasukan Pengeluaran</h1>
<br>
<br>

@for ($i = 0; $i < count($report); $i++)
  @if ($i == 0 || $report[$i]->property_id != $report[$i-1]->property_id)
    @if ($i != 0) 
      </table>
      <br>
      <br>
      <br>
    @endif
    <b>{{ $report[$i]->property }}</b>
    <hr>
    <table>
      <tr>
        <td style="width:100px;"><b>Tanggal</b></td>
        <td style="width:600px;"><b>Keterangan</b></td>
        <td style="width:200px;"><b>Pemasukan</b></td>
        <td style="width:200px;"><b>Pengeluaran</b></td>
      </tr>
      
  @endif

  <tr>
    <td>{{ $report[$i]->date }}</td>
    <td>{{ $report[$i]->description }}</td>
    <td>{{ $report[$i]->pemasukan }}</td>
    <td>{{ $report[$i]->pengeluaran }}</td>
  </tr>
@endfor

@if ($i != 0) 
  </table>
@endif
  <br>
  <br>
  <br>
  <br>
  <table>
    <tr>
      <td style="width:100px;"></td>
      <td style="width:600px;"></td>
      <td style="width:200px;"><b>Total Pemasukan</b></td>
      <td style="width:200px;">{{$total->pemasukan}}</td>
    </tr>
    <tr>
      <td style="width:100px;"></td>
      <td style="width:600px;"></td>
      <td style="width:200px;"><b>Total Pengeluaran</b></td>
      <td style="width:200px;">{{$total->pengeluaran}}</td>
    </tr>
    <tr>
      <td style="width:100px;"></td>
      <td style="width:600px;"></td>
      <td style="width:200px;"><b>Pemasukan Bersih</b></td>
      <td style="width:200px;">{{$total->total}}</td>
    </tr>
</body>