@extends('layout.master')

@section('content')
<div class="container">
    <h1>Document History Details</h1>

    <table class="table table-bordered mt-4">
        <tr>
            <th>Document Title</th>
            <td>{{ $documentHistory->document->title }}</td>
        </tr>
        <tr>
            <th>Reviser</th>
            <td>{{ $documentHistory->revision->reviser->name }}</td>
        </tr>
        <tr>
            <th>Revision Number</th>
            <td>{{ $documentHistory->revision->revision_number }}</td>
        </tr>
        <tr>
            <th>Action</th>
            <td>
                <span class="badge bg-{{ $documentHistory->action_color }}">
                    {{ $documentHistory->action }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Performed By</th>
            <td>{{ $documentHistory->performer->name }}</td>
        </tr>
        <tr>
            <th>Reason</th>
            <td>{{ $documentHistory->reason }}</td>
        </tr>
    </table>

    <a href="{{ route('document_histories.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
