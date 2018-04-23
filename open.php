<?php 	
function  show_fileedit($filename){	
     global $F;	 
	 exec("sudo -u root cat ".$filename,$tmp,$tmpout);
     foreach ($tmp as $a){
        $filetext.=$a."\n";
     } 
	 //echo "filetext:".$filetext;
	 echo "<form name='edit' action='' method='post'  >\n";
	 echo " <input type='hidden'  name='file' value='".$F."' /> \n";
	 echo "<input name='save' class='shiny-blue' type='submit' value='  保存  ' /> ";
	 echo '<button type="submit" name="test" value="test" >&nbsp&nbsp&nbsp&nbsp测试&nbsp&nbsp&nbsp&nbsp</button>';
     echo '<button type="submit" name="restart" value="restart" >&nbsp&nbsp&nbsp&nbsp重启&nbsp&nbsp&nbsp&nbsp</button></br>';
	 echo "<textarea name='editfile' id='editfile' rows='40' cols='200' class='text' >".$filetext."</textarea>\n";
     echo "</form>  \n";
}	

function save($file,$contents){
	if( file_exists($file) ) {
		exec("sudo -u root chmod 666 ".$file,$tmp2,$tmpout);
	}	
	$fp = fopen($file, "w");      
    if($fp) {                              
        fwrite($fp,$contents);                              
    }else {                                 
        echo "打开文件失败:".$file;
    }
    fclose($fp); 	 
}

function test(){
	global $LOGFILE;
	global $CMD_TEST;
	if( !file_exists($LOGFILE) ) {
		exec("sudo -u root touch ".$LOGFILE,$tmp2,$tmpout);
		exec("sudo -u root chmod 666 ".$LOGFILE,$tmp2,$tmpout);
	}	
	exec($CMD_TEST,$tmp,$tmpout);
	foreach ($tmp as $a){
        $test_res.=$a."\n";
    }
	exec("sudo -u root  echo \"".$test_res."\" >>".$LOGFILE,$tmp2,$tmpout);  	
}

function restart(){
	global $LOGFILE;
	global $CMD_RESTART;
	exec($CMD_RESTART,$tmp,$tmpout);
	foreach ($tmp as $a){
        $start_res.=$a."\n";
    }
	exec("sudo -u root  echo \"".$start_res."\" >>".$LOGFILE,$tmp2,$tmpout); 	
}

function refresh_log(){
	echo '<script language="javascript"> window.parent.frames["botframe"].location.reload(true);</script >';
	echo '<script language="JavaScript">   parent.botframe.location.reload(); </script>';
}
//----------START--------------
    include_once("config.inc.php");
	
    $S=$_REQUEST["save"];
    $T=$_REQUEST["test"];
    $R=$_REQUEST["restart"];
    $EDIT_CONTENT=$_REQUEST["editfile"];
	$F=$_REQUEST['file'];
	
	if( !empty($F)&&($F!=$DEFAULT_FILE) ){
		$file=$DIR."conf.d/".$_REQUEST['file'];
	}else{
		$file=$DIR.$DEFAULT_FILE;
		$F=$DEFAULT_FILE;
	}
	
	echo $file;
    if( !empty($S) ){
		echo "save";
		save($file,$EDIT_CONTENT);
	}elseif( !empty($T) ){
		echo "save&test";
		save($file,$EDIT_CONTENT);
		test();
		refresh_log();
	}elseif( !empty($R) ){
	    echo "save&test&restart";
		save($file,$EDIT_CONTENT);
		test();
		restart();
		refresh_log();
	}
	show_fileedit($file);
?>
