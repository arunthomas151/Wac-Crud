@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="card card-secondary ">
            <div class="card-header">
                <h3 class="card-title">Add Employee</h3>
            </div>
            <form id="add_employee_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <select class="form-control" name="designation" id="designation">
                            @foreach($designations as $designation)
                                <option value="{{$designation->id}}">{{ $designation->name }}</option>
                            @endforeach
                        </select>
                        @error('designation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input class="form-control" type="file" name="profile_image" id="profile_image"
                               accept=".jpg, .jpeg, .png, .img"/>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="button" id="add_employee" class="btn btn-primary float-right mt-20">Add</button>
                    <a href="{{route('dashboard')}}">
                        <button type="button" id="cancel" class="btn btn-danger float-right mr-2">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script>
        // Add Employee AJAX
        $('#add_employee').on('click', function () {
            var formData = new FormData($('#add_employee_form')[0]);
            formData.append("_token", '{{csrf_token()}}');
            $.ajax({
                type: "POST",
                url: "{{ route('employee.store') }}",
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status == 201) {
                        toastr.success(response.message);
                        console.log(response.message);

                        document.getElementById("add_employee_form").reset();
                    }
                },
                error: function (response) {
                    $.each(response.responseJSON.errors, function (index, item) {
                        toastr.error(item[0]);
                    });
                }
            });
        });
    </script>
@endsection