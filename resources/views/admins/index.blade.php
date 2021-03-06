@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newAdminModal">Add new</button>
        </div>
    </div>

@stop

@section('content')
    <h1>Admins</h1>
    <input type="text" class="form-control" style="width: 25%;" placeholder="Search" />
    <br>
    <div class="panel">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <table class="table text-center table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php
                        $count = 0;
                    @endphp
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td>{{ $admin->user_first_name or '-' }}</td>
                            <td>{{ $admin->user_last_name or '-' }}</td>
                            <td>{{ $admin->user_email or '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAdminModal_{{ $admin->user_id }}">Delete</button>
                                </div>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAdminModal_{{ $admin->user_id }}">Update</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Update model  -->
                        <div id="updateAdminModal_{{ $admin->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="{{ route('admin.store') }}" id="updateAdmin_{{ $admin->user_id }}" method="post">
                                        <input type="hidden" name="type" value="store">
                                        <input type="hidden" name="user_id" value="{{ $admin->user_id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update admin : {{ $admin->user_first_name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="user_name">User name</label>
                                                    <input type="text" name="user_name" id="user_name" value="{{ $admin->user_name }}" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_first_name">First name</label>
                                                    <input type="text" name="user_first_name" value="{{ $admin->user_first_name }}" id="user_first_name" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_last_name">Last name</label>
                                                    <input type="text" name="user_last_name" value="{{ $admin->user_last_name }}" id="user_last_name" class="form-control" placeholder="Last name">
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_email">Email</label>
                                                    <input type="email" name="user_email" value="{{ $admin->user_email }}" id="user_email" class="form-control" placeholder="Email" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_contact_no">Contact</label>
                                                    <input type="number" name="user_contact_no" value="{{ $admin->user_contact_no }}" id="user_contact_no" class="form-control" placeholder="Contact no">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_password">Password</label>
                                                    <input type="password" name="user_password" value="{{ $admin->user_password_raw }}" id="user_password" class="form-control" placeholder="Password" required>
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_address">Address</label>
                                                    <input name="user_address" class="form-control" value="{{ $admin->user_address }}" id="user_address" placeholder="Address">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- Delete model  -->
                        <div id="deleteAdminModal_{{ $admin->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="{{ route('admin.destroy', $admin->user_id) }}" id="deleteAdmin_{{ $admin->user_id }}">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete admin : {{ $admin->user_first_name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p class="lead">Are you sure?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="newAdminModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ route('admin.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new admin</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_name">User name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_first_name">First name</label>
                                <input type="text" name="user_first_name" id="user_first_name" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_last_name">Last name</label>
                                <input type="text" name="user_last_name" id="user_last_name" class="form-control" placeholder="Last name">
                            </div>

                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_email">Email</label>
                                <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_contact_no">Contact</label>
                                <input type="number" name="user_contact_no" id="user_contact_no" class="form-control" placeholder="Contact no">
                            </div>
                            <div class="col-md-4">
                                <label for="user_password">Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password" required>
                            </div>

                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_address">Address</label>
                                <textarea name="user_address" class="form-control" id="user_address" placeholder="Address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop