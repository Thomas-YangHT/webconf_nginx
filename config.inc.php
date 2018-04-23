<?php 
    //设置时区
    date_default_timezone_set("PRC");
    //配置项
	$DC_NAME="mynginx";
	$DH_IP="192.168.100.222";
	$DIR="/etc/nginx/";
	$CONF=$DIR."conf.d/\*conf";
	$DEFAULT_FILE="nginx.conf";
	$LOGFILE="/usr/share/nginx/html/adm/ngxconf/ngxconf.log";
	$LOGROWS=100;
	$CMD_STATUS="sudo -u root ssh ".$DH_IP." docker ps -a --format \"{{.Names}}\;{{.Status}}\;{{.Ports}}\"|grep ".$DC_NAME;
	$CMD_TEST="sudo -u root nginx -t 2>&1";
	$CMD_RESTART="sudo -u root ssh ".$DH_IP." docker restart ".$DC_NAME." 2>&1";
	$REDWORDS=array("error","fail","timeout","disconnect","err","lost","stop","deny","denied","exit");
	$GREENWORDS=array("ok","success","start"," connect","up",$DC_NAME);
	
function GET_STATUS(){
	global $CMD_STATUS;
	global $LOGFILE;
	global $STATUS;
	global $DC_NAME;
	exec($CMD_STATUS,$tmp,$tmpout);
	foreach ($tmp as $a){
        $test_res.=" ".$a."\n";
    }
	$arr=explode(";",$test_res);
	$STATUS=$arr[1];
	if( stripos($STATUS,"Exit")===false ){
		echo "<li><label style='color:green'>".$STATUS."</label></li>";	
	}else{
		echo "<li><label style='color:red'>".$STATUS."</label></li>";	
	}
    echo "<script>document.title='".$DC_NAME."';</script>"; 
	exec("sudo -u root  echo \"".$test_res."\" >>".$LOGFILE,$tmp2,$tmpout); 	
}
?>