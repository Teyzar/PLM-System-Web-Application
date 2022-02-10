<div class="modal fade pt-5" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-5 border-info">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Account Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('lineman') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-dark opacity-100">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror border-info"
                            id="name" name="name" placeholder="Name" required autocomplete="name" autofocus
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark opacity-100">Email Address</label>
                        <input id="email" type="text"
                            class="form-control @error('email') is-invalid @enderror border-info" id="email"
                            name="email" placeholder="Email" required autocomplete="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark opacity-100">Barangay</label>
                        <input type="text" class="form-control border-info" id="barangay" name="barangay"
                            placeholder="Barangay" required="" value="{{ old('barangay') }}">
                    </div>

                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <button type="submit" class="btn btn-warning w-75">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="form-id" action="" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modalSave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body fs-6 text-dark">
                    Are you sure you want to save changes?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-dark" onclick="">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade pt-5" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-5 border-yellow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input id="updatename" type="text"
                            class="form-control @error('updatename') is-invalid @enderror" name="updatename"
                            placeholder="Name" required autocomplete="updatename" autofocus
                            value="{{ old('updatename') }}">

                        @error('updatename')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="updatebarangay" name="updatebarangay"
                            placeholder="Barangay" required="" value="{{ old('updatebarangay') }}">
                    </div>

                    @error('updatebarangay')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input id="updateemail" type="text" class="form-control border-0" style="pointer-events: none"
                            name="updateemail" placeholder="Email" required autocomplete="email"
                            value="{{ old('updateemail') }}">
                    </div>
                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <a type="button" class="btn btn-dark w-75" data-bs-toggle="modal" data-bs-target="#modalSave">
                            {{ __('Save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body fs-6 text-danger">
                Are you sure you want to delete this account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <form id="delete-id" action="" method="POST">
                    @csrf

                    @method('delete')
                    <a type="submit" class="btn btn-danger" href="javascript:{}"
                        onclick="document.getElementById('delete-id').submit();">Yes</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modal-content" class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-3x text-dark"></i></h3>
                        <h4 class="text-center text-dark">Forgot password?</h4>
                        <div class="panel-body">
                            <form id="reset-id" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <span id="text-msg" class="fw-light d-flex justify-content-center">
                                    <input type="hidden" name="checkbox" value="0"><input class="stylebox"
                                        type="checkbox"
                                        onclick="this.previousSibling.value=1-this.previousSibling.value"> &nbsp; Please
                                    check to confirm email address.
                                </span>
                                <div class="form-group pt-3 justify-content-center">
                                    <div class="input-group">
                                        <i class="bi bi-envelope-check fs-2 pe-sm-2 text-black opacity-75 align-items-center"></i>&nbsp;
                                        <input id="resetEmail" name="resetEmail"
                                            class="form-control float-start border-0" type="email"
                                            style="pointer-events: none;">
                                    </div>
                                    <span id="errormsg"></span>
                                </div>
                                <div class="form-group">
                                    <button id="rstbtn" name="recover-submit"
                                        class="btn btn-lg btn-success btn-block mt-2 py-1" type="submit">Reset
                                        Password
                                    </button>
                                </div>
                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
