@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'users'
])
@section('content')
    <div class="content">
    <!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ $msg }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    <!-- End -->
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('new.user') }}" title="Add {{ $data['page'] }}" class="btn btn-sm btn-primary">Add {{ $data['page'] }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <!-- Pagination section -->
                        <div class="text-end">
                            @include('subviews.pagination', ['rows' => $rows])
                        </div>
                        <!-- End of pagination section -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Usergroup</th>
                                        <th scope="col">Creation Date</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <?php
                                $ctr = $rows->firstItem();
                                 ?>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    <td> {{ $ctr++ }} </td>
                                    <td>{{ $row->full_name }}</td>
                                    <td>{{ $row->u_email }}</td>
                                    <td>{{ $row->Usergroup->ug_name }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                        @if($row->u_enabled == 0)
                                            <a class="btn btn-success btn-sm row-open-btn" href="{{ route('user.enable', ['id' => $row->id]) }}" title="Enable"><i class="fa fa-check-circle-o"></i></a>
                                        @else
                                            <a class="btn btn-warning btn-sm row-open-btn" href="{{ route('user.disable', ['id' => $row->id]) }}" title="Disable"><i class="fa fa-ban"></i></a>
                                        @endif
                                        <a class="btn btn-info btn-sm row-edit-btn" href="{{ route('user.edit', ['id' => $row->id]) }}" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('user.delete', ['id' => $row->id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if ($rows->isEmpty())
				            <h3 class="bg-light text-center p-4">No Items Found</h3>
			                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        
    </script>
@endpush