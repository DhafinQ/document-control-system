@extends("layouts.layout_admin")

@section("title", "Document")

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table class="table table-striped" id="myTable"  >
                    <thead> 
                        <tr>
                            <th>Document Title</th>
                            <th>Reviser</th>
                            <th>No. Rev</th>
                            <th>Action</th>
                            <th>Performed By</th>
                            <th>Time</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentHistories as $history)
                        <tr>
                            <td>{{$history->document->title}}</td>
                            <td>{{$history->revision->reviser->name}}</td>
                            <td>{{$history->revision->revision_number}}</td>
                            <td>
                                <span class="badge
                                @if ($history->action === 'Created')
                                    bg-primary
                                @elseif ($history->action === 'Revised')
                                    bg-warning
                                @elseif ($history->action === 'Approved')
                                    bg-success
                                @elseif ($history->action === 'Rejected')
                                    bg-danger
                                @endif
                                ">
                                    {{ $history->action }}
                                </span>
                            </td>
                            <td>{{$history->performer->name}}</td>
                            <td>{{ \Carbon\Carbon::parse($history->created_at)->format('H:i:s-d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('document_histories.show', $history) }}"
                                    class="btn btn-sm btn-admin">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection