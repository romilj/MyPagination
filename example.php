<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Pagination Examples</title>
<style>

body { font-family:"Comic Sans MS", cursive; color:#000; }
a { font-family:"Comic Sans MS", cursive; font-size: 24px; color: #6F6; }
a.pagination, a:visited { color: #39F; }
a.pagination:active { color: #C00; }
div.pages { color: #903; font-size: 24px; height: 30px; }
.prev, .next, .sel_page { width: 65px; display: inline-block; }
.sel_page select {  padding: 5px;  vertical-align: middle; }
</style>
</head>

<body>
<?Php
include("class.mypagination.php");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "test_db";
$tbname = "pages";

/*
* The table on this example has only 2 fields
* id, description
*/

// database here
$db = @mysql_connect($host, $user, $pass) or die("Failed to connect to mysql");
mysql_select_db($dbname) or die("Failed to connect to database");


$offset = 3; // number of rows per page

$sql = "SELECT * FROM $tbname";
$query = mysql_query($sql);
$total_results = mysql_num_rows($query);

$_GET['page'] = (isset($_GET['page'])) ? $_GET['page'] : '';
// ==========================================================================================================


echo 'Offset (Number of rows in a page): '.$offset;
echo '<br /><br />';
echo '---- 1. basic next/prev  ---------------------------------------------';
echo '<br /><br />';
echo 'RESULTS';
echo '<br />';

// IMPLEMENTATION
$pg = new MyPagination();
//$pg->setgetvar('pgs'); // use this when you are using a different page GET variable like "index.php?pgs=1"
$result = $pg->page_nextprev($offset, $total_results, $_GET['page']);

$sql1 = "SELECT * FROM $tbname ".$result['limit'];
$query1 = mysql_query($sql1);
$page_results = mysql_num_rows($query1);

while ($row = mysql_fetch_array($query1)) {
		echo $row['id'].' => '.$row['description'];
		echo '<br />';
}

echo '<br /><br />';
//echo $result['limit'];
//echo $temp['prev'];
//echo '<br />';
//echo $temp['next'];
//echo '<br />';
echo '<div class="pages">';
echo $result['default'];
echo '<br />';
echo '</div>';
echo '<br />';
echo 'Showing '.$result['begin_rec'].' - '.$result['end_rec'].' out of '.$result['total_rec'];

// ==========================================================================================================

echo '<br /><br />';
echo '---- 2. Page Numbers  ---------------------------------------------';
echo '<br /><br />';
echo 'RESULTS';
echo '<br />';


// IMPLEMENTATION
$pg2 = new MyPagination();
//$pg->setgetvar('pgs'); // use this when you are using a different page GET variable like "index.php?pgs=1"
$result2 = $pg2->page_series($offset, $total_results, $_GET['page']);

$sql2 = "SELECT * FROM $tbname ".$result['limit'];
$query2 = mysql_query($sql2);
$page_results = mysql_num_rows($query2);

while ($row = mysql_fetch_array($query2)) {
		echo $row['id'].' => '.$row['description'];
		echo '<br />';
}

echo '<br /><br />';
//echo $result2['limit'];
//echo $temp['prev'];
//echo '<br />';
//echo $temp['next'];
//echo '<br />';
echo '<div class="pages">';
echo $result2['default'];
echo '</div>';
echo '<br />';
echo 'Showing '.$result2['begin_rec'].' - '.$result2['end_rec'].' out of '.$result2['total_rec'];

// ==========================================================================================================

echo '<br /><br />';
echo '---- 3. Select Field (Drop Down)  ---------------------------------------------';
echo '<br /><br />';
echo 'RESULTS';
echo '<br />';


// IMPLEMENTATION
$pg3 = new MyPagination();
//$pg->setgetvar('pgs'); // use this when you are using a different page GET variable like "index.php?pgs=1"
$result3 = $pg3->page_selectField($offset, $total_results, $_GET['page']);

$sql3 = "SELECT * FROM $tbname ".$result['limit'];
$query3 = mysql_query($sql3);
$page_results = mysql_num_rows($query3);

while ($row = mysql_fetch_array($query3)) {
		echo $row['id'].' => '.$row['description'];
		echo '<br />';
}

echo '<br /><br />';
//echo $result3['limit'];
//echo $temp['prev'];
//echo '<br />';
//echo $temp['next'];
//echo '<br />';
echo '<div class="pages">';
echo $result3['default'];
echo '</div>';
echo '<br />';
echo 'Showing '.$result3['begin_rec'].' - '.$result3['end_rec'].' out of '.$result3['total_rec'];


// ==========================================================================================================
echo '<br /><br />';
echo '---- 4. Number Series  ---------------------------------------------';
echo '<br /><br />';
echo 'RESULTS';
echo '<br />';

// IMPLEMENTATION
$pg4 = new MyPagination();
//$pg->setgetvar('pgs'); // use this when you are using a different page GET variable like "index.php?pgs=1"
$result4 = $pg4->number_series($offset, $total_results, $_GET['page']);

$sql4 = "SELECT * FROM $tbname ".$result4['limit'];
$query4 = mysql_query($sql4);
$page_results = mysql_num_rows($query4);

while ($row = mysql_fetch_array($query4)) {
		echo $row['id'].' => '.$row['description'];
		echo '<br />';
}

echo '<br /><br />';
//echo $result3['limit'];
//echo $temp['prev'];
//echo '<br />';
//echo $temp['next'];
//echo '<br />';
echo '<div class="pages">';
echo $result4['default'];
echo '</div>';
echo '<br />';
echo 'Showing '.$result4['begin_rec'].' - '.$result4['end_rec'].' out of '.$result4['total_rec'];



mysql_close($db);

?>
</body>
</html>
