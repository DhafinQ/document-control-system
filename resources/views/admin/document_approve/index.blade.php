@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Pengesahan Dokumen</h5>
                    
                    
                    <div class="table-responsive mt-4">
                        
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Nomor Revisi</th>
                                    <th>Status</th>
                                    <th>Berkas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($revisions as $rev)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rev->document->code}}</td>
                                    <td>{{$rev->document->title}}</td>
                                    <td>{{$rev->revision_number}}</td>
                                    <td>{{$rev->status}}</td>
                                    <td><a href="{{route('document_revision.show-file',['filename' => $rev->file_path])}}" target="_blank">Lihat File</a></td>
                                    @can('edit-approval')
                                        <td><a href="{{route('document_approval.edit',['documentRevision' => $rev->id])}}" class="btn btn-sm btn-primary">Ubah Status</a></td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection