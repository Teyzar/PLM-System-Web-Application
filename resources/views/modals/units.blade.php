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
                            <i class="fs-2 bi-sim px-1"></i>
                            Enter the unit's phone number:
                        </label>

                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="+639"
                            required>

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="text-danger" role="alert" id="p-message"></span>
                    </div>

                    <div class="modal-footer d-block">
                        <span id="processing" class="text-center d-flex justify-content-center text-dark fs-5"></span>
                        <div id="bar" class="progress h-100">
                            <div id="progress"
                                class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                role="progressbar" style="width: 0%" aria-valuenow="40" aria-valuemin="0"
                                aria-valuemax="100">
                                <span id="percent"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div id="steps-id" class="progresses">
                                <div id="start" class="steps border"><span id="spinner1"
                                        class="pt-1"></span></div> <span id="line1"
                                    class="line border"></span>
                                <div style="margin-top: 11%; position: absolute">
                                    <span>start</span>
                                </div>
                                <div id="controller" class="steps border"> <span id="spinner2"
                                        class="">2</span> </div> <span id="line2"
                                    class="line border"></span>
                                <div style="margin-top: 11%; position: absolute; padding-left: 30%">
                                    <span>controller</span>
                                </div>
                                <div id="message" class="steps border"> <span id="spinner3"
                                        class="">3</span> </div>
                                <div style="margin-top: 11%; position: absolute; padding-left: 65%;">
                                    <span>text</span>
                                </div>

                            </div>
                        </div>
                        <button id="submitbtn" type="submit" class="btn btn-warning float-end mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRemove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="exampleModalLabel">Remove Confirmation</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body fs-6 text-danger">
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
