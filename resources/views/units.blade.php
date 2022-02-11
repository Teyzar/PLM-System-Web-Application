@extends('layouts.units')

@section('content-body')
    <div class="container m-auto">
        <div class="row">
            <div class="border-dark table-responsive-sm">
                <table class="table table-hover table-md text-start">
                    <div class="card-header float-end">
                        <form action="/units-clear" class="bg-dark" method="post">
                            @csrf
                            @method('post')
                            {{-- only temporary --}}
                            <button type="submit" class="btn btn-danger">
                                Clear Data
                            </button>
                        </form>
                    </div>
                    <thead class="table-success">
                        <tr class="border-dark border fs-5 text-dark">
                            <th width="25%">phone_number</th>
                            <th width="25%">longitude</th>
                            <th width="20%">Latitude</th>
                            <th width="20%">updated_at</th>

                        </tr>
                    </thead>
                    <tbody class="border border-1 searchbody bg-light" id="tb">
                        @foreach ($units as $unit)
                            <tr class="trbody bg-light border border-dark">
                                <td>
                                    {{ $unit->phone_number }}
                                </td>
                                <td>
                                    {{ $unit->longitude }}
                                </td>
                                <td>
                                    {{ $unit->latitude }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($unit->updated_at)->toDayDateTimeString() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
