@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <h5 class="card-title fw-semibold mb-4">Tambah Dokumen</h5>
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3">
                    <label for="uploaded_by" class="form-label">Uploaded By</label>
                <input type="hidden" name="uploaded_by" value="{{ auth()->id() }}">
            </div>
                <div class="mb-3">
                    <label for="file_path" class="form-label">File Dokumen</label>
                    <input type="file" name="file_path" accept=".pdf,.doc,.docx,.ppt,.pptx" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Alasan</label>
                    <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
