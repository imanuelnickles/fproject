<!DOCTYPE html>
<html>
<head>
</head>
<body>

<div align="right"> Tanggal Cutoff {{ $cutoff }} </div>
<h1 align="center"> Laporan Pendapatan Mendatang</h1>
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
        <td style="width:200px;"><b>Jatuh Tempo</b></td>
        <td style="width:600px;"><b>Pelanggan</b></td>
        <td style="width:300px;"><b>Jumlah </b></td>
      </tr>
      
  @endif

  <tr>
    <td>{{ $report[$i]->deadline }}</td>
    <td>{{ $report[$i]->tenant }}</td>
    <td>{{ $report[$i]->amount }}</td>
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
      <td style="width:600px;"></td>
      <td style="width:200px;"><b>Total Pendapatan Mendatang</b></td>
      <td style="width:300px;">{{$total->total}}</td>
    </tr>
</body>