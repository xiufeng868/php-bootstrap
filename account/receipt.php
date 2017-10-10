<?php
require_once('../session.php');
include('../header.php');
?>

    <!-- Begin page content -->
    <div class="container">
        <h5>收入明细</h5>
        <div id="searchPanel" class="well well-sm">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <input id="s_receiptdate1" type="text" class="form-control input-sm" placeholder="开始时间" />
                </div>
                <div class="form-group">
                    <input id="s_receiptdate2" type="text" class="form-control input-sm"placeholder="结束时间" />
                </div>
                <div class="form-group">
                    <select id="s_incometype" class="form-control input-sm">
                        <option value=''>收入类别</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="s_contributor" class="form-control input-sm">
                        <option value=''>贡献者</option>
                    </select>
                </div>
                <div class="form-group">
                    <input id="s_keyword" type="text" class="form-control input-sm" placeholder="关键字"/>
                </div>
                <button id="btnSearch" type="button" class="btn btn-primary btn-sm">搜 索</button>
                <button id="btnReset" type="button" class="btn btn-default btn-sm">重 置</button>
            </form>
        </div>

        <table id="actTable" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr class="success">
                <th width="6%">ID</th>
                <th width="10%">日期</th>
                <th width="28%">名称</th>
                <th width="20%">类别</th>
                <th width="12%">金额</th>
                <th width="12%">贡献者</th>
                <th width="12%"></th>
            </tr>
            </thead>
        </table>

        <div class="row btnPanel">
            <div class="col-lg-1">
                <button id="btnCreate" type="button" class="btn btn-primary">新建明细</button>
            </div>
            <div class="col-lg-1">
                <a href="/account/receipt.php" class="btn btn-primary" role="button">全部明细</a>
            </div>
            <div class="col-lg-1">
                <button id="btnOpenSearch" type="button" class="btn btn-primary">搜 索</button>
            </div>
            <div class="col-lg-9">
                <ul id="page" class="pagination">
                </ul>
            </div>

            <input id="cid" type="hidden" />
            <input id="currentpage" type="hidden" />
        </div>

        <div id="delModal" class="modal fade modal-scrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">删除明细</h4>
                    </div>
                    <div class="modal-body text-warning">
                        <div id="alertDel"></div>
                        确定要删除明细吗？
                    </div>
                    <div class="modal-footer">
                        <button type='button' id="btnDelete" class="btn btn-danger" data-loading-text="删除中..."
                                onclick="javascript:deleteReceipt();">删 除</button>
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
                        <h4 class="modal-title" id="myModalLabel2">编辑明细</h4>
                    </div>
                    <div class="modal-body">
                        <div id="alertMod"></div>
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="receiptdate" class="col-sm-3 control-label">收入日期</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="receiptdate" placeholder="收入日期" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="income" class="col-sm-3 control-label">收入名称</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="income" placeholder="收入名称" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-sm-3 control-label">收入金额</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="amount" placeholder="收入金额" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="incometype" class="col-sm-3 control-label">收入类别</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" id="incometype">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contributor" class="col-sm-3 control-label">贡献者</label>
                                <div class="col-sm-8">
                                    <select id="contributor" class="form-control input-sm">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="remark" class="col-sm-3 control-label">备注</label>
                                <div class="col-sm-8">
                                    <textarea id="remark" class="form-control input-sm" rows="3" placeholder="备注"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type='button' id="btnUpdate" class="btn btn-warning" data-loading-text="修改中..."
                                onclick="javascript:updateReceipt();">修 改</button>
                        <button type='button' id="btnInsert" class="btn btn-primary" data-loading-text="保存中..."
                                onclick="javascript:insertReceipt();">保 存</button>
                        <button type='button' class="btn btn-default " onclick="javascript:$('#modModal').modal('hide');">取 消</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="alert" class="alert alert-dismissable alert-danger col-sm-4 col-sm-offset-4"></div>
    </div>

