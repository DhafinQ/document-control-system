@extends('layout.master')

@section('content')
    <div class="row">
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
                    <h5 class="card-title fw-semibold mb-4">Create New Document Revision</h5>
                    <form action="{{ route('document_revision.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="document_id" class="form-label">Document</label>
                            <select class="form-control" name="document_id" required>
                                @foreach ($documents as $document)
                                    <option value="{{ $document->id }}">{{ $document->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="revision_number" class="form-label">Revision Number</label>
                            <input type="number" name="revision_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="revised_by" class="form-label">Revised By</label>
                            <select class="form-control" name="revised_by" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="Draft">Draft</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="file_path" class="form-label">Upload File</label>
                            <input type="file" name="file_path" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Edit</label>
                            <textarea name="reason" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Revision</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
