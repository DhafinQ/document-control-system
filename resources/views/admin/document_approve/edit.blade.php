@extends("layouts.layout_admin")

@section("title", "Detail Document")

@section("content")
<div class="container-fluid">
    <div class="row">
        <!-- Card Utama -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title fw-semibold mb-4">
                                <i class="fa fa-file-signature me-2"></i> Tanda Tangan Dokumen
                            </h5>
                            <div class="table-responsive mt-4">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Nomor Dokumen</th>
                                            <td>{{$document->code}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Judul</th>
                                            <td>{{$document->title}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kategori</th>
                                            <td>{{$document->category->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td class="badge p-2 m-3">
                                                {{$document->currentRevision->status}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Pembuat</th>
                                            <td>{{$document->uploader->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Deskripsi</th>
                                            <td>{{$document->currentRevision->latestRevision($document->id)->description}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @can('view-histories')
                            <h5 class="card-title fw-semibold mt-5 mb-4">
                                <i class="fa fa-history me-2"></i> Riwayat Revisi
                            </h5>
                            <div class="table-responsive">
                                <table id="revisionTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No. Revisi</th>
                                            <th>Pengunggah</th>
                                            <th>Tanggal Revisi</th>
                                            <th>Status</th>
                                            <th>Berkas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document->revisions as $rev)
                                        <tr>
                                            <td>{{$rev->revision_number}}</td>
                                            <td>{{$rev->reviser->name}}</td>
                                            <td>{{\Carbon\Carbon::parse($rev->created_at)->format('H:i:s-d/m/Y')}}</td>
                                            <td><span class="badge p-2
                                                @if ($rev->status === 'Disetujui')
                                                    bg-admin
                                                @elseif($rev->status === 'Proses Revisi')
                                                    bg-warning
                                                @elseif ($rev->status === 'Expired')
                                                    bg-danger
                                                @else
                                                    bg-light text-dark
                                                @endif
                                                ">{{$rev->status}}</span>
                                            </td>
                                            <td>
                                                <a href="{{route('document_revision.show-file',['filename' => $rev->file_path])}}" target="blank">Download</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Kedua -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4 border-bottom">
                        <i class="fa fa-file me-2"></i> File Dokumen
                    </h5>
                    <div class="d-flex mb-1">
                        <a href="{{route('document_revision.show-file',['filename' => $document->currentRevision->latestRevision($document->id)->file_path ])}}" class="btn btn-admin d-flex align-items-center ms-2" target="blank">
                            <i class="fa fa-file-alt me-2"></i> Unduh
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Ketiga -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">
                        <i class="fa fa-file-contract me-2"></i> Dokumen Bertanda Tangan
                    </h5>
                    <form action="{{route('document_approval.update',['documentRevision' => $documentRevision->id])}}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="Disetujui">
                      <div class="mb-3">
                          <input class="form-control" type="file" id="formFile" name="file" required accept=".pdf, .docx, .pptx">
                      </div>
                      <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-admin w-100" value="Kirim File & Approve"></input>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