<?php include('../footer.php'); ?>

<script type="text/javascript" src="/My97DatePicker/WdatePicker.js" language="javascript"></script>
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script src="/js/util.js"></script>

<script type="text/javascript">
$(function () {
    activeNav("nav4");

    initDDL("allcodelist", "", "15", "s_incometype", null);
    initDDL("allcodelist", "", "01", "s_contributor", null);

    initDDL("allcodelist", "", "15", "incometype", null);
    initDDL("allcodelist", "", "01", "contributor", null);

    gotoPage(1);

    $("#btnCreate").bind('click', function () {
        $("#modModal input").val("");
        $("#modModal select").val("");
        $("#remark").val("");
        $("#btnUpdate").hide();
        $("#btnInsert").show();
        $('#modModal').modal('show');
    });
    $("body").bind('click', function () {
        $(".divEasing:visible").hide("fast");
    });
    $("#btnSearch").bind('click', function () {
        gotoPage(1);
    });
    $("#btnReset").bind('click', function () {
        $("#s_receiptdate1").val('');
        $("#s_receiptdate2").val('');
        $("#s_incometype").val('');
        $("#s_contributor").val('');
        $("#s_keyword").val('');
    });
    $("#s_receiptdate1").bind('click', function () {
        WdatePicker();
    });
    $("#s_receiptdate2").bind('click', function () {
        WdatePicker();
    });
    $("#receiptdate").bind('click', function () {
        WdatePicker();
    });
    $("#btnOpenSearch").bind('click', function () {
        $("#searchPanel").slideToggle("fast");
    });
});

function checkform() {
    var receiptdate = $("#receiptdate");
    if (receiptdate.val() == '') {
        receiptdate.focus();
        myAlert("收入日期不能为空", "alertMod", true);
        return false;
    }
    var income = $("#income");
    if (income.val() == '') {
        income.focus();
        myAlert("收入名称不能为空", "alertMod", true);
        return false;
    }
    var amount = $("#amount");
    if (amount.val() == '') {
        amount.focus();
        myAlert("收入金额不能为空", "alertMod", true);
        return false;
    }
    if (isNaN(amount.val())) {
        amount.focus();
        myAlert("收入金额不是数字", "alertMod", true);
        return false;
    }
    if (amount.val() < 0) {
        amount.focus();
        myAlert("收入金额不能是负数", "alertMod", true);
        return false;
    }
    var incometype = $("#incometype");
    if (incometype.val() == '') {
        incometype.focus();
        myAlert("收入类别不能为空", "alertMod", true);
        return false;
    }
    var contributor = $("#contributor");
    if (contributor.val() == '') {
        contributor.focus();
        myAlert("贡献者不能为空", "alertMod", true);
        return false;
    }
    return true;
}

// insert
function insertReceipt() {
    if (checkform()) {
        $("#btnInsert").button('loading');
        $.post("/ajax/ajax_receipt.php",
                {
                    action: "addreceipt",
                    income: $("#income").val(),
                    incometype: $("#incometype").val(),
                    amount: $("#amount").val(),
                    receiptdate: $("#receiptdate").val(),
                    contributor: $("#contributor").val(),
                    remark: $("#remark").val()
                },
                function(result) {
                    if (result==1) {
                        myAlert("保存成功", "alertMod", false);
                        $("#income").val("");
                        $("#amount").val("");
                        $("#remark").val("");
                        gotoPage(1);
                    } else {
                        myAlert(result, "alertMod", true);
                    }
                    $("#btnInsert").button('reset');
                }
        );
    }
}

