<div class="modal fade pt-5" id="store-unit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-4 text-center" id="exampleModalLabel">Register unit</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('units') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="phone_number"><i class="fs-2 bi bi-sim px-1"></i>Mobile No.</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                            placeholder="#" />
                    </div>

                    <div class="modal-footer d-block">
                        <button type="submit" class="btn btn-warning float-end">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
