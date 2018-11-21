<table id="dataTable4" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Description</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
        @foreach($property_documents as $o)
            <tr>
                <td>{{ $o->description }}</td>
                <td><a href="{{ $o->path}}">Download</a></td>
            </tr>
        @endforeach
        </tbody>
</table>