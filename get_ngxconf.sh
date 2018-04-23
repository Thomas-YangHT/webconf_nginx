cd /usr/bin
ls $1 |grep -Po ".*\/\K.*" |awk '{print "<li><a href=\"open.php?file="$0"\"  target=\"upframe\">"$0"</a> </li>"}'