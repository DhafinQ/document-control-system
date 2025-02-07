@extends("layouts.layout_admin")

@section("title", "Notifications")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between mb-1">
                    <h4 class="card-title fw-semibold mb-3">Semua Notifikasi</h4>
                        @if (count(auth()->user()->unreadNotifications) > 0)
                        <form action="{{route('notifications.markAllRead')}}" method="post">
                            @csrf
                            <input type="hidden" name="index" value="1">
                        <button type="submit" class="btn btn-admin d-flex align-items-center">
                                Tandai semua telah dibaca
                        </button>
                        </form>
                           
                        @endif
                    </div>

                    <div class="table-responsive mt-4">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr>
                                    <td>{{$notification->data['message']}}</td>
                                    <td>
                                        <span>
                                            {{ \Carbon\Carbon::parse($notification->created_at)->format('H:i:s-d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if (!$notification->read_at)
                                            <form action="{{route('notification.markRead',['notification' => $notification->id])}}" method="post">
                                                @csrf
                                                <input type="hidden" name="index" value="1  ">
                                                <button type="submit" class="btn bg-admin text-white me-2" id="mark-read">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2"> <path d="M5 12l5 5l10 -10"></path> </svg> 
                                                </button>
                                            </form>
                                            @endif
                                            <a href="{{$notification->data['link']}}" class="btn text-white bg-approver">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2"> <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path> <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path> </svg> 
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
