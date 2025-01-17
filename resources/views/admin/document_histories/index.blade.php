@extends('layout.master')

@section('content')
<div class="container">
    <h1>Document Histories</h1>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Document Title</th>
                <th>Reviser</th>
                <th>Revision Number</th>
                <th>Action</th>
                <th>Performed By</th>
                <th>Reason</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentHistories as $history)
                <tr>
                    <td>{{ $history->document->title }}</td>
                    <td>{{ $history->revision->reviser->name }}</td>
                    <td>{{ $history->revision->revision_number }}</td>
                    <td>
                        <span class="badge bg-{{ $history->action_color }}">
                            {{ $history->action }}
                        </span>
                    </td>
                    <td>{{ $history->performer->name }}</td>
                    <td>{{ $history->reason }}</td>
                    <td>
                        <a href="{{ route('document_histories.show', $history) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
