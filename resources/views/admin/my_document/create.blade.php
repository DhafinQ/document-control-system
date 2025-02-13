@extends('layouts.layout_admin')

@section('title', 'Document')

@section('content')

    <div class="container-fluid">
        <div class="container-fluid">
            <!-- Form Card Utama Kiri -->
            <form action="{{ route('document_revision.store') }}" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="row d-flex">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <label id="labelToChange" class="form-label">Kategori Dokumen</label>

                                <h5 class="card-title fw-semibold mb-4">Perbarui Dokumen </h5>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Judul<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ old('title') ?? '' }}"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Kategori Dokumen<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="kategori_select" name="category_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') ? 'selected' : '' }}>{{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">ID Dokumen<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="code" value="{{ old('code') ?? '' }}"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dokumen" class="form-label">Berkas Dokumen<span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="file_path" class="form-control" id="dokumen"
                                            aria-describedby="dokumenHelp" accept=".pdf,.doc,.docx,.txt">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Deskripsi<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="2">{{ old('description') ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Alasan<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" id="exampleFormControlTextarea1" rows="2">{{ old('reason') ?? '' }}</textarea>
                                </div>
                                <div class="d-flex justify-content-center gap-2" style="width: 400px; margin: auto;">
                                    <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                                    <button type="submit" class="btn btn-admin">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Status Kecil Kanan -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold mb-4">Status Dokumen</h5>
                                <div class="col-md-12">
                                    <div class="container">
                                        <div class="d-flex flex-column">
                                            <div class=" p-2  fw-bolder"
                                                style=" background-color: #343a4012;padding: 15px;">
                                                Mengubah:
                                            </div>
                                            <div class="p-2">
                                                <select id="my-select" name="rev[]" multiple="multiple"
                                                    class="form-control"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <input type="hidden" id="oldSelections"
                value="{{ json_encode(old('rev', isset($documentRevision) ? $documentRevision->revised_doc : [])) }}">
            <input type="hidden" id="selectedOption"
                value="{{ isset($documentRevision) && !is_null($documentRevision->id) ? $documentRevision->document_id : '' }}">
        </div>
    </div>
    </div>
@section('customJS')
    {{-- Select 2 SearchBox --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/selectrevision.js') }}"></script>
@endsection
@endsection
