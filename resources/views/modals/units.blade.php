<div class="modal fade pt-5" id="store-unit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="regUnit">Register unit</h5>
                <button id="close" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unit-form" action="{{ URL::to('units') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="phone_number">
                            <i class="mdi mdi-sim px-1"></i>
                            Enter the unit's phone number:
                        </label>
                        <div class="input-group input-group-merge">
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                placeholder="+639" required>

                            <button id="submitbtn" type="submit" class="input-group-text">
                                <i class="mdi mdi-send"></i>
                            </button>
                        </div>
                        {{-- <button id="submitbtn" type="submit" class="btn btn-warning float-end">Submit</button> --}}

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="text-danger" role="alert" id="p-message"></span>
                    </div>
                </form>

                <div class="modal-footer d-block text-center">
                    <div id="process" class="justify-content-center d-flex pt-0"></div>

                    <div class="justify-content-center d-flex">
                        <div id="steps-id" class="progresses">
                            <div id="start" class="steps border"><span id="spinner1" class=""><label
                                        class="text-muted">1</label></span></div> <span id="line1"
                                class="line border"></span>
                            <div id="controller" class="steps border"> <span id="spinner2"
                                    class=""><label class="text-muted">2</label></span> </div>
                            <span id="line2" class="line border"></span>
                            <div id="message" class="steps border"> <span id="spinner3" class=""><label
                                        class="text-muted">3</label></span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRemove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remove Confirmation</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this unit?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <form id="remove-id" action="" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="refreshModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header">
                <button id="close-btn" type="button" class="btn-close btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="process2" class="justify-content-center d-flex pt-0 mb-2"></div>
                <div class="justify-content-center d-flex mb-2">
                    <div id="steps-id2" class="progresses">
                        <div id="start2" class="steps border"><span id="s1" class=""><label
                                    class="text-muted">1</label></span></div> <span id="line-1"
                            class="line border"></span>
                        <div id="controller2" class="steps border"> <span id="s2" class=""><label
                                    class="text-muted">2</label></span> </div>
                        <span id="line-2" class="line border"></span>
                        <div id="message2" class="steps border"> <span id="s3" class=""><label
                                    class="text-muted">3</label></span> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
