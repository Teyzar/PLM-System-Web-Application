function editIncident(id) {

    $(`#dotIcon${id}`).hide();
    const cancelbtn = $(`#cancelbtn${id}`);
    $.ajax({
        type: 'get',
        url: `incidents/${id}/edit`,
        data: $(this).serialize(),
        success: function (data) {

            for (const info of data) {
                const editIcon = $(`#_editIcon${info.id}`);


                cancelbtn.on('click', function () {
                    editIcon.html('');
                    cancelbtn.html('');
                    $(`#dotIcon${id}`).show();

                });

                editIcon.html(`<a href="#" onclick="modal(${info.incident_id}, ${info.id})"><i class="mdi mdi-playlist-edit fs-3"></i></a>`);
                cancelbtn.html('<button type="button" class="btn btn-danger btn-close py-1 px-2"></button>');

            }
        }
    });
}

function modal(incidentId, infoId) {

    $.ajax({
        type: 'get',
        url: `incidents/${infoId}/info`,
        data: $(this).serialize(),
        success: function (data) {
            const infoID = $('#infoID');
            const option = $('#default');
            const description = $('#description');

            for (const info of data) {
                const dis_title = info.title.charAt(0).toUpperCase() + info.title.slice(1);
                infoID.html('ID: ' + info.id);
                option.html(dis_title);
                option.val(dis_title);
                description.html(info.description);
            }
        }
    });
    $('#modalEditInfo').modal('show');

    $('#formUpdateInfo').attr('action', `incidents/${incidentId}/${infoId}`);

    $('#formUpdateInfo').on('submit', function() {
        $('#modalEditInfo').modal('hide');
    });

    // $('#formUpdateInfo').on('submit', function (event) {
    //     event.preventDefault();

    //     $.ajax({
    //         url: $(this).prop('action'),
    //         type: "PUT",
    //         data: $(this).serialize(),
    //         success: function (result) {
    //             $('#modalEditInfo').modal('hide');

    //             for (const info of result) {
    //                 closeIcons(info.incident_id);
    //                 const desc = $(`#input-description${info.id}`);
    //                 const title = $(`#title${info.id}`);
    //                 title.html(info.title + ' <i class="fe-minus"></i>');
    //                 desc.html(info.description);

    //             }

    //         },
    //         error: function (err) {
    //             console.log(err);
    //         }
    //     });
    // });


}

// function closeIcons(id) {
//     const cancelbtn = $(`#cancelbtn${id}`);
//     cancelbtn.html('');
//     $(`#dotIcon${id}`).show();

//     $.ajax({
//         type: 'get',
//         url: `incidents/${id}/edit`,
//         data: $(this).serialize(),
//         success: function (data) {
//             for (const info of data) {
//                 const editIcon = $(`#_editIcon${info.id}`);

//                 editIcon.html('');
//             }
//         }
//     });
// }

function addIncident(id) {

    $("#modalAddInfo").modal('show');

    $('#incidentID').html('Incident ID: ' + id);

    $('#formAddInfo').attr('action', `incidents/${id}/add`);

    const infobody = $(`#info-body${id}`);

    $('#formAddInfo').on('submit', function (event) {
        event.preventDefault();
        var $this = $(this);

        $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: $this.serialize(),
            dataType: 'json',
            success: function (result) {
                $("#modalAddInfo").modal('hide');

                const date = new Date(result.created_at);

                const str_date = date.toLocaleString('en-US', {
                    weekday: 'short', // long, short, narrow
                    day: 'numeric', // numeric, 2-digit
                    year: 'numeric', // numeric, 2-digit
                    month: 'short', // numeric, 2-digit, long, short, narrow
                    hour: 'numeric', // numeric, 2-digit
                    minute: 'numeric', // numeric, 2-digit
                });

                infobody.html(`
                <div class="col-8">
                    <span class="text-capitalize fw-bolder h5 mt-0">${result.title}<i
                            class="fe-minus"></i></span>
                    <span class="">${result.description}</span>
                </div>
                <p class="mt-2"><span
                    class="text-muted">${str_date}</span>
                </p>
                `);
            },
        });
    });
}

function passID(id) {
    $('#incident-form').attr('action', `/incidents/${id}`);
}
