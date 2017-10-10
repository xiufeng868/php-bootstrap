<?php
require_once('../session.php');
include('../header.php');
?>

    <!-- Begin page content -->
    <div class="container">
        <h5>编码组</h5>
        <table id="actTable" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="success">
                <th width="10%">ID</th>
                <th width="20%" id="ch3">编码组</th>
                <th width="20%">名称</th>
                <th width="20%">编码</th>
                <th width="30%"></th>
            </tr>
            </thead>
        </table>

        <div class="row btnPanel">
            <div class="col-lg-3">
                <button id="btnCreate" type="button" class="btn btn-primary">新建编码</button>
            </div>
            <div class="col-lg-9">
                <ul id="page" class="pagination">
                </ul>
            </div>

            <input id="cid" type="hidden" />
            <input id="cname" type="hidden" />
            <input id="ccode" type="hidden" />
            <input id="cupcode" type="hidden" value="<?php echo empty($_REQUEST['upcode']) ? '' : $_REQUEST['upcode']; ?>" />
            <input id="ccodegroup" type="hidden" value="<?php echo empty($_REQUEST['codegroup']) ? '' : $_REQUEST['codegroup']; ?>" />
            <input id="currentpage" type="hidden" />
        </div>

        <div id="delModal" class="modal fade modal-scrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">删除编码</h4>
                    </div>
                    <div class="modal-body text-warning">
                        <div id="alertDel"></div>
                        确定要删除编码吗？
                    </div>
                    <div class="modal-footer">
                        <button type='button' id="btnDelete" class="btn btn-danger" data-loading-text="删除中..."
                                onclick="javascript:deleteCode();">删 除</button>
                        <button type='button' class="btn btn-default " onclick="javascript:$('#delModal').modal('hide');">取 消</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modModal" class="modal fade modal-scrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel2">修改明细</h4>
                    </div>
                    <div class="modal-body">
                        <div id="alertMod"></div>
                        <form class="form-horizontal">
                            <div id="divCodeGroup" class="form-group">
                                <label for="codegroup" class="col-sm-3 control-label">编码组</label>
                                <div class="col-sm-8">
                                    <select id="codegroup" class="form-control input-sm">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div id="divUpCode" class="form-group">
                                <label for="upcode" class="col-sm-3 control-label">父编码</label>
                                <div class="col-sm-8">
                                    <select id="upcode" class="form-control input-sm">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">名称</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="name" placeholder="名称" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-sm-3 control-label">编码</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="code" placeholder="编码" type="text">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type='button' id="btnUpdate" class="btn btn-warning" data-loading-text="修改中..."
                                onclick="javascript:updateCode();">修 改</button>
                        <button type='button' id="btnInsert" class="btn btn-primary" data-loading-text="保存中..."
                                onclick="javascript:insertCode();">保 存</button>
                        <button type='button' class="btn btn-default " onclick="javascript:$('#modModal').modal('hide');">取 消</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="alert" class="alert alert-dismissable alert-danger col-sm-4 col-sm-offset-4"></div>
    </div>

<?php include('../footer.php'); ?>

<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script src="/js/util.js"></script>

<script type="text/javascript">
$(function() {
    activeNav("nav3");

    initDDL("allcodegrouplist", "", "", "codegroup", null);
    $("#codegroup").bind('change', function() {
        //$("#upcode option").not(":first").remove();
        initDDL("allcodelist", $(this).val(), "", "upcode");
    });

    gotoPage(1);

    $("#btnCreate").bind('click', function () {
        $("#name").val("");
        $("#code").val("");
        $("#divCodeGroup").show();
        $("#divUpCode").show();
        $("#btnUpdate").hide();
        $("#btnInsert").show();
        $('#modModal').modal('show');
    });
});

function checkform() {
    var codegroup = $("#codegroup");
    if ($("#divCodeGroup").is(":visible") && codegroup.val() == '') {
        codegroup.focus();
        myAlert("编码组不能为空", "alertMod", true);
        return false;
    }
    var name = $("#name");
    if (name.val() == '') {
        name.focus();
        myAlert("名称不能为空", "alertMod", true);
        return false;
    }
    var code = $("#code");
    if (code.val() == '') {
        code.focus();
        myAlert("编码不能为空", "alertMod", true);
        return false;
    }
    return true;
}

// insert
function insertCode() {
    if (checkform()) {
        $("#btnInsert").button('loading');
        $.post("/ajax/ajax_code.php",
                {
                    action: "addcode",
                    name: $("#name").val(),
                    code: $("#code").val(),
                    upcode: $("#upcode").val(),
                    codegroup: $("#codegroup").val()
                },
                function(result) {
                    if (result==1) {
                        myAlert("保存成功", "alertMod", false);
                        $("#name").val("");
                        $("#code").val("");
                        gotoPage(1);
                    } else if (result==0) {
                        myAlert("编码重复", "alertMod", true);
                    } else {
                        myAlert(result, "alertMod", true);
                    }
                    $("#btnInsert").button('reset');
                }
        );
    }
}

