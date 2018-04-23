<?php
     include_once("config.inc.php");
	 
	 exec("sudo -u root tail -n ".$LOGROWS." ".$LOGFILE,$tmp,$tmpout);
     foreach ($tmp as $a){
		foreach ($REDWORDS as $keyword){
		    $a=str_ireplace($keyword,"<label style='color:red'>".$keyword."</label>",$a);
        }
		foreach ($GREENWORDS as $keyword){
		    $a=str_ireplace($keyword,"<label style='color:green'>".$keyword."</label>",$a);
        }	
        echo $a."</br>";
     } 
	 echo '<script language="javascript">
var x=parent.document.getElementById("bottom").contentWindow.document;
x.body.scrollTop= x.body.offsetHeight;
</script>';

?>