@extends('layouts.master')

@section('header', 'Edit Role')
@section('content')

    {{-- Message --}}

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Role</h5>
            <a href="{{ route('roles.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="rolesForm" enctype="multipart/form-data" method="post"
            action="{{ route('roles.update', $role->id) }}" novalidate>
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mt-3">
                        <strong>Name:</strong>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                            value="{{ old('name', $role->name) }}">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <strong>Permissions (A-Z):</strong>
                    <br />
                    {{-- "Check All" Checkbox --}}
                    <div class="form-group mb-3">
                        <label>
                            <input type="checkbox" id="checkAll"> Check All
                        </label>
                    </div>

                    {{-- Alphabetical Sections --}}
                    <div class="alphabetical-sections mt-3">
                        @foreach ($permissionGroups as $letter => $permissions)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ strtoupper($letter) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <label>
                                                    {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, ['class' => 'permission-checkbox']) }}
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- End Alphabetical Sections --}}
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </div>
        </form><!-- End Floating Labels Form -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAll');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

            checkAll.addEventListener('change', function() {
                permissionCheckboxes.forEach((checkbox) => {
                    checkbox.checked = this
                        .checked; // Set the checked property to match the state of 'checkAll'
                });
            });
        });
    </script>
@endsection
