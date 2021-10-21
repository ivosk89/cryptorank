$(function() {

    $(".request_btn").on("click", function (e) {
        e.preventDefault();
        $('#loader').show();
        $.get("application/ajaxGetData", function(response) {
            if (response) {
                let data = JSON.parse(response);
                for (let i = 0; i < data.length; i++ ) {
                    let tags = data[i].tags.toString();
                    $('<tr>').append(
                        $('<td>').text(data[i].name),
                        $('<td>').text(tags),
                        $('<td>').text(data[i].timestamp)
                    ).appendTo('#records_table');
                }
            }
            $('#loader').hide();
        });
    });

});

