@extends('layouts.layout_admin')

@section('title', 'Detail Document')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
<style>
    li {
        list-style: none;
    }

    .stepper {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .stepper>li {
        display: flex;
        align-items: center;
        width: 100%;
        text-align: center;
        flex-direction: column;
        position: relative;
        color: #6b7280;
    }

    .stepper>li::after {
        content: "";
        background: #f3f4f6;
        position: absolute;
        top: 20px;
        left: 50%;
        right: -50%;
        height: 4px;
        display: block;
        z-index: 1;
        transition: background-color 0.3s ease;
    }

    .stepper>li.active::after {
        background-color: #15d1c2;
    }

    .stepper>li:last-child::after {
        display: none;
    }

    .stepper .icon {
        width: 50px;
        height: 50px;
        background-color: #f3f4f6;
        border-radius: 100%;
        color: #6b7280;
        margin: 0 auto 10px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
    }

    .stepper .icon i {
        font-size: 1.5rem;
    }

    .stepper .active,
    .stepper .active .icon,
    .stepper .complete {
        color: #04403b;
    }

    .stepper .active .icon,
    .stepper .complete .icon,
    .stepper .complete::after {
        background-color: #15d1c2;
    }



    .stepper .complete .icon .bi::before {
        content: "\f272";
        color: #1c64f2;
    }
</style>
@section('content')
    @php
        $is_active = ($document->currentRevision->latestRevision($document->id)->status === 'Disetujui') && $document->is_active;
        $currentStatus = $document->currentRevision->latestRevision($document->id)->status;
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Tracking Card -->
                @can('view-revisions')
                @if ($document->currentRevision->checkUploaderRoles())
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4 border-bottom">
                                <i class="fa fa-file me-2"></i> Tracking Dokumen
                            </h5>
                            <div class="container">
                                <ul class="stepper">
                                    <li class="@if (in_array($document->currentRevision->latestRevision($document->id)->status, ['Draft', 'Disetujui', 'Expired','Proses Revisi'])) active @endif">
                                        <span class="icon"><i class="bi bi-archive"></i></i></span>
                                        <span class="fw-semibold">Dokumen Dibuat</span>
                                        <small>{{$document->currentRevision->created_at->format('d-m-Y')}}</small>
                                    </li>
                                    <li class="@if ($document->currentRevision->acc_format) active @endif">
                                        <span class="icon"><i class="bi bi-clipboard-pulse"></i></i></span>
                                        <span class="fw-semibold">Pengecekan Format</span>
                                        <small>{{empty($document->currentRevision->accFormat()) ? '-' : $document->currentRevision->created_at->format('d-m-Y')}}</small>
                                    </li>
                                    <li class="@if ($document->currentRevision->acc_format && $document->currentRevision->acc_content) active @endif">
                                        <span class="icon"><i class="bi bi-file-earmark-break"></i></span>
                                        <span class="fw-semibold">Pengecekan Konten</span>
                                        <small>{{empty($document->currentRevision->accContent()) ? '-' : $document->currentRevision->created_at->format('d-m-Y')}}</small>
                                    </li>
                                    <li class="@if ($document->is_active || $document->currentRevision->latestRevision($document->id)->status === 'Expired') active @endif">
                                        <span class="icon"><i class="bi bi-file-earmark-check"></i></span>
                                        <span class="fw-semibold">Dokumen Disetujui</span>
                                        <small>{{empty($document->currentRevision->accKepalaPuskesmas()) ? '-' : $document->currentRevision->created_at->format('d-m-Y')}}</small>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                @endif
                @endcan

                <!-- Card Pertama -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title fw-semibold mb-4">
                                    <i class="fa fa-info-circle me-2"></i> Detail Dokumen
                                </h5>

                                @if (!$is_active)
                                    @if ($document->currentRevision->latestRevision($document->id)->status === 'Proses Revisi')
                                        <div class="bg-warning-subtle p-2 rounded">
                                            <p class="me-2">Dokumen ini sedang dalam proses revisi.</p>
                                        </div>
                                    @else
                                        <div class="bg-danger-subtle p-2 rounded d-flex">
                                            <p class="me-2">Dokumen ini sudah tidak berlaku dan diganti dengan dokumen
                                                lain.</p>
                                            <a
                                                href="{{ route('documents.show', ['document' => $document->currentRevision->document->id]) }}">
                                                <u>Lihat dokumen terbaru</u>
                                            </a>
                                        </div>
                                    @endif
                                @endif

                                <div class="table-responsive mt-4">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Nomor Dokumen</th>
                                                <td>{{ $document->code }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Judul</th>
                                                <td>{{ $document->title }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kategori</th>
                                                <td>{{ $document->category->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td
                                                    class="badge p-2 m-3
                                            @if ($is_active) bg-admin
                                            @elseif($document->currentRevision->latestRevision($document->id)->status === 'Proses Revisi')
                                                bg-warning
                                            @else
                                                bg-danger @endif
                                            ">
                                                    {{ $document->currentRevision->latestRevision($document->id)->status === 'Disetujui' && $document->is_active ? 'Disetujui' : ($document->currentRevision->latestRevision($document->id)->status == 'Proses Revisi' ? 'Proses Revisi' : 'Expired') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Pembuat</th>
                                                <td>{{ $document->uploader->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Deskripsi</th>
                                                <td>{{ $document->currentRevision->latestRevision($document->id)->description }}
                                                </td>
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
                                    @if ($rightRole)
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($document->revisions->sortByDesc('created_at') as $rev)
                                                        <tr>
                                                            <td>{{ $rev->revision_number }}</td>
                                                            <td>{{ $rev->reviser->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($rev->created_at)->format('H:i:s-d/m/Y') }}
                                                            </td>
                                                            <td><span
                                                                    class="badge p-2
                                                @if ($rev->status === 'Disetujui') bg-admin
                                                @elseif($rev->status === 'Proses Revisi')
                                                    bg-warning
                                                @elseif ($rev->status === 'Expired')
                                                    bg-danger @endif
                                                ">{{ $rev->status }}</span>
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


            <div class="col-md-4">
                <!-- Card kedua -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4 border-bottom">
                            <i class="fa fa-file me-2"></i> File Dokumen
                        </h5>


                        <h4 class="fw-bold mb-3">{{ $document->title }}</h4>
                        <div class="d-flex mb-1">
                            @canany(['edit-documents', 'edit-revisions'])
                            @if (in_array($document->currentRevision->latestRevision($document->id)->status, ['Disetujui', 'Draft', 'Pengajuan Revisi']))
                                
                            <a href="{{ route('document_revision.edit', $document->currentRevision) }}"
                                class="btn btn-approver d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12h-1v5h1" />
                                    <path d="M14 12h1v5h-1" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                </svg>
                                Perbarui
                            </a>
                            @endif
                            @endcanany
                            <a href="{{ route('document_revision.show-file', ['filename' => $document->currentRevision->latestRevision($document->id)->file_path]) }}"
                                class="btn {{ $is_active ? 'btn-admin' : 'btn-danger' }} d-flex align-items-center ms-2"
                                target="blank">
                                <i class="fa {{ $is_active ? 'fa-file-alt' : 'fa-triangle-exclamation' }} me-2"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card ketiga -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">
                            <i class="fa fa-comment-dots me-2"></i> Status Dokumen
                        </h5>

                        @if (!$is_active && $document->currentRevision->latestRevision($document->id)->status !== 'Proses Revisi')
                            <div class="container">
                                <div class="d-flex flex-column">

                                    <div class=" p-2  mb-2 fw-bolder" style=" background-color: #343a4012;padding: 15px;">
                                        Diubah Dengan:
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <a
                                                href="{{ route('documents.show', ['document' => $document->currentRevision->document->id]) }}">{{ $document->currentRevision->document->title }}</a>
                                        </li>
                                    </ul>
                                    <div class="p-2">

                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="container mt-2">
                            <div class="d-flex flex-column">
                                <div class=" p-2  mb-2 fw-bolder" style=" background-color: #343a4012;padding: 15px;">
                                    Mengubah:
                                </div>

                                <div class="p-2">
                                    <ul class="list-group">
                                        @foreach ($document->currentRevision->latestRevision($document->id)->revisedDocument() as $doc)
                                            <li class="list-group-item">
                                                <a
                                                    href="{{ route('documents.show', ['document' => $doc->id]) }}">{{ $doc->title }}</a>
                                            </li>
                                        @endforeach
                                        @if (count($document->currentRevision->latestRevision($document->id)->revisedDocument()) == 0)
                                            <li class="list-group-item">-</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
