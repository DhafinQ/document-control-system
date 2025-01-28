@extends("layouts.layout_admin")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Revisi Dokumen </h5>
                    @can('create-documents')
                    <div class="d-flex justify-content-end mb-1">
                        <a href="{{route('documents.create')}}" class="btn btn-admin d-flex align-items-center">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h-1v5h1" /><path d="M14 12h1v5h-1" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                            Tambah Dokumen 
                        </a>
                        <div class="mx-1"></div>
                        <a href="{{route('document_revision.create')}}" class="btn btn-secondary d-flex align-items-center">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h-1v5h1" /><path d="M14 12h1v5h-1" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                            Perbarui Dokumen 
                        </a>
                    </div>
                    @endcan
                    
                    
                    <div class="table-responsive mt-4">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Uploader</th>
                                    <th>File Dokumen</th>
                                    <th>Revisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($revisions as $key => $revision)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$revision->document->code}}</td>
                                    <td>{{$revision->document->title}}</td>
                                    <td>{{$revision->document->category->name}}</td>
                                    <td>
                                        <span class="badge
                                        @if ($revision->status === 'Draft')
                                            bg-light text-dark
                                        @elseif ($revision->status === 'Disetujui')
                                            bg-success
                                        @elseif ($revision->status === 'Ditolak')
                                            bg-danger
                                        @endif
                                        ">
                                            {{ $revision->status }}
                                        </span>
                                    </td>
                                    <td>{{$revision->reviser->name}}</td>
                                    <td><a href="{{route('document_revision.show-file',['filename' => $revision->file_path])}}" target="_blank">Lihat File</a></td>
                                    <td>
                                        @canany(['edit-documents','edit-revisions'])
                                            @if ($revision->status != 'Draft')
                                                <a href="{{ route('document_revision.edit', $revision) }}" class="btn btn-sm btn-admin">Revisi</a>
                                            @else
                                                -
                                            @endif
                                        @endcanany
                                    </td>
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