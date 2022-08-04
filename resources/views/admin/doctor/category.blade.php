@extends('admin/layouts/default')
@section('title')
<title>Category</title>
@stop
@section('inlinecss')

@stop
@section('content')
<style>
    .card-body nav
    {
        float: right;
    }
    .div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
    .data-table
    {
            width: -webkit-fill-available!important;
    }
</style>
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category</h3>
                        <div class="ml-auto pageheader-btn">

                            @can('Category Create')
								<a href="{{ route('category-doctor-create') }}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Category
								</a>
								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
                                </a>
                            @endcan
							</div>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Title</th>
                              <th width="200px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>

    <!-- View MODAL -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<!-- View CLOSED -->





</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var table = $('.data-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('category-doctor-list') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click','.viewDetail', function(){
                $('#viewDetail').modal('show');
                url = $(this).attr('data-url');
                $('#viewDetail').find('.modal-body').html('<p class="ploading"><i class="fa fa-spinner fa-spin"></i></p>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
                        $('#viewDetail').find('.modal-body').html(data);
                    }
                });
            });
            
            
            $(document).on('click','.deleteButton', function(){
                
                var con = confirm('Are You Sure Want to Delete This Record');
                if(con==true){
                    row = $(this).closest('tr');
                    url = $(this).attr('data-url');
    				var $this = $(this);
    				buttonLoading('loading', $this);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data){
    						row.remove();
                        }
                    });   
                }
				
            });



        });
    </script>
@stop
