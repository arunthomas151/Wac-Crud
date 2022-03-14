@extends('layouts.master')
@section('css')
    <style>
        .tb_row {
            height: 10px;
        }

    </style>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6 card-header">
                            <h2 class="m-0">Employees</h2>
                        </div>
                        <div class="col-md-6 card-header">
                            <a href="{{route('employee.create')}}" class="btn btn-primary float-right">Add Employee</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="employees" class="display">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Designation</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            @endsection
            @section('js')
                <script>
                    // Datatable Ajax
                    $(function () {
                        var table = $('#employees').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('employee.datatable') }}",
                            columns: [
                                {data: 'id', name: 'id', class: 'tb_row'},
                                {data: 'name', name: 'name', class: 'tb_row'},
                                {data: 'email', name: 'email', class: 'tb_row'},
                                {data: 'designation', name: 'designation', class: 'tb_row'},
                                {
                                    "targets": -1,
                                    "data": "id",
                                    "className": "center tb_row",
                                    "render": function (data, type, row, meta) {
                                        return '<button name="id" id=' + data + ' value="Edit" class="btn btn-danger-outline fa fa-pencil text-green update_record" style="margin:10%" data-toggle="modal" data-target="#employee_update_modal"> Edit</button><button id=' + data + ' value="Delete" class="btn btn-danger-outline  delete_record fa fa-trash text-danger" style="margin:10%"> Delete</button>'
                                    }
                                }
                            ]
                        });
                    });

                    // DELETE RECORD
                    $(document).on('click', '.delete_record', function () {
                        $.ajax({
                            type: "post",
                            url: "{{ route('employee.delete') }}",
                            data: {
                                'id': this.id,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response.status == 201) {
                                    $('#employees').DataTable().ajax.reload();
                                    toastr.success(response.message);
                                }
                            },
                            error: function (response) {
                                $.each(response.responseJSON.errors, function (index, item) {
                                    toastr.error(item[0]);
                                });
                            }
                        });
                    });

                    //    Update Modal Form Values
                    $(document).on('click', '.update_record', function () {
                        $.ajax({
                            type: "post",
                            url: "{{ route('employee.details') }}",
                            data: {
                                'id': this.id,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (res) {
                                $('#id').val(res.id);
                                $('#name').val(res.name);
                                $('#email').val(res.email);
                                $('#designation').val(res.designation);
                                $('#employee_update_modal').modal('show');
                            }
                        });
                    });

                    // Update Employee AJAX
                    $('#update_employee').on('click', function () {
                        var formData = new FormData($('#update_form')[0]);
                        formData.append("_token", '{{csrf_token()}}');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('employee.update') }}",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                if (response.status == 201) {
                                    console.log(response.message);
                                    toastr.success(response.message);
                                    document.getElementById("update_form").reset();
                                    $('#modal_close').click();
                                }
                            },
                            error: function (response) {
                                $.each(response.responseJSON.errors, function (index, item) {
                                    toastr.error(item[0]);
                                });
                            }
                        });
                    });

                    $('.modal_close').on('click', function () {
                        $('#employee_update_modal').modal('hide');

                    });

                </script>
            @endsection()

            {{--           ------------- Employee Modal --------------                   --}}
            <div class="modal fade" id="employee_update_modal" tabindex="-1" role="dialog" data-backdrop="static"
                 aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_title">Update Employee</h5>
                            <button type="button" class="close modal_close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="update_employee_form" id="update_form" enctype="multipart/form-data">
                                <h2>Employee Details</h2>
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <label>Employee Name</label>
                                    <input type="text" required class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Employee Email</label>
                                    <input type="text" required class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Employee Image</label>
                                    <input type="file" required class="form-control" id="profile_image"
                                           name="profile_image">
                                </div>
                                <div class="form-group">
                                    <label>Employee Designation</label>
                                    <select type="text" required class="form-control" id="designation"
                                            name="designation">
                                        <option value="" selected disabled>Select One</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger modal_close" id="modal_close" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="update_employee">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>