// update
function bindUpdateHidden(id, income, incometype, amount, receiptdate, contributor, remark) {
    $("#cid").val(id);
    $("#income").val(income);
    $("#incometype").val(incometype);
    $("#amount").val(amount);
    $("#receiptdate").val(receiptdate);
    $("#contributor").val(contributor);
    $("#remark").val(remark);

    $("#btnUpdate").show();
    $("#btnInsert").hide();
}
function updateReceipt() {
    if (checkform()) {
        $("#btnUpdate").button('loading');
        $.post("/ajax/ajax_receipt.php",
                {
                    action: "modreceipt",
                    id: $("#cid").val(),
                    income: $("#income").val(),
                    incometype: $("#incometype").val(),
                    amount: $("#amount").val(),
                    receiptdate: $("#receiptdate").val(),
                    contributor: $("#contributor").val(),
                    remark: $("#remark").val()
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
function bindDeleteHidden(id) {
    $("#cid").val(id);
}
function deleteReceipt() {
    $("#btnDelete").button('loading');
    $.post("/ajax/ajax_receipt.php",
            {
                action: "delreceipt",
                id: $("#cid").val()
            },
            function(result) {
                if (result == 1) {
                    gotoPage($("#currentpage").val());
                    $('#delModal').modal('hide');
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
    $.post("/ajax/ajax_receipt.php",
            {
                action: "receiptlistsize",
                incometype: $("#s_incometype").val(),
                contributor: $("#s_contributor").val(),
                receiptdate1: $("#s_receiptdate1").val(),
                receiptdate2: $("#s_receiptdate2").val(),
                keyword: $("#s_keyword").val()
            },
            function(result) {
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
                    $("#actTable").append("<tr class='ttRow'><td colspan='8'>没有数据</td></tr>");
                    blockUIHide("actTable");
                    return;
                }

                $.getJSON("/ajax/ajax_receipt.php",
                        {
                            action: "receiptlist",
                            page: p,
                            pagesize: _pagesize,
                            incometype: $("#s_incometype").val(),
							contributor: $("#s_contributor").val(),
							receiptdate1: $("#s_receiptdate1").val(),
							receiptdate2: $("#s_receiptdate2").val(),
							keyword: $("#s_keyword").val()
                        },
                        function(json) {
                            $(".ttRow").remove();
                            $.each(json, function(i, item) {
                                $("#actTable").append("<tr id='tr" + item.id + "' class='ttRow'><td>" + item.id +
                                        "</td><td>" + item.receiptdate +
                                        "</td><td class='text-primary'>" + item.income +
                                        "</td><td>" + item.incometypeN +
                                        "</td><td class='text-success'>￥" + item.amount +
                                        "</td><td>" + item.contributorN +
                                        "</td><td><button type='button' class='btn btn-warning btn-xs' id='btnMod" + item.id +
                                        "'>修 改</button> <button type='button' class='btn btn-danger btn-xs' id='btnDel" + item.id +
                                        "'>删 除</button> <div id='divMore" + item.id + "' class='alert alert-info divEasing'><div class='top'>备注</div><p>" + item.remark + "</p><p>" + item.createdate + " - " + item.userid + " </p></div></td></tr>");
                                $("#btnMod" + item.id).bind('click', function () {
                                    bindUpdateHidden(item.id, item.income, item.incometype, item.amount, item.receiptdate, item.contributor, item.remark);
                                    $('#modModal').modal('show');
                                    return false;
                                });
                                $("#btnDel" + item.id).bind('click', function () {
                                    bindDeleteHidden(item.id);
                                    $('#delModal').modal('show');
                                    return false;
                                });
                                $("#tr" + item.id).bind('click', function(event) {
                                    var offset = $(event.target).offset();
                                    $("#divMore" + item.id).css({ top: offset.top - $("#actTable").top + $(event.target).outerHeight() + "px", left: $(document).width() - 415 + "px" });
                                    $(".divEasing:visible:not(#divMore" + item.id + ")").hide("fast");
                                    $("#divMore" + item.id).toggle("fast");
                                    return false;
                                });
                            });
                            blockUIHide("actTable");
                        });
            });
}
</script>


