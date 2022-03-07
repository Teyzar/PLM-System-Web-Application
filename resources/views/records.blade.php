@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ mix('css/records.css') }}">
@endsection

@section('content')
    <div class="container mt-4">
        <span class="fs-5">Past Incidents</span>
        <button type="button" class="border-0 bg-light" value="click" onclick="printDiv()"><i
                class="fa-solid fa-print fs-4 text-secondary"></i></button>
    </div>
    <div class="container">
        <hr>
    </div>
    <div class="container mt-3 bg-white shadow container-body table-bordered" id="GFG">
        <div class="col w-100 text-muted">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-md-12 p-3 record-card">
                    <div class="card-header shadow-card">
                        <span class="h6">March 4, 2022</span>
                    </div>
                    <div class="card-body bg-white shadow-card">
                        <p>No incidents reported today.</p>
                    </div>
                </div>
                <div class="col-md-12 p-3 record-card">
                    <div class="card-header shadow-card">
                        <span class="h6">March 5, 2022</span>
                    </div>
                    <div class="card-body bg-white shadow-card">
                        <h5 class="d-flex">Resolved: </h5>
                        <p>The incident has been resolved</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <script>
        function printDiv() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = mm + '/' + dd + '/' + yyyy;
            var divContents = document.getElementById("GFG").innerHTML;
            var a = window.open('', 'PRINT', 'height=500, width=500');
            a.document.write('<html><head>');
            a.document.write('<link rel=\"stylesheet\" href=\"{{ mix('css/records.css') }}\">');
            a.document.write('<link href=\"{{ mix('css/bootstrap.css') }}\" rel=\"stylesheet\">');
            a.document.write('</head><body>');
            a.document.write(
                '<div class="container row"><h4 class="fw-bold justify-content-start d-flex pb-2">Power Line Monitoring Systems</h4>'
                );
            a.document.write('<h6 class="">List of Outages Records</h6>');
            a.document.write(`<h6>${today}</h6></div>`);
            a.document.write('<hr>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.focus();

            setTimeout(function() {
                a.print();
                a.close();
            }, 1000)
            return true;
        }
    </script>
@endsection
