<?php
require_once('ajax_common.php');

$SAEDB = new SaeMysql();

$action = strip_tags($_REQUEST['action']);

if ($action === 'addpayment') {
	session_start();
	$sql = "insert into payment values(null, '{$_REQUEST['paymode']}', '{$_REQUEST['expend']}',
											 '{$_REQUEST['expendtype1']}', '{$_REQUEST['expendtype2']}', 
											 '{$_REQUEST['amount']}', '{$_REQUEST['paydate']}', 
											 '{$_REQUEST['benefitguy']}', '{$_REQUEST['remark']}', 
											 '{$_SESSION['userid']}', now(), now())";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
		
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
		
	echo '1';
}

if ($action === 'modpayment') {
	session_start();
	$sql = "update payment set paymode='{$_REQUEST['paymode']}', expend='{$_REQUEST['expend']}',
							   expendtype1='{$_REQUEST['expendtype1']}', expendtype2='{$_REQUEST['expendtype2']}', 
							   amount='{$_REQUEST['amount']}', paydate='{$_REQUEST['paydate']}', 
							   benefitguy='{$_REQUEST['benefitguy']}', remark='{$_REQUEST['remark']}', 
							   userid='{$_SESSION['userid']}', updatedate=now() where id={$_REQUEST['id']}";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
		
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
		
	echo '1';
}

if ($action === 'delpayment') {
	$sql = 'delete from payment where id=' . $_REQUEST['id'];
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
    echo '1';
}

if ($action === 'paymentlistsize') {
	$expendtype1 = $_REQUEST['expendtype1'];
	$expendtype2 = $_REQUEST['expendtype2'];
	$paymode = $_REQUEST['paymode'];
	$benefitguy = $_REQUEST['benefitguy'];
	$paydate1 = $_REQUEST['paydate1'];
	$paydate2 = $_REQUEST['paydate2'];
	$keyword = $_REQUEST['keyword'];
		
	$where = ' where 1=1';
	if ($expendtype1 != '') { 
		$where .= " and expendtype1='{$expendtype1}'";
	}
	if ($expendtype2 != '') { 
		$where .= " and expendtype2='{$expendtype2}'";
	}
	if ($paymode != '') { 
		$where .= " and paymode='{$paymode}'";
	}
	if ($benefitguy != '') { 
		$where .= " and benefitguy='{$benefitguy}'";
	}
	if ($paydate1 != '' && $paydate2 != '') { 
		$where .= " and unix_timestamp(paydate) between unix_timestamp('{$paydate1}') and unix_timestamp('{$paydate2}')";
	}
	if ($keyword != '') { 
		$where .= " and (expend like '%{$keyword}%' or remark like '%{$keyword}%')";
	}
	
	$sql = 'select count(id) from payment' . $where;
	$count = $SAEDB->getVar($sql);
	echo $count;
}

if ($action === 'paymentlist') {
	$page = $_REQUEST['page'];
    $pagesize = $_REQUEST['pagesize'];
    	
	$expendtype1 = $_REQUEST['expendtype1'];
	$expendtype2 = $_REQUEST['expendtype2'];
	$paymode = $_REQUEST['paymode'];
	$benefitguy = $_REQUEST['benefitguy'];
	$paydate1 = $_REQUEST['paydate1'];
	$paydate2 = $_REQUEST['paydate2'];
	$keyword = $_REQUEST['keyword'];
		
	$where = ' where 1=1';
	if ($expendtype1 != '') { 
		$where .= " and a.expendtype1='{$expendtype1}'";
	}
	if ($expendtype2 != '') { 
		$where .= " and a.expendtype2='{$expendtype2}'";
	}
	if ($paymode != '') { 
		$where .= " and a.paymode='{$paymode}'";
	}
	if ($benefitguy != '') { 
		$where .= " and a.benefitguy='{$benefitguy}'";
	}
	if ($paydate1 != '' && $paydate2 != '') { 
		$where .= " and unix_timestamp(a.paydate) between unix_timestamp('{$paydate1}') and unix_timestamp('{$paydate2}')";
	}
	if ($keyword != '') { 
		$where .= " and (a.expend like '%{$keyword}%' or a.remark like '%{$keyword}%')";
	}
	
	if ($page > 0) {
    	$page--;
    }
    
    $sql = "select 
    			a.id,
    			b.name as paymodeN,
    			a.paymode,
    			a.expend,
    			c.name as expendtype1N,
    			a.expendtype1,
    			d.name as expendtype2N,
    			a.expendtype2,
    			a.amount,
    			date_format(a.paydate,'%Y-%m-%d') as paydate,
    			e.name as benefitguyN,
    			a.benefitguy,
    			a.remark,
    			f.username as userid,
    			a.createdate,
    			a.updatedate 
    		from
                payment as a
    			left join code as b on a.paymode=b.code 
    			left join code as c on a.expendtype1=c.code 
    			left join code as d on a.expendtype2=d.code 
    			left join code as e on a.benefitguy=e.code 
    			left join `user` as f on a.userid=f.id 
    		{$where} 
    		order by a.paydate desc,
    				 a.id desc 
    		limit " . $page*$pagesize . ", " . $pagesize;		
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}

$SAEDB->closeDb();
?>