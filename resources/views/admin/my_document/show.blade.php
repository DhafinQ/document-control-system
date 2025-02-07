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
    $is_active = ($documentRevision->status === 'Disetujui' && $documentRevision->document->is_active) || $documentRevision->status === 'Draft' || $documentRevision->status === 'Pengajuan Revisi';
@endphp
    <div class="container-fluid">
        <div class="row">
            <!-- Card Utama -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4 border-bottom">
                            <i class="fa fa-file me-2"></i> Tracking Dokumen
                        </h5>
                        <div class="container">
                            <ul class="stepper">
                                <li class="@if (in_array($documentRevision->latestRevision()->status, ['Draft', 'Disetujui', 'Expired','Proses Revisi'])) active @endif">
                                    <span class="icon"><i class="bi bi-archive"></i></i></span>
                                    <span class="fw-semibold text-sm">Dokumen Dibuat</span>
                                    <small>{{ in_array($documentRevision->latestRevision()->status, ['Draft', 'Disetujui', 'Expired','Proses Revisi']) ? $documentRevision->created_at->format('d-m-Y') : '-' }}</small>
                                </li>
                                <li class="@if ($documentRevision->latestRevision()->acc_format) active @endif">
                                    <span class="icon"><i class="bi bi-clipboard-pulse"></i></i></span>
                                    <span class="fw-semibold text-sm">Pengecekan Format</span>
                                    <small>{{ empty($documentRevision->latestRevision()->accFormat()) || !$documentRevision->latestRevision()->acc_format ? '-' : $documentRevision->latestRevision()->accFormat()->created_at->format('d-m-Y') }}</small>
                                </li>
                                <li class="@if ($documentRevision->latestRevision()->acc_format && $documentRevision->latestRevision()->acc_content) active @endif">
                                    <span class="icon"><i class="bi bi-file-earmark-break"></i></span>
                                    <span class="fw-semibold text-sm">Pengecekan Konten</span>
                                    <small>{{ empty($documentRevision->latestRevision()->accContent()) || !$documentRevision->latestRevision()->acc_format && !$documentRevision->latestRevision()->acc_content ? '-' : $documentRevision->latestRevision()->accContent()->created_at->format('d-m-Y') }}</small>
                                </li>
                                <li class="@if (
                                    ($documentRevision->latestRevision()->document->is_active) || $documentRevision->status == 'Expired') active @endif">
                                    <span class="icon"><i class="bi bi-file-earmark-check"></i></span>
                                    <span class="fw-semibold text-sm">Dokumen Disetujui</span>
                                    <small>{{ empty($documentRevision->latestRevision()->accKepalaPuskesmas()) ? '-' : $documentRevision->latestRevision()->accKepalaPuskesmas()->created_at->format('d-m-Y') }}</small>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title fw-semibold mb-4">
                                    Detail Dokumen
                                </h5>
                                @if (!$is_active)
                                    @if ($documentRevision->status === 'Proses Revisi')
                                        <div class="bg-warning-subtle p-2 rounded">
                                            <p class="me-2">Dokumen ini sedang dalam proses revisi.</p>
                                        </div>
                                    @else
                                        <div class="bg-danger-subtle p-2 rounded d-flex">
                                            <p class="me-2">Dokumen ini sudah tidak berlaku dan diganti dengan dokumen
                                                lain.</p>
                                            <a
                                                href="{{ route('document_revision.show', ['documentRevision' => $documentRevision->document->currentRevision->id]) }}">
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
                                                <td>{{ $documentRevision->document->code }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Judul</th>
                                                <td>{{ $documentRevision->document->title }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kategori</th>
                                                <td>{{ $documentRevision->document->category->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td
                                                    class="badge p-2 m-3
                                                @if ($documentRevision->latestRevision()->status === 'Draft') bg-light text-dark
                                                @elseif ($documentRevision->latestRevision()->status === 'Disetujui')
                                                    bg-success
                                                @elseif (
                                                    $documentRevision->latestRevision()->status === 'Pengajuan Revisi' ||
                                                        $documentRevision->latestRevision()->status === 'Proses Revisi')
                                                    bg-warning
                                                @elseif ($documentRevision->latestRevision()->status === 'Expired')
                                                    bg-danger @endif
                                                ">
                                                    {{ $documentRevision->latestRevision()->status }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Pembuat</th>
                                                <td>{{ $documentRevision->document->uploader->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Deskripsi</th>
                                                <td>{{ $documentRevision->latestRevision()->description }}
                                                </td>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documentRevision->document->revisions->sortByDesc('created_at') as $rev)
                                                    <tr>
                                                        <td>{{ $rev->revision_number }}</td>
                                                        <td>{{ $rev->reviser->name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($rev->created_at)->format('H:i:s-d/m/Y') }}
                                                        </td>
                                                        <td><span
                                                                class="badge p-2
                                                                @if ($rev->status === 'Disetujui') bg-admin
                                                                @elseif($rev->status === 'Proses Revisi' || $rev->status === 'Pengajuan Revisi')
                                                                    bg-warning
                                                                @elseif ($rev->status === 'Expired')
                                                                    bg-danger
                                                                @else
                                                                    bg-light text-dark @endif
                                                                ">{{ $rev->status }}</span>
                                                        </td>
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
                            @canany(['edit-documents', 'edit-revisions'])
                                @if (in_array($documentRevision->latestRevision()->status, ['Disetujui', 'Pengajuan Revisi']))
                                    <a href="{{ route('document_revision.edit', $documentRevision->id) }}"
                                        class="btn btn-approver d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                            <a href="{{ route('document_revision.show-file', ['filename' => $documentRevision->latestRevision()->file_path]) }}"
                                class="btn {{ in_array($documentRevision->latestRevision()->status,['Disetujui','Draft']) ? 'btn-admin' : 'btn-danger' }} d-flex align-items-center ms-2" target="blank">
                                    <i class="fa {{ in_array($documentRevision->latestRevision()->status,['Disetujui','Draft']) ? 'fa-file-alt' : 'fa-triangle-exclamation' }} me-2"></i> Unduh
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

                        <div class="container mt-2">
                            <div class="d-flex flex-column">
                                <div class=" p-2  mb-2 fw-bolder" style=" background-color: #343a4012;padding: 15px;">
                                    Mengubah:
                                </div>

                                <div class="p-2">
                                    <ul class="list-group">
                                        @foreach ($documentRevision->latestRevision()->revisedDocument() as $doc)
                                            <li class="list-group-item">
                                                <a
                                                    href="{{ route('document_revision.show', ['documentRevision' => $doc->currentRevision->latestRevision($doc->id)->id]) }}">{{ $doc->title }}</a>
                                            </li>
                                        @endforeach
                                        @if (count($documentRevision->latestRevision()->revisedDocument()) == 0)
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
