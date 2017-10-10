<?php
require_once('../session.php');
include('../header.php');
?>

    <!-- Begin page content -->
    <div class="container">
        <h5>支出明细</h5>
        <div id="searchPanel" class="well well-sm">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <input id="s_paydate1" type="text" class="form-control input-sm" placeholder="开始时间" />
                </div>
                <div class="form-group">
                    <input id="s_paydate2" type="text" class="form-control input-sm"placeholder="结束时间" />
                </div>
                <div class="form-group">
                    <select id="s_expendtype1" class="form-control input-sm">
                        <option value=''>支出类别</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="s_expendtype2" class="form-control input-sm">
                        <option value=''>子类别</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="s_paymode" class="form-control input-sm">
                        <option value=''>支付方式</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="s_benefitguy" class="form-control input-sm">
                        <option value=''>受益人</option>
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
                <th width="5%">ID</th>
                <th width="8%">日期</th>
                <th width="25%">名称</th>
                <th width="18%">类别</th>
                <th width="10%">金额</th>
                <th width="12%">支付方式</th>
                <th width="10%">受益人</th>
                <th width="12%"></th>
            </tr>
            </thead>
        </table>

        <div class="row btnPanel">
            <div class="col-lg-1">
                <button id="btnCreate" type="button" class="btn btn-primary">新建明细</button>
            </div>
            <div class="col-lg-1">
                <a href="/account/payment.php" class="btn btn-primary" role="button">全部明细</a>
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
                                onclick="javascript:deletePayment();">删 除</button>
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
                                <label for="paydate" class="col-sm-3 control-label">支付日期</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="paydate" placeholder="支付日期" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expend" class="col-sm-3 control-label">支出名称</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="expend" placeholder="支出名称" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-sm-3 control-label">支付金额</label>
                                <div class="col-sm-8">
                                    <input class="form-control input-sm" id="amount" placeholder="支付金额" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expendtype1" class="col-sm-3 control-label">支出类别</label>
                                <div class="col-sm-4">
                                    <select class="form-control input-sm" id="expendtype1">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control input-sm" id="expendtype2">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="paymode" class="col-sm-3 control-label">支付方式</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" id="paymode">
                                        <option value=''>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="benefitguy" class="col-sm-3 control-label">受益人</label>
                                <div class="col-sm-8">
                                    <select id="benefitguy" class="form-control input-sm">
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
                                onclick="javascript:updatePayment();">修 改</button>
                        <button type='button' id="btnInsert" class="btn btn-primary" data-loading-text="保存中..."
                                onclick="javascript:insertPayment();">保 存</button>
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
    activeNav("nav1");

    initDDL("allcodelist", "001", "", "s_expendtype1", "s_expendtype2");
    initDDL("allcodelist", "", "02", "s_paymode", null);
    initDDL("allcodelist", "", "01", "s_benefitguy", null);

    initDDL("allcodelist", "001", "", "expendtype1", "expendtype2");
    initDDL("allcodelist", "", "02", "paymode", null);
    initDDL("allcodelist", "", "01", "benefitguy", null);

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
        $("#s_expendtype1").val('');
        $("#s_expendtype2").val('');
        $("#s_paymode").val('');
        $("#s_benefitguy").val('');
        $("#s_paydate1").val('');
        $("#s_paydate2").val('');
        $("#s_keyword").val('');
    });
    $("#s_paydate1").bind('click', function () {
        WdatePicker();
    });
    $("#s_paydate2").bind('click', function () {
        WdatePicker();
    });
    $("#paydate").bind('click', function () {
        WdatePicker();
    });
    $("#btnOpenSearch").bind('click', function () {
        $("#searchPanel").slideToggle("fast");
    });
});

function checkform() {
    var paydate = $("#paydate");
    if (paydate.val() == '') {
        paydate.focus();
        myAlert("支付日期不能为空", "alertMod", true);
        return false;
    }
    var expend = $("#expend");
    if (expend.val() == '') {
        expend.focus();
        myAlert("支出名称不能为空", "alertMod", true);
        return false;
    }
    var amount = $("#amount");
    if (amount.val() == '') {
        amount.focus();
        myAlert("支付金额不能为空", "alertMod", true);
        return false;
    }
    if (isNaN(amount.val())) {
        amount.focus();
        myAlert("支付金额不是数字", "alertMod", true);
        return false;
    }
    if (amount.val() < 0) {
        amount.focus();
        myAlert("支付金额不能是负数", "alertMod", true);
        return false;
    }
    var expendtype2 = $("#expendtype2");
    if (expendtype2.val() == '') {
        expendtype2.focus();
        myAlert("支出类别不能为空", "alertMod", true);
        return false;
    }
    var paymode = $("#paymode");
    if (paymode.val() == '') {
        paymode.focus();
        myAlert("支付方式不能为空", "alertMod", true);
        return false;
    }
    var benefitguy = $("#benefitguy");
    if (benefitguy.val() == '') {
        benefitguy.focus();
        myAlert("受益人不能为空", "alertMod", true);
        return false;
    }
    return true;
}

