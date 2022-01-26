@extends('layouts.app')

@section('body')
    <div class="container py-4" style="margin-top: 4%">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    @foreach ($data as $d)
                        <div class="card-header text-capitalize">{{ __(ucfirst($d->name)) }}
                            <form method="post" action="{{ route('accounts.destroy', $d->id) }}"
                                onclick="return confirm('Are you sure you want to delete this account?')"
                                class="float-end">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm fs-4 hover-zoom a:hover"><i
                                        class="bi bi-trash text-danger"></i></button>
                            </form>
                        </div>
                        <div class="card-body ">
                            <form method="post" action="{{ route('accounts.update', $d->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="d-none">
                                    @if (!empty(old('name') || !empty(old('email') || !empty(old('baranggay')))))
                                    {{ $d->name = old('name') }}
                                    {{ $d->email = old('email') }}
                                    {{ $d->baranggay = old('baranggay') }}
                    @endif
                </div>

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror text-capitalize" name="name"
                            value="{{ $d->name }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            placeholder="Email" required autocomplete="email" value="{{ $d->email }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="baranggay" class="col-md-4 col-form-label text-md-end">{{ __('Baranggay') }}</label>

                    <div class="col-md-6">
                        <input id="baranggay" type="text" class="form-control" name="baranggay" required
                            value="{{ $d->baranggay }}">
                    </div>
                </div>
                @endforeach
                <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-secondary" id="exampleModalLabel">Confirmation</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body fs-6 text-dark">
                                Are you sure you want to save?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#modalForm">
                            {{ __('Submit') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
