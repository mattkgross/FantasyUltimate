<html>
<head>
<title>Player Reset</title>
</head>
<body>
<?php
require_once("../headers/mysql.php");
mysql_query("UPDATE players SET goals='0', turns='0', ds='0', assists='0', tgoals='0', tturns='0', tds='0', tassists='0', tgames='0'");
require_once("../headers/close.php");
?>
Player reset successful.
</body>
</html>