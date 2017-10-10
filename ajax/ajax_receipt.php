<?php
require_once('ajax_common.php');

$SAEDB = new SaeMysql();

$action = strip_tags($_REQUEST['action']);

if ($action === 'addreceipt') {
	session_start();
	$sql = "insert into receipt values(null, '{$_REQUEST['income']}', '{$_REQUEST['incometype']}',
											 '{$_REQUEST['amount']}', '{$_REQUEST['receiptdate']}', 
											 '{$_REQUEST['contributor']}', '{$_REQUEST['remark']}', 
											 '{$_SESSION['userid']}', now(), now())";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
		
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
		
	echo '1';
}

if ($action === 'modreceipt') {
	session_start();
	$sql = "update receipt set income='{$_REQUEST['income']}', incometype='{$_REQUEST['incometype']}',
							   amount='{$_REQUEST['amount']}', receiptdate='{$_REQUEST['receiptdate']}', 
							   contributor='{$_REQUEST['contributor']}', remark='{$_REQUEST['remark']}', 
							   userid='{$_SESSION['userid']}', updatedate=now() where id={$_REQUEST['id']}";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
		
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
		
	echo '1';
}

if ($action === 'delreceipt') {
	$sql = 'delete from receipt where id=' . $_REQUEST['id'];
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
    echo '1';
}

if ($action === 'receiptlistsize') {
	$incometype = $_REQUEST['incometype'];
	$contributor = $_REQUEST['contributor'];
	$receiptdate1 = $_REQUEST['receiptdate1'];
	$receiptdate2 = $_REQUEST['receiptdate2'];
	$keyword = $_REQUEST['keyword'];
		
	$where = ' where 1=1';
	if ($incometype != '') { 
		$where .= " and incometype='{$incometype}'";
	}
	if ($contributor != '') { 
		$where .= " and contributor='{$contributor}'";
	}
	if ($receiptdate1 != '' && $receiptdate2 != '') { 
		$where .= " and unix_timestamp(receiptdate) between unix_timestamp('{$receiptdate1}') and unix_timestamp('{$receiptdate2}')";
	}
	if ($keyword != '') { 
		$where .= " and (income like '%{$keyword}%' or remark like '%{$keyword}%')";
	}
	
	$sql = 'select count(id) from receipt' . $where;
	$count = $SAEDB->getVar($sql);
	echo $count;
}

if ($action === 'receiptlist') {
	$page = $_REQUEST['page'];
    $pagesize = $_REQUEST['pagesize'];
    	
	$incometype = $_REQUEST['incometype'];
	$contributor = $_REQUEST['contributor'];
	$receiptdate1 = $_REQUEST['receiptdate1'];
	$receiptdate2 = $_REQUEST['receiptdate2'];
	$keyword = $_REQUEST['keyword'];
		
	$where = ' where 1=1';
	if ($incometype != '') { 
		$where .= " and incometype='{$incometype}'";
	}
	if ($contributor != '') { 
		$where .= " and contributor='{$contributor}'";
	}
	if ($receiptdate1 != '' && $receiptdate2 != '') { 
		$where .= " and unix_timestamp(receiptdate) between unix_timestamp('{$receiptdate1}') and unix_timestamp('{$receiptdate2}')";
	}
	if ($keyword != '') { 
		$where .= " and (income like '%{$keyword}%' or remark like '%{$keyword}%')";
	}
	
	if ($page > 0) {
    	$page--;
    }
    
    $sql = "select 
    			a.id,
    			a.income,
				b.name as incometypeN,
				a.incometype,
    			a.amount,
    			date_format(a.receiptdate,'%Y-%m-%d') as receiptdate,
    			c.name as contributorN,
				a.contributor,
    			a.remark,
    			f.username as userid,
    			a.createdate,
    			a.updatedate 
    		from
                receipt as a
    			left join code as b on a.incometype=b.code 
    			left join code as c on a.contributor=c.code 
    			left join `user` as f on a.userid=f.id 
    		{$where} 
    		order by a.receiptdate desc,
    				 a.id desc 
    		limit " . $page*$pagesize . ", " . $pagesize;		
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}

$SAEDB->closeDb();
?>