@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Dokumen</h5>
            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $document->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $document->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="file_path" class="form-label">File Dokumen</label>
                    <input type="file" name="file_path[]" id="file_path" class="form-control" multiple>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $document->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Alasan</label>
                    <textarea name="reason" id="reason" class="form-control" rows="4" required>{{ $document->reason }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
