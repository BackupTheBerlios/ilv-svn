<?

if (!defined('IN_ILV')) {
	echo "You cannot access this page directly.\n";
	exit();
};

$module = array (
	"name" => "eggdrop",
	"version" => "0.1",
	"author" => "hangy hannigan" );

$reg_time = "\[\d{2}:\d{2}\]";
$reg_nick = "[\w\d\-\|\[\|\]\|\\\`\^\{\}]{1,30}";
$reg_chan = "\#.{1,31}";

$reg = array (
	"message" => "/($reg_time)\ &lt;($reg_nick)&gt;\ (.*)/",
	"action" => "/($reg_time)\ Action:\ ($reg_nick)\ (.+)/",
	"join" => "/($reg_time)\ ($reg_nick)\ (\(.+@.+\)){0,1}\ {0,1}joined\ ($reg_chan)/",
	"part" => "/($reg_time)\ ($reg_nick)\ (\(.+@.+\))\ left\ ($reg_chan)\ {0,1}\({0,1}[(.*)]{0,1}\){0,1}\./",
	"quit" => "/($reg_time)\ ($reg_nick)\ (\(.+@.+\))\ left\ irc:\ (.*)/",
	"nick" => "/($reg_time)\ Nick\ change:\ ($reg_nick) \-&gt;\ ($reg_nick)/",
	"mode" => "/($reg_time)\ $reg_chan:\ mode\ change\ \'(.*)'\ by\ ($reg_nick\!.+@.+)/",
	"notice" => "/($reg_time)\ (\-$reg_nick:$reg_chan\-)\ (.*)/",
	"topic" => "/($reg_time)\ Topic\ changed\ on\ ($reg_chan)\ by\ ($reg_nick\!.+@.+):\ (.*)/" );

// vim: ts=4

?>
