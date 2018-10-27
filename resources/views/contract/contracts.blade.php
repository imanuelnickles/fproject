<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Contract Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contracts as $cn)
            <tr>
                <td>{{ $cn->tenant->title }} {{ $cn->tenant->first_name }} {{ $cn->tenant->last_name }}</td>
                <td>{{ $cn->start_date}}</td>
                <td>{{ $cn->end_date}}</td>
                <td>{{ $cn->contract_date}}</td>
                <td>
                    <a class="badge bg-yellow" href="{{ route('show_contract',['id'=>$property->property_id,'contract_id'=>$cn->contract_id]) }}">
                        Lihat/ Tambah Pembayaran
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>