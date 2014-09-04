<?php
##########################
# RBL update application #
##########################

include "config.php";

//$result = $mysqli->query("SELECT * FROM ips LIMIT 10");
//print_r($result);

$reportedby = $_SERVER['REMOTE_ADDR'];

  $ipaddress = ""; $notes = ""; $blackorwhite = "";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['ipaddress'])) {
        $ipaddress = $_POST['ipaddress'];
    }
    if (isset($_POST['notes'])) {
        $notes = addslashes($_POST['notes']);
    }
    if (isset($_POST['blackorwhite'])) {
        $blackorwhite = $_POST['blackorwhite'];
    }
  } else {
    if (isset($_GET['ipaddress'])) {
        $ipaddress = $_GET['ipaddress'];
    }
    if (isset($_GET['notes'])) {
        $notes = $_GET['notes'];
    }
    if (isset($_GET['blackorwhite'])) {
        $blackorwhite = $_GET['blackorwhite'];
    }
  }
  ##################################################################
  # see if this browser client is allowed to update mysql database #
  ##################################################################
  $allowed = 0;
  switch ($_SERVER['REMOTE_ADDR']) {
    case "213.141.131.101":
       $allowed = 1; # mail2.yourdomain.com
       break;
    case "84.253.104.246":
       $allowed = 1; # mail3.yourdomain.com
       break;
    case "39.227.237.20":
       $allowed = 1; # office.yourdomain.com
       break;
  }
if (($allowed) and ($ipaddress != "")) {
    $query = "insert into ips set ipaddress='{$ipaddress}', reportedby='{$reportedby}', attacknotes='{$notes}', b_or_w='{$blackorwhite}', dateadded=now(), updated=now();";
    $mysqli->query($query) or die ($mysqli->error);
}

/* close connection */
mysqli_close($link);
?>
<html>
<head>
<title>RBL Drop</title>
</head>
<body>
<h2>RBL Drop</h2>
<h3>Relay Blacklist</h3>
<p><?php echo $_SERVER['REMOTE_ADDR']; ?></p>
<?php
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
<?php
if ($check == true) {
	if ($check_result == 0) {
		print "<p style='color: green'>IP address {$ipaddress}: OK</p>";
	} else {
		print "<p style='color: red'>IP address: {$ipaddress} in RBL</p>";
	}
}
?>
<form action="drop.php" method="post">
<table border="0">
<tr>
  <td align="right">IP Address:</td>
  <td align="left"><input type="text" name="ipaddress" size="20"></td>
</tr>
<tr>
  <td align="right" valign="top">Attack Notes:</td>
  <td align="left"><textarea name="notes" rows="6" cols="30"></textarea></td>
</tr>
<tr>
  <td align="right">Deny Or Allow:</td>
  <td align="left"><select name="blackorwhite"><option value="b">black</option><option value="w">white</option></select></td>
</tr>
<tr>
  <td align="right" valign="top">&nbsp;</td>
  <td align="left"><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
</body>
</html>