// update
function bindUpdateHidden(id, name, code) {
    $("#cid").val(id);
    $("#name").val(name);
    $("#code").val(code);
    $("#cname").val(name);
    $("#ccode").val(code);

    $("#divCodeGroup").hide();
    $("#divUpCode").hide();
    $("#btnUpdate").show();
    $("#btnInsert").hide();
}
function updateCode() {
    if (checkform()) {
        $("#btnUpdate").button('loading');
        $.post("/ajax/ajax_code.php",
                {
                    action: "modcode",
                    id: $("#cid").val(),
                    name: $("#name").val(),
                    code: $("#code").val(),
                    oldname: $("#cname").val(),
                    oldcode: $("#ccode").val()
                },
                function(result) {
                    if (result == 1) {
                        gotoPage($("#currentpage").val());
                        $('#modModal').modal('hide');
                    } else {
                        myAlert(result, "alertMod", true);
                    }
                    $("#btnUpdate").button('reset');
                }
        );
    }
}

// delete
function bindDeleteHidden(id, name, code) {
    $("#cid").val(id);
    $("#cname").val(name);
    $("#ccode").val(code);
}
function deleteCode() {
    $("#btnDelete").button('loading');
    $.post("/ajax/ajax_code.php",
            {
                action: "delcode",
                id: $("#cid").val(),
                name: $("#cname").val(),
                code: $("#ccode").val()
            },
            function(result) {
                if (result == 1) {
                    gotoPage($("#currentpage").val());
                    $('#delModal').modal('hide');
                } else if (result == 0) {
                    myAlert("包含子编码,无法删除", "alertDel", true);
                } else {
                    myAlert(result, "alertDel", true);
                }
                $("#btnDelete").button('reset');
            }
    );
}

function gotoPage(p) {
    blockUIShow("actTable", "正在读取...");
    $("#currentpage").val(p);
    $.post("/ajax/ajax_code.php", { action: "codelistsize", codegroup: $("#ccodegroup").val(), upcode: $("#cupcode").val() }, function(result) {
        if (result > 0) {
            var ps;
            var _pagesize = 12;
            if (result % _pagesize > 0) {
                ps = parseInt(result / _pagesize) + 1;
            } else {
                ps = result / _pagesize;
            }
            p = parseInt(p);
            if (p > ps) p = ps;
            var startcount = (p + 5) > ps ? ps - 9 : p - 4;
            var endcount = p < 5 ? 10 : p + 5;
            if (startcount < 1) startcount = 1;
            if (ps < endcount) endcount = ps;

            $("#page").empty().append("<li class='disabled'><a>共" + ps + "页</a></li>");
            if (p > 1) {
                $("#page").append("<li><a href='javascript:gotoPage(1);'>首页</a></li><li><a href='javascript:gotoPage(" + (p - 1) + ");'>上一页</a></li>");
            }
            for (var i = startcount; i <= endcount; i++) {
                if (i != p) {
                    $("#page").append("<li><a href='javascript:gotoPage(" + i + ");'>" + i + "</a></li>");
                } else {
                    $("#page").append("<li class='active'><a>" + i + "</a></li>");
                }
            }
            if (p < ps) {
                $("#page").append("<li><a href='javascript:gotoPage(" + (p + 1) + ");'>下一页</a></li><li><a href='javascript:gotoPage(" + ps + ");'>尾页</a></li>");
            }
        } else {
            $(".ttRow").remove();
            $("#actTable").append("<tr class='ttRow'><td colspan='5'>没有数据</td></tr>");
            blockUIHide("actTable");
            return;
        }

        $.getJSON("/ajax/ajax_code.php", { action: "codelist", page: p, pagesize: _pagesize, codegroup: $("#ccodegroup").val(), upcode: $("#cupcode").val() }, function(json) {
            $(".ttRow").remove();
            if ($("#cupcode").val() != "") $("#ch3").html("父编码");
            var content;
            $.each(json, function(i, item) {
                content = "<tr class='ttRow'><td id='id" + item.id + "'>" + item.id + "</td>";
                if (item.upcode == "") {
                    content += "<td id='codegroup" + item.id + "'>" + item.codegroup + "</td>";
                } else {
                    content += "<td id='upcode" + item.id + "'>" + item.upcode + "</td>";
                }
                content += "<td id='name" + item.id + "'>" + item.name +
                            "</td><td id='code" + item.id + "'>" + item.code +
                            "</td><td>";

                if (item.upcode == "") {
                    content += "<a class='btn btn-primary btn-xs' href='code.php?upcode=" + item.code +
                                "'>查看子编码</a> ";
                }
                content += "<button type='button' class='btn btn-warning btn-xs' id='btnMod" + item.id +
                            "'>修 改</button> <button type='button' class='btn btn-danger btn-xs' id='btnDel" + item.id +
                            "'>删 除</button> </td></tr>";
                $("#actTable").append(content);
                $("#btnMod" + item.id).bind('click', function() {
                    bindUpdateHidden(item.id, item.name, item.code);
                    $('#modModal').modal('show');
                    return false;
                });
                $("#btnDel" + item.id).bind('click', function() {
                    bindDeleteHidden(item.id, item.name, item.code);
                    $('#delModal').modal('show');
                    return false;
                });
            });
            blockUIHide("actTable");
        });
    });
}
</script>
