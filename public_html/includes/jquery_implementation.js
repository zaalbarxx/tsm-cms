jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function (arg) {
    return function (elem) {
        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
$(document).ready(function () {
    $("#searchItems").focus(function () {
        if ($(this).val() == "Search...") {
            $(this).val('');
        }
    }).blur(function () {
            if ($(this).val() == "") {
                $(this).val('Search...');
            }
        });
    $("#searchItems").keyup(function () {
        if ($(this).val() != "") {
            $("." + $(this).attr("rel")).hide();
            var searchVars = $(this).val().split(" ");
            for (var i = 0; i < searchVars.length; i++) {
                $("." + $(this).attr("rel") + ":Contains('" + searchVars[i] + "')").show();
            }


        } else {
            $("." + $(this).attr("rel")).show();
        }
    });
});
