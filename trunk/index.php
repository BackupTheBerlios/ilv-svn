<?

// $Id$

echo "<html>
<head>
<title>Calendar</title>
</head>
<center>"
echo date("Y")."\n";
?>
<table cellpadding="5" cellspacing="1">
<tr>
<?

$logs = "/home/eggdrop/www/devru.irssi.ru/logs/";

$month = array (
	1 => "������",
	2 => "�������",
	3 => "����",
	4 => "������",
	5 => "���",
	6 => "����",
	7 => "����",
	8 => "������",
	9 => "��������",
	10 => "�������",
	11 => "������",
	12 => "�������" );

$month2 = array (
	1 => "Jan",
	2 => "Feb",
	3 => "Mar",
	4 => "Apr",
	5 => "May",
	6 => "Jun",
	7 => "Jul",
	8 => "Aug",
	9 => "Sep",
	10 => "Oct",
	11 => "Nov",
	12 => "Dec" );

function showday($dw) {
	global $i, $logs, $log;

	if ($dw == 2 && $i == 1)
		echo "<td></td>\n";
	elseif ($i == 1 && $dw != 1)
			echo "<td colspan=\"" . ($dw - 1) . "\"></td>\n";
	if (file_exists($logs . $log))
		echo "<td><a href=\"lv.php?log=" . $log . "\">" . $i . "</a></td>\n";
	else
		echo "<td>" . $i . "</td>\n";
};

$year = date("Y");

for ($monthNum = 1; $monthNum <= 12; $monthNum++) {
	$numDays = date("t",mktime(0,0,0,$monthNum,1,$year));
	$cmonth = date("n",mktime(0,0,0,$monthNum,1,$year));

	echo "<td valign=\"top\">\n";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<td align=\"center\" colspan=\"7\"><b>";
	echo $month[$cmonth];
	echo "</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><b>��</b></td>\n";
	echo "<td><font color=\"Red\"><b>��</b></font></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
for ($i = 1; $i <= $numDays; $i++) {
	$dow = date("w",mktime(0,0,0,$monthNum,$i,$year));

if ($i < 10 && $i > 0) {
	$lala = "0" . $i;
} else {
	$lala = $i;
}

$log = "dev.ru.log." . $lala . $month2[$cmonth] . $year;

	if ($dow == 1)
		showday($dow);

	if ($dow == 2)
		showday($dow);

	if ($dow == 3)
		showday($dow);

	if ($dow == 4)
		showday($dow);

	if ($dow == 5)
		showday($dow);

	if ($dow == 6)
		showday($dow);

	if ($dow == 0) {
	if ($i == 1) {
		echo "<td colspan=\"6\"></td>\n";
	};
		if (file_exists($logs . $log)) {
			echo "<td><a href=\"lv.php?log=" . $log . "\">".$i."</a></td>\n";
		} else {
			echo "<td>" . $i . "</td>\n";
		};
		echo "</tr>\n";
		echo "<tr>\n";
	};
};
	echo "</tr>\n";
	echo "</table>\n";
	echo "</td>\n";
	if (date("n",mktime(0,0,0,$monthNum,1,$year)) == 3 ||
		date("n",mktime(0,0,0,$monthNum,1,$year)) == 6 ||
		date("n",mktime(0,0,0,$monthNum,1,$year)) == 9) {
		echo "</tr>\n";
		echo "<tr>\n";
	};
};

?>
</tr>
</tr>
</table>
</center>
</html>
