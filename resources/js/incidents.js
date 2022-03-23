function editIncident(id) {
    const savebtn = $(`#savebtn${id}`);
    const cancelbtn = $(`#cancelbtn${id}`);

    $.ajax({
        type: 'get',
        url: `incidents/${id}/edit`,
        data: $(this).serialize(),
        success: function (data) {

            for (const info of data) {
                const dis_title = info.title.charAt(0).toUpperCase() + info.title.slice(1);
                const title = $(`#title${info.id}`);
                const desc = $(`#input-description${info.id}`);


                title.html(`<select id="select-title" class="form-control mb-2" data-width="10%" data-toggle="select2" name="title[]">
                <option class="text-scondary fw-bolder">${dis_title}</option>
                <option value="investigating">Investigating</option>
                <option value="fixing">Fixing</option>
                <option value="resolved">Resolved</option>
                </select>`);
                desc.html(
                    `<textarea id="description" type="text" name="description[]" class="form-control w-50 d-flex" rows="5" required>${info.description}</textarea>`
                );
                savebtn.html(
                    '<button type="submit" id="submit" class="btn btn-primary py-1 px-3 ms-1">Save</button>'
                );
                cancelbtn.html('<button type="button" class="btn btn-secondary py-1 px-2 ">Cancel</button>');

                cancelbtn.on('click', function () {
                    savebtn.html('');
                    cancelbtn.html('');
                    title.html(info.title + ' <i class="fe-minus"></i>');
                    desc.html(desc.text());
                });
            }
        }
    });



    $('form').on('submit', function (event) {
        event.preventDefault();
        var $this = $(this);

        $.ajax({
            url: $this.prop('action'),
            method: "PUT",
            data: $this.serialize(),
            success: function (result) {
                console.log(result);
                for (const info of result) {
                    const desc = $(`#input-description${info.id}`);
                    const title = $(`#title${info.id}`);

                    desc.html(info.description);
                    title.html(info.title + ' <i class="fe-minus"></i>');
                    savebtn.html('');
                    cancelbtn.html('');
                }

            }
        });
    });
}

function addIncident(id) {
    const incident = $(`#incident${id}`);
    const textarea = $(`#textarea${id}`);
    const addbtn = $(`#savebtn${id}`);
    const cancelbtn = $(`#cancelbtn${id}`);
    addbtn.html(
        '<button type="submit" id="submit" class="btn btn-primary py-1 px-3 ms-1">Add</button>'
    );
    cancelbtn.html('<button type="button" class="btn btn-secondary py-1 px-2 ">Cancel</button>');


    incident.html(`
                <select id="title" class="form-control" data-toggle="select2" name="title" required>
                    <option value="" class="text-scondary fw-bolder">Title</option>
                    <option value="investigating">Investigating</option>
                    <option value="fixing">Fixing</option>
                    <option value="resolved">Resolved</option>
                </select>`);

    textarea.html(`
        <textarea id="description" name="description" class="form-control" rows="5" placeholder="Enter some brief description about the report" required></textarea>`);
    var form = $('form');

    form.attr('action', `incidents/${id}/add`);

    let disId = id;


    cancelbtn.on('click', function () {
        incident.html('');
        textarea.html('');
        addbtn.html('');
        cancelbtn.html('');

    });
    const infobody = $(`#info-body${id}`);


    $('form').on('submit', function (event) {
        event.preventDefault();
        var $this = $(this);

        $.ajax({
            method: "POST",
            url: `incidents/${disId}/add`,
            data: $this.serialize(),
            dataType: 'json',
            success: function (result) {
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
                addbtn.html('');
                cancelbtn.html('');
                incident.html('');
                textarea.html('');
            },
        });
    });
}

function passID(id) {
    $('#incident-form').attr('action', `/incidents/${id}`);
}
