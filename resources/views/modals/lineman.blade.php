<div class="modal fade pt-5" id="modalRegisterForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Account Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('lineman') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label opacity-100">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Name" autocomplete="name" autofocus value="{{ old('name') }}"
                            required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label opacity-100">Email Address</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="Email" autocomplete="email"
                            value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label opacity-100">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay"
                            value="{{ old('barangay') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label opacity-100">Contact Number</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="+639"
                            value="{{ old('contact_no') }}" required>

                        @if ($errors->has('contact_no'))
                            <div class="error text-danger">{{ $errors->first('contact_no') }}</div>
                        @endif
                    </div>

                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <button type="submit" class="btn btn-warning w-75">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="modalEditForm" action="" method="POST">
    @csrf
    @method('patch')

    <div class="modal fade pt-5" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            placeholder="Name" autocomplete="updatename" autofocus value="{{ old('updatename') }}"
                            required>

                        @error('updatename')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="updatebarangay" name="updatebarangay"
                            placeholder="Barangay" value="{{ old('updatebarangay') }}" required>

                        @error('updatebarangay')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="updatecontact_no" name="updatecontact_no"
                            placeholder="+639" value="{{ old('updatecontact_no') }}" required>

                        @error('updatecontact_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input id="updateemail" type="text" class="form-control border-0" style="pointer-events: none"
                            name="updateemail" placeholder="Email" autocomplete="email"
                            value="{{ old('updateemail') }}" required>
                    </div>

                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <a type="button" class="btn btn-dark w-75" onclick="openConfirmation()" data-bs-dismiss="modal"
                            aria-label="Close">
                            {{ __('Save') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openConfirmation() {
            $('#modalConfirm').modal('show');
        }
    </script>
    <div class="modal fade" id="modalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to save changes?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function closeModal() {
        $('#modalEdit').modal('hide');
    }
</script>

<div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <span>Are you sure you want to delete this account?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <form id="delete-id" action="" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">
                        Yes
                    </button>
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
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-3x"></i></h3>
                        <h4 class="text-center">Forgot password?</h4>
                        <div class="panel-body">
                            <form id="reset-id" action="" method="POST">
                                @csrf
                                <span id="text-msg" class="justify-content-center">
                                    <input type="hidden" name="checkbox" value="0"><input class="stylebox"
                                        type="checkbox"
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" style="width: 35px;
                                        height: 17px;"><span>Please
                                        check to confirm email address.</span>
                                </span>
                                <div class="form-group pt-3 justify-content-center">
                                    <div class="input-group">
                                        <i class="mdi mdi-email-check fs-2 pe-sm-1 align-items-center"></i>&nbsp;
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
