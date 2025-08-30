@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Roles</h2>
                    <a class="btn btn-success" href="{{ route('roles.create') }}">Create Role</a>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif

                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th width="200px">Action</th>
                    </tr>
                    @if($roles->isEmpty())

                        <td colspan="7">
                        <div class="alert alert-danger text-sm-center">{!!trans('pages.NoRecrds')!!}</div>
                        </td>


                    @endif
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>

                            @foreach($role->permissions  as $permission)
                            <span style="
                                display: inline-block;
                                font-size: 12px;
                                margin: 5px 0px;
                                margin-top: ;
                                margin-right: ;
                                margin-bottom: ;
                                margin-left: ;
                                padding: 2px 10px;
                                padding-top: ;
                                padding-right: ;
                                padding-bottom: ;
                                padding-left: ;
                                background: blueviolet;
                                color:#ffff;
                                border-radius: 15px; ">
                            {!!$permission->name!!}
                            </span>
                            @endforeach
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
