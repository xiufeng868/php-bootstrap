<?php
require_once('ajax_common.php');

$SAEDB = new SaeMysql();

$action = $_REQUEST['action'];

if ($action === 'addcodegroup') {
	$name = $_REQUEST['name'];
	$code = $_REQUEST['code'];
	$sql = "select count(id) from codegroup where code='{$code}'";
	$count = $SAEDB->getVar($sql);
	
	if ($count > 0) {
		die('2'); //编码已存在
	} else {
		$sql = "insert into codegroup values(null, '{$name}', '{$code}')";
		$SAEDB->runSql('set names UTF8');
		$SAEDB->runSql($sql);
		
		if ($SAEDB->errno() != 0) {
			die('Error: ' . $SAEDB->errmsg());
		}
		
		echo '1';
	}
}

if ($action === 'modcodegroup') {
	$id = $_REQUEST['id'];
	$sql = 'select count(id) from codegroup where id=' . $id;
	$count = $SAEDB->getVar($sql);
	
	if ($count == 0) {
		die('0'); //操作失败
	}
	
	$name = $_REQUEST['name'];
	$code = $_REQUEST['code'];
	$oldcode = $_REQUEST['oldcode'];
	$sql = "update codegroup set name='{$name}', code='{$code}' where id={$id}";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}

	$sql = "update code set codegroup='{$code}' where codegroup='{$oldcode}'";
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
	echo '1';
}

if ($action === 'delcodegroup') {
	$code = $_REQUEST['code'];
	$sql = "select count(id) from code where codegroup='{$code}'";
	$count = $SAEDB->getVar($sql);
	
	if ($count > 0) {
		die('0'); //编码组包含编码无法删除
	}
	
	$id = $_REQUEST['id'];
	$sql = 'delete from codegroup where id=' . $id;
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
    echo '1';
}

if ($action === 'codegrouplistsize') {
	$sql = 'select count(id) from codegroup';
	$count = $SAEDB->getVar($sql);
	echo $count;
}

if ($action === 'codegrouplist') {
	$page = $_REQUEST['page'];
    $pagesize = $_REQUEST['pagesize'];
    
    if ($page > 0) {
    	$page--;
    }
    
    $sql = "select * from codegroup order by id desc limit " . $page*$pagesize . ", " . $pagesize;
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}



if ($action === 'addcode') {
	$code = $_REQUEST['code'];
	$sql="select count(id) from code where code='{$code}'";
	$count = $SAEDB->getVar($sql);
	
	if ($count > 0) {
		die('0'); //编码已存在
	} else {
		$name = $_REQUEST['name'];
		$upcode = $_REQUEST['upcode'];
		$codegroup = $_REQUEST['codegroup'];
		$sql = "insert into code values(null, '{$name}', '{$code}', '{$upcode}', '{$codegroup}')";
		$SAEDB->runSql('set names UTF8');
		$SAEDB->runSql($sql);
		
		if ($SAEDB->errno() != 0) {
			die('Error: ' . $SAEDB->errmsg());
		}
		
		echo '1';
	}
}

if ($action === 'modcode') {
	$id = $_REQUEST['id'];
	$sql = 'select count(id) from code where id=' . $id;
	$count = $SAEDB->getVar($sql);
	
	if ($count == 0) {
		die('0'); //操作失败
	}
	
	$name = $_REQUEST['name'];
	$code = $_REQUEST['code'];
	$oldcode = $_REQUEST['oldcode'];
	$sql = "update code set name='{$name}', code='{$code}' where id={$id}";
	$SAEDB->runSql('set names UTF8');
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}

	$sql = "update code set upcode='{$code}' where upcode='{$oldcode}'";
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
	echo '1';
}

if ($action === 'delcode') {
	$code = $_REQUEST['code'];
	$sql = "select count(id) from code where upcode='{$code}'";
	$count = $SAEDB->getVar($sql);
	
	if ($count > 0) {
		die('0'); //编码下包含编码无法删除
	}
	
	$id = $_REQUEST['id'];
	$sql = 'delete from code where id=' . $id;
	$SAEDB->runSql($sql);
	
	if ($SAEDB->errno() != 0) {
		die('Error: ' . $SAEDB->errmsg());
	}
	
    echo '1';
}

if ($action === 'codelistsize') {
	$upcode = $_REQUEST['upcode'];
	$codegroup = $_REQUEST['codegroup'];
	$sql="select count(id) from code where upcode='{$upcode}'";
	if(!empty($codegroup))
	{
		$sql .= " and codegroup='{$codegroup}'";
	}
	$count = $SAEDB->getVar($sql);
	echo $count;
}

if ($action === 'codelist') {
	$page = $_REQUEST['page'];
	$pagesize = $_REQUEST['pagesize'];
	$upcode = $_REQUEST['upcode'];
	$codegroup = $_REQUEST['codegroup'];
	$field = '';
	$where = '';
	
	if ($page > 0) {
    	$page--;
    }
    
    if ($upcode != '') {
    	$field = ' a.id,a.name,a.code,a.codegroup,b.name as upcode';
    	$where = "(code a left join code b on a.upcode = b.code) where a.upcode='{$upcode}'";
    } else {
		$field = ' a.id,a.name,a.code,b.name as codegroup,a.upcode';
    	$where = "(code a left join codegroup b on a.codegroup = b.code) where a.upcode='{$upcode}'";
   	}
    
   	if ($codegroup != '') {
   		$where .= " and a.codegroup='{$codegroup}'";
   	}
   	
	$sql = 'select ' . $field . ' from ' . $where . ' order by a.id desc limit ' . $page*$pagesize . ', ' . $pagesize;
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}

if ($action === 'allcodelist') {
	$upcode = $_REQUEST['upcode'];
	$codegroup = $_REQUEST['codegroup'];
    
  	$where = "where upcode='{$upcode}'";
	if ($codegroup != '') {
    	    $where .= " and codegroup='{$codegroup}'";
	}
	
	$sql = 'select * from code ' . $where . ' order by id';
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}

if ($action === 'allcodegrouplist') {
	$sql = 'select * from codegroup order by id';
    $result = $SAEDB->getData($sql);
    
    echo json_encode($result);
}

$SAEDB->closeDb();
?>