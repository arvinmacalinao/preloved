@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'product-owner'
])

@section('content')
<div class="content">   
    <!-- This will display any message upon submission. -->
		@if(strlen($msg) > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close pull-right" data-bs-dismiss="alert" aria-label="Close">x</button>
            {{ $msg }}
        </div>
    @endif
    <!-- End -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="m-0">
                        <strong>Product Owner: </strong><span class="project-title">{{ $po->prod_owner_name }}</span><br>
                        <strong>Email: </strong><span class="project-title">{{ $po->prod_owner_email  }}</span><br>
                    </h4>
                    <div class="row align-items-center">
                        <div class="col-12 text-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('product.owner.lists') }}" title="Back"><span class="fa fa-caret-left"></span> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="flex-grow-1">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Products Owned') }}</h3>                
                                <!-- Pagination section -->
                                    <div class="text-end">
                                        @include('subviews.pagination', ['rows' => $rows])
                                    </div>
                                <!-- End of pagination section -->
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table text-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col" width="20%">Name</th>
                                                    <th scope="col" width="20%">Email</th>
                                                    <th scope="col" width="20%">Phone no.</th>
                                                    <th scope="col">Date Created</th>
                                                    <th scope="col">Encoder</th>
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
                                                {{-- <td>{{ $row->prod_owner_name }}</td>
                                                <td>{{ $row->prod_owner_email }}</td>
                                                <td>{{ $row->prod_owner_phone }}</td>
                                                <td>{{ $row->created_at }}</td>
                                                <td>{{ $row->encoder->name }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                    <a class="btn btn-primary btn-sm row-open-btn" href="{{ route('product.owner.view', ['id' => $row->prod_owner_id]) }}" title="View"><i class="fa fa-folder-open"></i></a>
                                                    <a class="btn btn-success btn-sm row-edit-btn" href="{{ route('product.owner.edit', ['id' => $row->prod_owner_id]) }}" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-danger btn-sm  row-delete-btn" href="{{ route('product.owner.delete', ['id' => $row->prod_owner_id]) }}" data-msg="Delete this item?" data-text="#{{ $ctr }}" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td> --}}
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
    </div>
</div>
@endsection

