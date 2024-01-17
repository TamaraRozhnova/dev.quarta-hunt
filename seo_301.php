<?
	
	$f = @file($_SERVER['DOCUMENT_ROOT'].'/301.csv');
	
	if(!empty($f))
	foreach($f AS $v){
		$a = explode(';', $v);
		$a[0] = trim($a[0]);
		$a[1] = trim($a[1]);
		$a[0] = str_replace("%2F" , '/', rawurlencode($a[0])); // для кириллицы и слешей
		if(empty($a[0])) continue;
		$r301[$a[0]] = $a[1];
		
	}
	
	$REQUEST_URI = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	
	if(!empty($_SERVER['REQUEST_URI'])) {
	
		if(!empty($r301))
		foreach($r301 AS $k=>$v){
			if($REQUEST_URI == $k AND $REQUEST_URI != $v){
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: https://".$_SERVER['SERVER_NAME'].$v."".(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '' ));
				exit();
			}
		}
		
		if( !empty(strpos(' '.$_SERVER['REQUEST_URI'], '/product/'))){
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: https://".$_SERVER['SERVER_NAME'] . str_replace('/product/', '/catalog/', $_SERVER['REQUEST_URI']) );
			exit();
		}
		
	}


