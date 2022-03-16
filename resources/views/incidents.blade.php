@extends('layouts.app')

@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/incidents.css') }}"> --}}
@endsection

@section('content')
    <div class="container-fluid mt-2">
        <div class="row mb-2">
            <div class="col-sm-4">
                <a href="" class="btn btn-danger rounded-pill waves-effect waves-light mb-3" data-bs-toggle="modal"
                    data-bs-target="#con-close-modal"><i class="mdi mdi-plus"></i> Create
                    Project</a>
            </div>
        </div>
        <div class="row">
            <div class="row-lg-6">
                <div class="card project-box">
                    <div class="card-body shadow bg-light">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">View</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div> <!-- end dropdown -->
                        <!-- Title-->
                        <h4 class="mt-0"><a href="project-detail.html" class="text-dark">March 12, 2022</a></h4>
                        <div class="w-100"><hr></div>
                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small class="text-uppercase fw-bold">Resolved </small> - <mark>This incident has been resolved</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small class="badge bg-soft-success text-secondary mb-3">March, 12 2022 10:25am</small></p>

                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small class="text-uppercase fw-bold">Investigating </small> - <mark>We are currently investigating a latency message and messages send issued for some requests</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small class="badge bg-soft-success text-secondary mb-3">March, 12 2022 8:15am</small></p>

                    </div>
                </div> <!-- end card box-->
            </div><!-- end col-->
        </div>
    </div>

    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Content is Responsive</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="container-fluid">
                                        <div class="mb-3">
                                            <label for="projectname" class="form-label">Project Name</label>
                                            <input type="text" id="projectname" class="form-control"
                                                placeholder="Enter project name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="project-overview" class="form-label">Project Overview</label>
                                            <textarea class="form-control" id="project-overview" rows="5"
                                                placeholder="Enter some brief about project.."></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Project Privacy</label> <br />
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio1" name="customRadio"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio1">Private</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio2" name="customRadio"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio2">Team</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio3" name="customRadio"
                                                    class="form-check-input" checked>
                                                <label class="form-check-label" for="customRadio3">Public</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <!-- Date View -->
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="text" class="form-control" data-toggle="flatpicker"
                                                        placeholder="October 9, 2019">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <!-- Date View -->
                                                <div class="mb-3">
                                                    <label class="form-label">Due Date</label>
                                                    <input type="text" class="form-control" data-toggle="flatpicker"
                                                        placeholder="March 9, 2020">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="project-priority" class="form-label">Project Priority</label>

                                            <select class="form-control" data-toggle="select2" data-width="100%">
                                                <option value="MD">Medium</option>
                                                <option value="HI">High</option>
                                                <option value="LW">Low</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="project-budget" class="form-label">Budget</label>
                                            <input type="text" id="project-budget" class="form-control"
                                                placeholder="Enter project budget">
                                        </div>

                                    </div> <!-- end col-->

                                    <div class="col-xl-6">
                                        <div class="my-3 mt-xl-0">
                                            <label for="projectname" class="mb-0 form-label">Avatar</label>
                                            <p class="text-muted font-14">Recommended thumbnail size 800x400 (px).</p>

                                            <form action="/" method="post" class="dropzone" id="myAwesomeDropzone"
                                                data-plugin="dropzone" data-previews-container="#file-previews"
                                                data-upload-preview-template="#uploadPreviewTemplate">
                                                <div class="fallback">
                                                    <input name="file" type="file" />
                                                </div>

                                                <div class="dz-message needsclick">
                                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </form>

                                            <!-- Preview -->
                                            <div class="dropzone-previews mt-3" id="file-previews"></div>

                                            <!-- file preview template -->
                                            <div class="d-none" id="uploadPreviewTemplate">
                                                <div class="card mt-1 mb-0 shadow-none border">
                                                    <div class="p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <img data-dz-thumbnail src="#"
                                                                    class="avatar-sm rounded bg-light" alt="">
                                                            </div>
                                                            <div class="col ps-0">
                                                                <a href="javascript:void(0);" class="text-muted fw-bold"
                                                                    data-dz-name></a>
                                                                <p class="mb-0" data-dz-size></p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <!-- Button -->
                                                                <a href="" class="btn btn-link btn-lg text-muted"
                                                                    data-dz-remove>
                                                                    <i class="mdi mdi-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end file preview template -->
                                        </div>

                                        <div>
                                            <label for="project-overview" class="form-label">Team Members</label>

                                            <select class="form-control" data-toggle="select2" data-width="100%">
                                                <option>Select</option>
                                                <option value="AZ">Mary Scott</option>
                                                <option value="CO">Holly Campbell</option>
                                                <option value="ID">Beatrice Mills</option>
                                                <option value="MT">Melinda Gills</option>
                                                <option value="NE">Linda Garza</option>
                                                <option value="NM">Randy Ortez</option>
                                                <option value="ND">Lorene Block</option>
                                                <option value="UT">Mike Baker</option>
                                            </select>

                                            <div class="mt-2" id="tooltips-container">
                                                <a href="javascript:void(0);" class="d-inline-block">
                                                    <img src="../assets/images/users/user-6.jpg"
                                                        class="rounded-circle avatar-xs" alt="friend"
                                                        data-bs-container="#tooltips-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Mat Helme">
                                                </a>

                                                <a href="javascript:void(0);" class="d-inline-block">
                                                    <img src="../assets/images/users/user-7.jpg"
                                                        class="rounded-circle avatar-xs" alt="friend"
                                                        data-bs-container="#tooltips-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Michael Zenaty">
                                                </a>

                                                <a href="javascript:void(0);" class="d-inline-block">
                                                    <img src="../assets/images/users/user-8.jpg"
                                                        class="rounded-circle avatar-xs" alt="friend"
                                                        data-bs-container="#tooltips-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="James Anderson">
                                                </a>

                                                <a href="javascript:void(0);" class="d-inline-block">
                                                    <img src="../assets/images/users/user-4.jpg"
                                                        class="rounded-circle avatar-xs" alt="friend"
                                                        data-bs-container="#tooltips-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lorene Block">
                                                </a>

                                                <a href="javascript:void(0);" class="d-inline-block">
                                                    <img src="../assets/images/users/user-5.jpg"
                                                        class="rounded-circle avatar-xs" alt="friend"
                                                        data-bs-container="#tooltips-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Mike Baker">
                                                </a>
                                            </div>

                                        </div>
                                    </div> <!-- end col-->
                                </div>
                                <!-- end row -->
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <div class="modal-footer">
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-success waves-effect waves-light m-1"><i
                                    class="fe-check-circle me-1"></i> Create</button>
                            <button type="button" class="btn btn-light waves-effect waves-light m-1"><i
                                    class="fe-x me-1" data-bs-dismiss="modal"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <style>
        .container-body {
            height: 800px;
            overflow-y: scroll;
        }

    </style> --}}

@section('script')
    <script src="{{ asset('js/vendor.min.js') }}"></script>
@endsection
@endsection
