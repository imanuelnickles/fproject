<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nama Pengeluaran</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($outcome as $o)
            <tr>
                <td>{{ $o->name }}</td>
                <td>{{ $o->payment_date}}</td>
                <td>{{ $o->amount }}</td>
                <td>
                @if($o->status == 0)
                    <span class="badge bg-red">Belum Lunas</span>
                @else
                    <span class="badge bg-green">Lunas</span>
                @endif
                </td>
                <td>
                    <a class="badge bg-yellow" href="{{ route('edit_property_expenses',['id'=>$property->property_id,'expenses_id'=>$o->outcome_id]) }}">
                        Lihat/Ubah
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>