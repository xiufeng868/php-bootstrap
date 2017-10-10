function myAlert(msg, id, iserror) {
    var alert = $("#alert");
    if (iserror) {
        alert.removeClass("alert-success").addClass("alert-danger");
    } else {
        alert.removeClass("alert-danger").addClass("alert-success");
    }
    alert.html(msg);
    $("#"+id).prepend(alert);
    alert.slideDown("fast");
    setTimeout('$("#alert").slideUp("fast");', 1000);
}
function initDDL(_action, _codegroup, _upcode, ddl, ddlchild, selectedvalue, selectedvaluechild) {
    $.getJSON("/ajax/ajax_code.php", { action: _action, upcode: _upcode, codegroup: _codegroup }, function(json) {
        $("#" + ddl + " option").not(":first").remove();
        $.each(json, function(i, item) {
            $("#" + ddl).append("<option value='" + item.code + "'>" + item.name + "</option>");
        });
        if (selectedvalue != null) {
            $("#" + ddl).val(selectedvalue);
            if (_upcode == "" && ddlchild != null) {

                initDDL("allcodelist", "", selectedvalue, ddlchild, null, selectedvaluechild, null);
            }
        }
    });
    if (_upcode == "" && ddlchild != null) {
        $("#" + ddl).bind('change', function() {

            initDDL("allcodelist", "", $(this).val(), ddlchild, null, null, null);
        });
    }
}
function blockUIShow(id, msg) {
    $("#" + id).block({
        message: '<img src="/img/spinner0.gif" /> ' + msg,
        css: {
            border: 'none',
            width:'100px',
            backgroundColor: '#fff',
            opacity: 0.5,
            color: '#000'
        }
    });
}
function blockUIHide(id) {
    $("#" + id).unblock();
}
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height() - $dialog.height()) / 2;
    $dialog.css("margin-top", offset);
}
function activeNav(navId) {
    $("#myNav li .active").removeClass("active");
    $("#" + navId).addClass("active");
}
$(function () {
    $('.modal').on('show.bs.modal', centerModal);
});