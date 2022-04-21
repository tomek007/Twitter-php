$(document).ready(function() {
    console.log("DOM is ready");

    var comments = ($('.show-comment'));
    //console.log(comments.siblings('hr'));
    for (var i = 0; i < comments.length; i++) {
        var commentQuantity = (comments.eq(i).children().length);
        if (commentQuantity > 2) {
            comments.eq(i).children().not(":eq(0), :eq(1)").hide();
            var iconPosition = (comments.eq(i).children().parent());
            var newIcon = $('<button style="margin-bottom:1%; margin-left:85%" class="btn showMore"><span>more <i class="fa fa-angle-double-down" aria-hidden="true"></i></span></button>')

            newIcon.insertAfter(iconPosition);
        }


    }

    $('.showMore').on('click', function() {
        var hidden = (($(this).siblings('.show-comment').children(':hidden')));
        if (hidden.length > 0) {
            hidden.show();
            var aaa = $(this).children('span');
            aaa.remove();
            $(this).append('<span>less <i class="fa fa-angle-double-up" aria-hidden="true"></i></span>')

        } else {
            var showd = $(this).siblings('.show-comment').children().not(":eq(0), :eq(1)");
            showd.hide();
            var aaa = $(this).children('span');
            aaa.remove();
            $(this).append('<span>more <i class="fa fa-angle-double-down" aria-hidden="true"></i></span>')
        }


    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    validInfo = true;
    $('#emailValid').on('keyup', function() {
        console.log($(this).length);
        var valid = (isEmail($('#emailValid').val()));
        if (valid == false) {
            $(this).addClass('alert-danger');
            validInfo = false;



        } else {
            $(this).removeClass('alert-danger');
            $(this).addClass('alert-success');
            validInfo = true;
        }
    });

    ($('form').eq(1).find('input').not(":eq(0)")).on('focus', function() {

        if (validInfo == false) {
            $('#emailValid').val("");
            //console.log($('#emailValid').val());
        } else {

        }
    })




});
