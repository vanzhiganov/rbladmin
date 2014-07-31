<?php
// check.php

include "config.php";

$check = false;
$check_result = 0;

if (isset($_POST['ipaddress'])) {
	$check = true;
	$ipaddress = $_POST['ipaddress'];
	$result = $mysqli->query("SELECT COUNT(*) FROM `ips` WHERE ipaddress = '".$ipaddress."'");
	$row = $result->fetch_row();
	$check_result = $row[0];
}
?>
<html>
<head>
	<title>RBL Check</title>
</head>
<body>
	<h2>RBL Check</h2>
	<h3>Relay Blacklist</h3>

<?php
if ($check == true) {
	if ($check_result == 0) {
		print "<p style='color: green'>IP address {$ipaddress}: OK</p>";
	} else {
		print "<p style='color: red'>IP address: {$ipaddress} in RBL</p>";
	}
}
?>

	<form action="check.php" method="post">
		<table border="0">
			<tr>
			<td align="right">IP Address:</td>
			<td align="left"><input type="text" name="ipaddress" size="20"></td>
		</tr>
		<tr>
			<td align="right" valign="top">&nbsp;</td>
			<td align="left"><input type="submit" name="Submit" value="Check"></td>
		</tr>
		</table>
	</form>
	<p>
		<a href="index.php">Home</a>.
	</p>
</body>
</html>