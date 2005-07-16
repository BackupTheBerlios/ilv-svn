<?

// $Id$

// Calculating execution time. First mark

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// For access to other scripts

define("IN_ILV", "YES");

// Copyrights :-)

$ilv = array (
	"version" => "0.1",
	"autor" => "hangy hannigan" );

// Loading configuration

$config = array();

require('config.php');

//

$linec = 0;

// Checking configuration

if (!isset($config['type']) || !isset($color)) {
	echo "Fix errors in config.php and try again.\n";
	exit();
};

// Load module with regular expressions

if (file_exists("modules/" . $config[type] . ".php"))
	require("modules/" . $config[type] . ".php");
else {
	// No such module
	echo $config['type'] . ".php not found.\n";
	exit();
};

// Function for parity check

function result($x) {
	$result=$x%2;
	if ($result === 0)
		return 0;
	else
		return 1;
};

$file = "logs/" . $_GET['log'];

echo "<html>
<head>
<style type=\"text/css\">
	table.test { font-family: verdana; }
	th.message { text-align: right; vertical-align: top; color: #7f7f7f; border-right: solid gray 2px; }
	th.action { text-align: right; vertical-align: top; color: #9c009c; border-right: solid gray 2px; }
	th.notice { text-align: right; vertical-align: top; color: " . $color[notice] . "; border-right: solid gray 2px; }
	th.quit { text-align: right; vertical-align: top; color: " . $color[quit] . "; border-right: solid gray 2px; }
	th.join { text-align: right; vertical-align: top; color: " . $color[join] . "; border-right: solid gray 2px; }
	th.part { text-align: right; vertical-align: top; color: " . $color[part] . "; border-right: solid gray 2px; }
	th.nickch { text-align: right; vertical-align: top; color: " . $color[nickch] . "; border-right: solid gray 2px; }
	th.mode { text-align: right; vertical-align: top; color: " . $color[mode] . "; border-right: solid gray 2px; }
	th.topic { text-align: right; vertical-align: top; color: " . $color[topic] . "; border-right: solid gray 2px; }
</style>
<title>#dev.ru log</title>
<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=KOI8-R\">
</head>
<body bgcolor=\"white\">
<table class=\"test\" cellspacing=\"0\" width=\"100%\">\n";

// Remove "bad" symbols; bold, underline and color text

$search = array ("'<'", "'>'", "''", "''", "''");
$replace = array ("&lt;", "&gt;", "", "", "");

if (!$handle = @fopen($file, "r")) {
	echo "Couldn't open file " . $_GET['log'] . ".\n";
	exit();
} else {
$size = filesize($file);
while (!feof($handle)) {
	// Parsing starts here
	$buffer = preg_replace("'&'", "&amp;", fgets($handle, $size));
	$buffer = preg_replace($search, $replace, $buffer);
	if (preg_match($reg['message'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"message\">" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['text'] . "\">" . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['action'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"action\">*&nbsp;" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['action'] . "\">" . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['join'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr width=\"100%\" bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"join\">----&gt;</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['join'] . "\">" . $matches[2] . " " . $matches [3] . "</font></td>\n"
		. "<td valign=\"top\"><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['part'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"part\">&lt;----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['part'] ."\">" . $matches[2] . " " . $matches[3] . "&nbsp;has&nbsp;left&nbsp;" . $matches[4] . "&nbsp;(" . $matches[5] . ")</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['quit'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"quit\">&lt;----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['quit'] ."\">" . $matches[2] . " " . $matches[3] . "&nbsp;" . $matches[4] . "</font></td>\n"
		. "<td valign=\"top\"><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};
	if (preg_match($reg['nick'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr valign=\"top\" bgcolor=\"" . $bgcolor . "\"><th class=\"nickch\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['nickch'] ."\">" . $matches[2] . " is now known as " . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};
	if (preg_match($reg['mode'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"mode\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['mode'] ."\">mode " . $matches[2] . " by " . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['notice'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"notice\">" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['notice'] ."\">" . $matches[3] . "</font></td>\n"
		. "<td valign=\"top\"><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};

	if (preg_match($reg['topic'], $buffer, $matches)) {
		if (result($linec++) == 0)
			$bgcolor = "#ccccff";
		else
			$bgcolor = "#ffffff";
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"topic\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['topic'] ."\">Topic changed on " . $matches[2] . " by " . $matches[3] . ": " . $matches[4] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
	};
};
};

fclose($handle);

// Calculating execution time. Second mark

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 6);

echo "<tr bgcolor=\"#f08080\" align=\"center\" valign=\"top\"><td colspan=\"3\">Execution time: " . $total_time . " seconds</td></tr>\n";
echo "</table></body></html>\n";

?>
