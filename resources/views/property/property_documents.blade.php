<table id="dataTable4" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Description</th>
                <th>Download</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        @foreach($property_documents as $o)
            <tr>
                <!-- <td>{{ $o->description }}</td> -->
                <td>{{ $o->path }}</td>
                <td><a class="badge bg-yellow" href="{{ $o->path}}">Download</a></td>
                <td>
                    <a class="badge bg-red" href="{{route('delete_file',['id'=>$o->property_document_id,'property_id'=>$property->property_id, 'remove_file'=>base64_encode($o->path)])}}">
                        Remove
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>