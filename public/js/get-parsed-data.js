$(function() {

    $(".request_btn").on("click", function (e) {
        e.preventDefault();
        let btn = $(this);
        $('#loader').show();
        btn.prop('disabled', true);
        $.get("application/ajaxGetData", function(response) {
            if (response) {
                $("#records_table tbody").empty();
                let data = JSON.parse(response);
                for (let i = 0; i < data.length; i++ ) {
                    let tags = data[i].tags.toString();
                    $('<tr>').append(
                        $('<td>').text(data[i].name),
                        $('<td>').text(tags),
                        $('<td>').text(data[i].timestamp)
                    ).appendTo('#records_table tbody');
                }
            }

            $('#loader').hide();
            btn.removeAttr('disabled');
        });
    });

});

