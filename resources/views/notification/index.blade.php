@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'notification'
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
                    <div class="card-header border-0 text-light" style="background-color:rgb(124, 124, 124);">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $data['page'] }}</h3>
                            </div>
                            <div class="col-4">
                                {{-- <div class="pull-right">
                                    <a class="btn btn-success btn-sm" id="" href="" name="download-list-btn" class="print-download-btn pr" title="Download List"><span class="fa fa-floppy-o"></span> Download</a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Search engine section -->
                        <div class="mb-1 position-relative">
                            <form class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ url()->current() }}">
                            @csrf
                                <div class="col-md-2">
                                    <label class="text-light mr-2" for="date_start">Start Date:</label>
                                    <div class="input-group">
                                        <input class="form-control date_start" placeholder="(from)" autocomplete="off" name="date_start" id="date_start" maxlength=""  type="text" value="{{ old('date_start', $startDate) }}">
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-white">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-light mr-2" for="date_end">End Date:</label>
                                    <div class="input-group">
                                        <input class="form-control date_end" placeholder="(To)" autocomplete="off" name="date_end" id="date_end" maxlength=""  type="text" value="{{ old('date_end', $endDate) }}">
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-white">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2 dd">
                                        <label class="form-label fw-bold text-light" for="not_type_id">Notification Type</label>
                                        <select class="form-control @error('not_type_id') is-invalid @enderror" name="not_type_id" id="not_type_id">
                                            <option value="">All</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->not_type_id }}" >{{ $type->not_type_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@error('not_type_id') {{ $errors->first('not_type_id') }} @enderror</div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <label class="text-light mr-2" for="date_end">Search</label>
                                    <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Search" name="search" id="search" maxlength="255" value="{{ old('search', $search) }}">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <label class="text-light mr-2" for="date_end"></label>
                                    <div class="input-group">
                                        <input class="btn btn-primary btn-sm" type="submit" name="search-btn" id="search-btn" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End of search engine section -->
                    </div>
                    <div class="card-body ">   
                        <!-- Pagination section -->
                            <div class="text-right">
                                @include('subviews.pagination', ['rows' => $rows])
                            </div>
                        <!-- End of pagination section -->
                        <hr>
                        <form action="{{ route('mark-selected-as-read') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="1%">
                                            <input type="checkbox" id="mark-all-checkbox">
                                        </th>
                                        <th scope="col"><button type="submit" class="btn btn-secondary btn-sm mark-as-read-button">Mark as Read</button></th>
                                        <th scope="col">#</th>
                                        <th scope="col" width="10%">Notification Date</th>
                                        <th scope="col" width="30%">Message</th>
                                        <th scope="col" width="10%">Notification Type</th>
                                        <th width="30%" scope="col">Product</th>
                                        <th scope="15">Product Owner</th>
                                    </tr>
                                </thead>
                                <?php
                                    $ctr = $rows->firstItem();
                                ?>
                                <tbody>
                                @foreach ($rows as $row)
                                    <tr class="{{ $row->read_at ? 'read-notification' : 'unread-notification' }}">
                                        <td>
                                            <input type="checkbox" class="notification-checkbox" name="notification_id[]" value="{{ $row->not_id }}">
                                        </td>
                                        <td>
                                        @if (!$row->read_at)
                                            <a href="{{ route('mark-single-as-read', ['notification' => $row]) }}" class="btn btn-secondary btn-sm mark-as-read-button">Mark as Read</a>
                                        @endif
                                        </td>
                                        <td>{{ $ctr++ }}</td>
                                        <td>{{ date('m-d-y', strtotime($row->created_at)) }}</td>
                                        <td>{{ $row->not_message }}</td>
                                        <td>{{ $row->type->not_type_name }}</td>
                                        <td><a href="{{ route('product.view', ['id' => $row->prod_id]) }}" title="Edit">{{ $row->product->prod_description }}</a></td>
                                        <td>{{ $row->product->owner->prod_owner_name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                            <hr>
                            @if ($rows->isEmpty())
                                <h3 class="bg-light text-center p-4">No Items Found</h3>
                            @endif
                        </div>                                        
                        <!-- Pagination section -->
                        <div class="text-right">
                            @include('subviews.pagination', ['rows' => $rows])
                        </div>
                        <!-- End of pagination section -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#mark-all-checkbox').click(function () {
            const isChecked = $(this).prop('checked');
            $('.notification-checkbox').prop('checked', isChecked);
            });

            $('.date_start').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });

            $('.date_end').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });
    </script>
@endpush