$(document).ready(function () {
    $(document).on('click', '#share_send',  function(){
        var lastName = $('#share_required_last_name').val();
        var firstName = $('#share_required_first_name').val();
        var email = $('#share_required_email').val();
        var day = $('#share_date_day').val();
        var month = $('#share_date_month').val();
        var year = $('#share_date_year').val();
        if( $('#share_anonymous').is( ":checked" )) {
            var anonim = 1;
        } else {
            var anonim = 0;
        }
        var date = '';
        var ok = true;
        if (day != '' && month != '' && year != '') {
            date = day +'-'+ month +'-'+ year;
            $('#share_date').removeAttr('style');
        } else {
            $('#share_date').attr('style','border: 1px solid red');
            ok = false;
        }
        var sex = $('#share_required_sex').val();
        $("[id^='share_required']").each(function(){
            var input = $(this).val();
            if (input.trim() == '') {
                $(this).attr('style','border: 1px solid red');
                ok = false;
            } else {
                $(this).removeAttr('style');
            }
        });
        if (ok == false) {
            $('#error').val('').html("Da-mi cateva detalii, te rog! Campurile cu * sunt obligatorii.");
        } else {
            $('#error').val('').html('');
            var message = $('#share_message').val().trim();
            var file = $('#share_image').val();
            if (message == "" && file == '') {
                $("label[for='share_message']").attr('style','color: red');
                $("label[for='share_image']").attr('style','color: red');
                $('#error').val('').html("Amuza-ne cu o imagine sau un mesaj \"funny\".");
            } else {
                $("label[for='share_message']").removeAttr('style');
                $("label[for='share_image']").removeAttr('style');
                $('#error').val('').html('');
                //var data = {'lastName': lastName, 'firstName': firstName, 'email': email, 'date': date, 'gender': sex, 'message': message, 'file': file, 'anonim': anonim};
                var url = Routing.generate('send');
                var data = new FormData($('form[name="share"]')[0]);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        if (result.error) {
                            $("#dialog-error").html(result.messageResult).dialog({
                                title: "O mica eroare!",
                                modal: true,
                                width: 400,
                                buttons: {
                                    'Mai incerc': function () {
                                        $(this).dialog("close");
                                    }
                                }
                            });
                        } else {
                            if (result.repeat) {
                                $("#dialog-repeat").html(result.repeat).dialog({
                                    title: "Atentie!",
                                    modal: true,
                                    width: 400,
                                    buttons: {
                                        'M-ati prins': function () {
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                            } else {
                                if (result.confirm) {
                                    $("#dialog-confirm").html(result.confirm).dialog({
                                        title: "Informatii importante!",
                                        modal: true,
                                        width: 400,
                                        buttons: {
                                            'Astept verdictul': function () {
                                                $(this).dialog("close");
                                                if (message != '') {
                                                    location.hash = "#" + 'mesaje';
                                                } else {
                                                    location.hash = "#" + 'poze';
                                                }
                                            }
                                        }
                                    });
                                    $("form[name='share']").trigger('reset');
                                }
                            }
                        }
                    },
                    error: function (data){
                        console.log(data);
                    }
                });
            }
        }
    });
});
