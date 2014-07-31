<?php
$spwd=$_POST["key"];
if ($spwd != '31d860f7-6f7f-48d3-97b3-8407d5083f34') {
        exit('Wrong key!');
}
$iid=$_POST["iid"];
$pip=$_POST["pip"];
$hostname=$_POST["hostname"];
if ($iid==""||$pip==""||$hostname=="") {
    echo "Some args is null!";
    echo "iid: $iid, pip: $pip, hostname: $hostname";
    exit;
}
$dir="/etc/nagios3/servers/";
$file="${dir}/${hostname}.cfg";
if (file_exists("${file}")) {
    echo "Config file exist! Changing config file...";
    $ofile=$file;
    $wfile=$file;
}else {
    echo "Config file not exist! Generating config file...";
    $ofile="${dir}/TEMPLATE";
    $wfile=$file;
    
}
$ofp=fopen($ofile,'r');
$ncont="";
while (!feof($ofp))
{
    $buffer=fgets($ofp,4096);
    $buffer=preg_replace("/(\s+host_name)\s+.*/","$1\t\t\t$hostname",$buffer);
    $buffer=preg_replace("/(\s+alias)\s+.*/","$1\t\t\t$iid",$buffer);
    $buffer=preg_replace("/(\s+address)\s+.*/","$1\t\t\t$pip",$buffer);
#    echo "$buffer<br/>\n";
    $ncont.=$buffer;
}
fclose($ofp);
$wfp=fopen($wfile,'w');
fwrite($wfp,$ncont);
fclose($wfp);
echo exec("/etc/init.d/nagios3 reload");
echo "Updata config file success!";
?>