// insert
function insertPayment() {
    if (checkform()) {
        $("#btnInsert").button('loading');
        $.post("/ajax/ajax_payment.php",
                {
                    action: "addpayment",
                    paymode: $("#paymode").val(),
                    expend: $("#expend").val(),
                    expendtype1: $("#expendtype1").val(),
                    expendtype2: $("#expendtype2").val(),
                    amount: $("#amount").val(),
                    paydate: $("#paydate").val(),
                    benefitguy: $("#benefitguy").val(),
                    remark: $("#remark").val()
                },
                function(result) {
                    if (result==1) {
                        myAlert("保存成功", "alertMod", false);
                        $("#expend").val("");
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
function bindUpdateHidden(id, paymode, expend, expendtype1, expendtype2, amount, paydate, benefitguy, remark) {
    $("#cid").val(id);
    $("#paydate").val(paydate);
    $("#expend").val(expend);
    $("#amount").val(amount);
    $("#expendtype1").val(expendtype1);
    initDDL("allcodelist", "", expendtype1, "expendtype2", null, expendtype2, null);
    $("#paymode").val(paymode);
    $("#benefitguy").val(benefitguy);
    $("#remark").val(remark);

    $("#btnUpdate").show();
    $("#btnInsert").hide();
}
function updatePayment() {
    if (checkform()) {
        $("#btnUpdate").button('loading');
        $.post("/ajax/ajax_payment.php",
                {
                    action: "modpayment",
                    id: $("#cid").val(),
                    paymode: $("#paymode").val(),
                    expend: $("#expend").val(),
                    expendtype1: $("#expendtype1").val(),
                    expendtype2: $("#expendtype2").val(),
                    amount: $("#amount").val(),
                    paydate: $("#paydate").val(),
                    benefitguy: $("#benefitguy").val(),
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
function deletePayment() {
    $("#btnDelete").button('loading');
    $.post("/ajax/ajax_payment.php",
            {
                action: "delpayment",
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
    $.post("/ajax/ajax_payment.php",
            {
                action: "paymentlistsize",
                expendtype1: $("#s_expendtype1").val(),
                expendtype2: $("#s_expendtype2").val(),
                paymode: $("#s_paymode").val(),
                benefitguy: $("#s_benefitguy").val(),
                paydate1: $("#s_paydate1").val(),
                paydate2: $("#s_paydate2").val(),
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

                $.getJSON("/ajax/ajax_payment.php",
                        {
                            action: "paymentlist",
                            page: p,
                            pagesize: _pagesize,
                            expendtype1: $("#s_expendtype1").val(),
                            expendtype2: $("#s_expendtype2").val(),
                            paymode: $("#s_paymode").val(),
                            benefitguy: $("#s_benefitguy").val(),
                            paydate1: $("#s_paydate1").val(),
                            paydate2: $("#s_paydate2").val(),
                            keyword: $("#s_keyword").val()
                        },
                        function(json) {
                            $(".ttRow").remove();
                            $.each(json, function(i, item) {
                                $("#actTable").append("<tr id='tr" + item.id + "' class='ttRow'><td>" + item.id +
                                        "</td><td>" + item.paydate +
                                        "</td><td class='text-primary'>" + item.expend +
                                        "</td><td>" + item.expendtype1N + " - " + item.expendtype2N +
                                        "</td><td class='text-danger'>￥" + item.amount +
                                        "</td><td>" + item.paymodeN +
                                        "</td><td>" + item.benefitguyN +
                                        "</td><td><button type='button' class='btn btn-warning btn-xs' id='btnMod" + item.id +
                                        "'>修 改</button> <button type='button' class='btn btn-danger btn-xs' id='btnDel" + item.id +
                                        "'>删 除</button> <div id='divMore" + item.id + "' class='alert alert-info divEasing'><div class='top'>备注</div><p>" + item.remark + "</p><p>" + item.createdate + " - " + item.userid + " </p></div></td></tr>");
                                $("#btnMod" + item.id).bind('click', function () {
                                    bindUpdateHidden(item.id, item.paymode, item.expend, item.expendtype1, item.expendtype2, item.amount, item.paydate, item.benefitguy, item.remark);
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


