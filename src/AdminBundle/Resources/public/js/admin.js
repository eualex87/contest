$(document).ready(function () {

    //$.ajax({
    //    url: url,
    //    type: "POST",
    //    data: data,
    //    processData: false,
    //    contentType: false,
    //    success: function (result) {
    //        if (result.error) {
    //            $("#dialog-error").html(result.messageResult).dialog({
    //                title: "O mica eroare!",
    //                modal: true,
    //                width: 400,
    //                buttons: {
    //                    'Mai incerc': function () {
    //                        $(this).dialog("close");
    //                    }
    //                }
    //            });
    //        } else {
    //            if (result.repeat) {
    //                $("#dialog-repeat").html(result.repeat).dialog({
    //                    title: "Atentie!",
    //                    modal: true,
    //                    width: 400,
    //                    buttons: {
    //                        'M-ati prins': function () {
    //                            $(this).dialog("close");
    //                        }
    //                    }
    //                });
    //            } else {
    //                if (result.confirm) {
    //                    $("#dialog-confirm").html(result.confirm).dialog({
    //                        title: "Informatii importante!",
    //                        modal: true,
    //                        width: 400,
    //                        buttons: {
    //                            'Astept verdictul': function () {
    //                                $(this).dialog("close");
    //                                if (message != '') {
    //                                    location.hash = "#" + 'mesaje';
    //                                } else {
    //                                    location.hash = "#" + 'poze';
    //                                }
    //                            }
    //                        }
    //                    });
    //                    $("form[name='share']").trigger('reset');
    //                }
    //            }
    //        }
    //    },
    //    error: function (data){
    //        console.log(data);
    //    }
    //});
});