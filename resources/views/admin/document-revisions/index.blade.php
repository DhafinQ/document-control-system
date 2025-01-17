@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Document Revisions</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Document</th>
                        <th>Reviser</th>
                        <th>Revision Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revisions as $revision)
                    <tr>
                        <td>{{ $revision->document->title }}</td>
                        <td>{{ $revision->reviser->name }}</td>
                        <td>{{ $revision->revision_number }}</td>
                        <td>
                            <span class="badge {{ $revision->status === 'Disetujui' ? 'bg-success' : ($revision->status === 'Ditolak' ? 'bg-danger' : 'bg-secondary') }}">
                                {{ $revision->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('document_revision.show-file', $revision->file_path) }}" target="_blank" class="btn btn-sm btn-info">Lihat File</a>
                            <a href="{{ route('document_revision.edit', $revision) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No revisions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $revisions->links() }}
        </div>
    </div>
</div>
@endsection
