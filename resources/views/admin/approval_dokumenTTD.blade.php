@extends("layouts.layout_admin")

@section("title", "Detail Document")

@section("content")
@php
    $is_active = $document->currentRevision->status === 'Disetujui' && $document->is_active;
@endphp
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
                                            <td class="badge p-2 m-3
                                            @if ($is_active)
                                                bg-admin
                                            @elseif($document->currentRevision->status === 'Proses Revisi')
                                                bg-warning
                                            @else
                                                bg-danger
                                            @endif
                                            ">
                                                {{$document->currentRevision->status === 'Disetujui' && $document->is_active ? 'Disetujui'  : ($document->currentRevision->status == 'Proses Revisi' ? 'Proses Revisi' : 'Expired')}}
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
                            @php
                                $reviserRole = $document->uploader->roles->pluck('id');
                                $userRoles = auth()->user()->roles->pluck('id');
                                $rightRole = $reviserRole->intersect($userRoles)->isNotEmpty();
                            @endphp
                            @if($rightRole)
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
                            @endif
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
                    <h4 class="fw-bold mb-3">{{$document->title}}</h4>
                    <div class="d-flex mb-1">
                        @if ($is_active)
                        @canany(['edit-documents','edit-revisions'])
                        <a href="{{ route('document_revision.edit', $document->currentRevision) }}" class="btn btn-approver d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12h-1v5h1" />
                                <path d="M14 12h1v5h-1" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            </svg>
                            Perbarui
                        </a>
                        @endcanany
                        <a href="{{route('document_revision.show-file',['filename' => $document->currentRevision->latestRevision($document->id)->file_path ])}}" class="btn btn-admin d-flex align-items-center ms-2" target="blank">
                            <i class="fa fa-file-alt me-2"></i> Unduh
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Card Ketiga -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">
                        <i class="fa fa-file-contract me-2"></i> Dokumen Bertanda Tangan
                    </h5>
                    <div class="mb-3">
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
