
<?php
  $db_host = "localhost";
  $db_name = "api_music";
  $db_user = "root";
  $db_pass = "";

$conn = mysqli_connect($db_host,$db_name,$db_user,$db_pass);

if (!$conn) {
	
die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully or something";

mysql_select_db('api_music');

?>

<?php
$num_per_page=10;


	if(isset($_GET["page"]))
	{
		$page=$_GET["page"];
	}
	else
	{
		$page=1;
	}

	$start_from=($page-1)*10;

	$sql="select * from music limit $start_from,$num_per_page";
	
	$rs_result=mysql_query($sql);


?>

<!DOCTYPE html>
<html>
    <head>
        <title> Pagination WIP</title>
    </head>
<body>
    
    <table align="center" border="1px">
        <tr>
            <th> Artist </th>
            <th> Music </th>
            <th> Songs </th>
            <th> Id </th>
        </tr>
        
        <?php 
        
        while($rows=mysql_fetch_array($rs_result))
        {
        ?>
        
        <tr>
            <td><?php echo $rows['artist'];?></td>
            <td><?php echo $rows['album'];?></td>
            <td><?php echo $rows['song'];?></td>
            <td><?php echo $rows['id'];?></td>
        </tr>  
        
        <?php     
        }
                
        ?>    
    </table>
    
    <?php 
    
    
    $sql="select * from music";
	
    $rs_result=mysql_query($sql);
	
    $total_records=mysql_num_rows($rs_result);
	
    $total_pages=ceil($total_records/$num_per_page);
    
    for($i=1;$i<=$total_pages;$i++)
    {
        echo "<a href='search page.php?page=".$i."'>".$i."</a>" ;
    }
    
    ?>
    

    
</body>
</html>


