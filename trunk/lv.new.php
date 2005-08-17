<?

// Calculating execution time. First mark

$time = explode(' ', microtime());
$time = $time[1] + $time[0];
$start = $time;

// For access to other scripts

define("IN_ILV", "YES");

// Loading configuration

require('config.php');

// Load module with regular expressions

if (file_exists("modules/" . $config[type] . ".php"))
	require("modules/" . $config[type] . ".php");
else {
	// No such module
	echo $config['type'] . ".php not found.\n";
	exit();
};

// Function for parity check

function parcheck($x) {
	$result = $x%2;
	if ($result === 0)
		return 0;
	else
		return 1;
};

$linec = 0;

$file = "logs/" . $_GET['log'];

echo "<html>\n";
echo "<head>\n";
echo "<style type=\"text/css\">\n";
echo "\ttable.test { font-family: verdana; }\n";
echo "\tth.message { text-align: right; vertical-align: top; color: #7f7f7f; border-right: solid gray 2px; }\n";
echo "\tth.action { text-align: right; vertical-align: top; color: #9c009c; border-right: solid gray 2px; }\n";
echo "\tth.notice { text-align: right; vertical-align: top; color: " . $color[notice] . "; border-right: solid gray 2px; }\n";
echo "\tth.quit { text-align: right; vertical-align: top; color: " . $color[quit] . "; border-right: solid gray 2px; }\n";
echo "\tth.join { text-align: right; vertical-align: top; color: " . $color[join] . "; border-right: solid gray 2px; }\n";
echo "\tth.part { text-align: right; vertical-align: top; color: " . $color[part] . "; border-right: solid gray 2px; }\n";
echo "\tth.nickch { text-align: right; vertical-align: top; color: " . $color[nickch] . "; border-right: solid gray 2px; }\n";
echo "\tth.mode { text-align: right; vertical-align: top; color: " . $color[mode] . "; border-right: solid gray 2px; }\n";
echo "\tth.topic { text-align: right; vertical-align: top; color: " . $color[topic] . "; border-right: solid gray 2px; }\n";
echo "</style>\n";
echo "<title>#dev.ru log " . $_GET['log'] . "</title>\n";
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=KOI8-R\">\n";
echo "</head>\n";
echo "<body bgcolor=\"white\">\n";
echo "<table class=\"test\" cellspacing=\"0\" width=\"100%\">\n";

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
		//
		if (parcheck($linec++))
			$bgcolor = $config['bgcolor1'];
		else
			$bgcolor = $config['bgcolor0'];
	$buffer = preg_replace("`((http)+(s)?:(//)|(www\.))((\w|\.|\-|_)+)(/)?(\S+)?`i", "<a href=\"http\\3://\\5\\6\\8\\9\">\\1\\5\\6/\\9</a>", $buffer);
	switch ($buffer) {
	case (preg_match($reg['message'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"message\">" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['text'] . "\">" . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['action'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"action\">*&nbsp;" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['action'] . "\">" . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['join'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr width=\"100%\" bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"join\">----&gt;</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['join'] . "\">" . $matches[2] . " " . $matches [3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['part'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"part\">&lt;----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['part'] ."\">" . $matches[2] . " " . $matches[3] . "&nbsp;has&nbsp;left&nbsp;" . $matches[4] . "&nbsp;(" . $matches[5] . ")</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['quit'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"quit\">&lt;----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['quit'] ."\">" . $matches[2] . " " . $matches[3] . "&nbsp;" . $matches[4] . "</font></td>\n"
		. "<td valign=\"top\"><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['nick'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr valign=\"top\" bgcolor=\"" . $bgcolor . "\"><th class=\"nickch\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['nickch'] ."\">" . $matches[2] . " is now known as " . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['mode'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"mode\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['mode'] ."\">mode " . $matches[2] . " by " . $matches[3] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['notice'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=" . $bgcolor . " valign=\"top\"><th class=\"notice\">" . $matches[2] . "</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['notice'] ."\">" . $matches[3] . "</font></td>\n"
		. "<td valign=\"top\"><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;

	case (preg_match($reg['topic'], $buffer, $matches)?$buffer:!$buffer):
		$text = "<tr bgcolor=\"" . $bgcolor . "\" valign=\"top\"><th class=\"topic\">-----</th>\n"
		. "<td width=\"100%\"><font color=\"" . $color['topic'] ."\">Topic changed on " . $matches[2] . " by " . $matches[3] . ": " . $matches[4] . "</font></td>\n"
		. "<td><font color=\"" . $color['time'] . "\">" . $matches[1] . "</font></td></tr>\n";
		echo $text;
		break;
	}
	
};
};

fclose($handle);

// Calculating execution time. Second mark

$time = explode(' ', microtime());
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 6);

echo "<tr bgcolor=\"" . $config['endline'] . "\" align=\"center\" valign=\"top\"><td><a href=\"/\">Calendar</a></td><td>Execution time: " . $total_time . " seconds</td><td><a href=\"about.php\">About</a></td></tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";

?>
