<div class="modal fade" id="RemoveIncident" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                Are you sure you want to remove this Incident?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <form id="incident-form" action="" method="POST">
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

<div class="modal fade pt-5" id="modalEditInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoID"></h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateInfo" action="" method="POST">
                    @csrf
                    <select id="select-title" class="form-control mb-2" data-width="10%" data-toggle="select2"
                        name="title" required>
                        <option value="" class="text-scondary fw-bolder" id="default"></option>
                        <option value="investigating">Investigating</option>
                        <option value="update">Update</option>
                    </select>
                    <textarea id="description" type="text" name="description" class="form-control d-flex" rows="5" required></textarea>
                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <button id="editinfobtn" type="submit" class="btn btn-info w-75">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pt-5" id="modalAddInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incidentID"></h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddInfo" action="" method="POST">
                    @csrf
                    <select id="title" class="form-control mb-2" data-toggle="select2" name="title" required>
                        <option value="" class="text-scondary fw-bolder">Title</option>
                        <option value="investigating">Investigating</option>
                        <option value="update">Update</option>
                    </select>
                    <textarea id="description" name="description" class="form-control" rows="5"
                        placeholder="Enter some brief description about the report" required></textarea>
                    <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                        <button id="addinfobtn" type="submit" class="btn btn-success w-75">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="map-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-body">
                <div id="map" style="height: calc(100vh - 100px);"></div>
                <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&v=beta&libraries=visualization"
                                async>
                </script>
            </div>
        </div>
    </div>
</div>
