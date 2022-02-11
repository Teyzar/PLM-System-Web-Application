@extends('layouts.units')

@section('content-body')

    <form action="{{ URL::to('units') }}" method="POST">
        @csrf
        <div class="container" style="margin-top: 10%">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-5 bg-dark">
                        <div class="card-header w-100 justify-content-start responsive bg-light border-3 border-info">
                            Phone number
                            <button class="btn float-end btn-primary p-1 px-4" type="submit">submit</button>
                        </div>
                        <div class="card-body bg-light">
                            <div class="form-group justify-content-center">
                                <div class="col-sm-10">
                                    <div class="phone-list">
                                        <div class="input-group phone-input" style="margin-bottom: 8px">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn border border-muted"><span
                                                        class="type-text"><i
                                                            class="fs-3 fa-solid fa-mobile-screen"></i></span> <span
                                                        class="caret"></span></button>
                                            </span>
                                            <input type="text" name="phone_number[]"
                                                class="form-control border-muted d-flex" placeholder="+63 (999) 999 9999"
                                                required />
                                        </div>
                                    </div>
                                    @if ($errors->has('phone_number'))
                                        <div class="error text-danger">{{ $errors->first('phone_number') }}</div>
                                    @endif
                                </div>
                                <button class="btn btn-success btn-sm btn-add-phone float-start"><span
                                        class="glyphicon glyphicon-plus d-flex"></span>Add number</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(function() {

            $(document.body).on('click', '.btn-remove-phone', function() {
                $(this).closest('.phone-input').remove();
            });
            $('.btn-add-phone').click(function() {
                var index = $('.phone-input').length + 1;

                $('.phone-list').append('' +
                    '<div class="input-group phone-input">' +
                    '<span class="input-group-btn">' +
                    '<button type="button" class="btn border border-muted"><span class="type-text"><i class="fs-3 fa-solid fa-mobile-screen"></i></span> <span class="caret"></span> </button>' +
                    '</span>' +
                    '<input type="text" name="phone_number[]" class="form-control"  placeholder="+63 (999) 999 9999" required />' +
                    '<span class="input-group-btn">' +
                    '<button class="btn btn-remove-phone" type="button"><span class="fs-4 text-danger fa-solid fa-minus"></span></button>' +
                    '</span>' +
                    '</div>'
                );
            });
        });
    </script>

@endsection
