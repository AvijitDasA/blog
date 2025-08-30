@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg p-3">
                <h2>Edit Role</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Something went wrong.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Role Name:</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control" placeholder="Enter role name">
                    </div>

                    @if(isset($permissions))
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" id="checkall" class="form-check-input">
                                <label class="form-check-label text-primary fw-bold" for="checkall">
                                    Check All
                                </label>
                            </div>
                        </div>

                        @foreach ($permissions as $perm)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input
                                        name="permissions[]"
                                        value="{{ $perm->id }}"
                                        type="checkbox"
                                        class="form-check-input subcheck"
                                        id="permissions{{ $perm->id }}"
                                        {{ in_array($perm->id, $rolesAllPermission) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="permissions{{ $perm->id }}">
                                        {{ $perm->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <button type="submit" class="btn btn-primary mt-2">Update</button>
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

    // Toggle all subchecks
    checkAll.addEventListener("change", function () {
        subchecks.forEach(chk => chk.checked = this.checked);
    });

    // If all subchecks are checked, auto-check "Check All"
    function updateCheckAll() {
        checkAll.checked = [...subchecks].every(c => c.checked);
    }

    subchecks.forEach(chk => {
        chk.addEventListener("change", updateCheckAll);
    });

    // Initial state when page loads
    updateCheckAll();
});
</script>
@endsection
