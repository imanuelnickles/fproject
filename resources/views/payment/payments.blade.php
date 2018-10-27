<table id="dataTable2" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Notes</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($payments as $o)
            <tr>
                <td>{{$o->payment_type}}</td>
                <td>{{$o->payment_date}}</td>
                <td>{{$o->amount}}</td>
                <td>{{$o->notes}}</td>
            </tr>
        @endforeach
        </tbody>
        
</table>