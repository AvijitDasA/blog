@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <h2>Create Role</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Something went wrong.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Role Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter role name">
                    </div>
                    @if(isset($rolePermission ))
                        <div class="col-md-3 mb-2">
                            <div class="checkbox">
                            <label for="checkall">
                                <input value="" type="checkbox" id="checkall">
                                <h5 class="ms-auto text-primary" style="font-weight: bold;">Check All</h5>
                            </label>
                            </div>
                        </div>
                        @foreach ($rolePermission as $permissions)
                        <div class="col-md-3 mb-2">
                            <div class="checkbox">
                                <label for="permissions{{$permissions->id}}">
                                <input name="permissions[]" value="{{$permissions->id}}" type="checkbox" class="subcheck" id="permissions{{$permissions->id}}" >
                                {{$permissions->name}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                    <a class="btn btn-secondary mt-2" href="{{ route('roles.index') }}">Back</a>
                </form>
            </div>
        </div>
    </div>
 </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkAll = document.getElementById("checkall");
    const subchecks = document.querySelectorAll(".subcheck");

    // toggle all subchecks
    checkAll.addEventListener("change", function () {
        subchecks.forEach(chk => chk.checked = this.checked);
    });

    // if all subchecks are checked, auto-check "Check All"
    subchecks.forEach(chk => {
        chk.addEventListener("change", function () {
            checkAll.checked = [...subchecks].every(c => c.checked);
        });
    });
});
</script>



@endsection

