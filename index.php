
<?php


?>
<html>
<body>
<form action="index.php" method="post" >
text : <br />
<textarea name="text"></textarea><br />
<input type ="hidden" name="posted" value="true" >
<input type ="submit" value="Post">
</form>


<?php
//connect
include "dbcon.php";

$link_id = db_connect($default_dbname); 


if(isset($_POST['text']))
{
$posted=$_POST['posted'];
$text=addslashes($_POST['text']);
$time=time();


if($posted=="true")
{
$insert_error="your text cannot be posted";
$insert = mysql_query("INSERT INTO  `timesince`.`posts` (
`time` ,
`text`
)
VALUES (
'".$time."',  '$text'
)");

}

$get=mysql_query("select * from posts order by time desc");
while($row=mysql_fetch_assoc($get))
{
//data
$get_time=$row['time'];
$get_text=$row['text'];

$diff=$time-$get_time;
$suffix="";

switch(1)
{
case($diff<60):
$count=$diff;
if($count==0)
$count="a moment";
else if ($count==1)
$suffix="second";
else 
$suffix="second";
break;

case($diff > 60 && $diff <3600):
$count=floor($diff/60);
if($count==1)
$suffix="minute";
else
$suffix="minutes";
break;


case($diff > 3600 && $diff <86400):
$count=floor($diff/3600);
if($count==1)
$suffix="hour";
else
$suffix="hours";
break;

case($diff > 86400 && $diff <2629743):
$count=floor($diff/86400);
if($count==1)
$suffix="day";
else
$suffix="days";
break;


case($diff > 2629743 && $diff <31556926):
$count=floor($diff/2629743);
if($count==1)
$suffix="month";
else
$suffix="months";
break;

case($diff >31556926):
$count=floor($diff/31556926);
if($count==1)
$suffix="year";
else
$suffix="years";
break;

}
//echo date("d-m-y",$time);
echo $get_text."<br />posted ".$count." ".$suffix." ago <p />";
}
}//if set
?>
</body>
</html>