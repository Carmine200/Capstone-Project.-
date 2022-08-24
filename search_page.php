
<?php
  //$db_host = "localhost";
  //$db_name = "api_music";
  //$db_user = "root";
  //$db_pass = "";
  //$conn = mysqli_connect($db_host,$db_name,$db_user,$db_pass);
  require 'includes/init.php';

  $conn = require 'includes/db.php';

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>

<?php
  $num_per_page = 10;
  $rs_result = Music::getAll($conn);
  $total_records = Music::getCount($conn, "song");
  $total_pages =  ( $total_records['res'] / $num_per_page ) + 1;

	if(isset($_GET["page"])) {
		$page=$_GET["page"];
    $start_from = ($page-1) * $num_per_page;
	}	else {
		$page=1;
    $start_from = $page;
	}


	$rs_result = Music::getPart($conn, $start_from, $num_per_page);
?>

<?php require 'includes/header.php'; ?>

<title> Pagination WIP </title>

<center>
  <h1>  Pagination WIP </h1>

  <!-- printing pages -->
  <?php
      for($i=1; $i<=$total_pages; $i++) {
          echo "<a href='search_page.php?page=".$i."'>".$i."</a>" ;
          echo " ";
      }
  ?>

<br><br>

    <!-- printing table -->
    <table align="center" border="1px">
        <tr>
            <th> Artist </th>
            <th> Album </th>
            <th> Song </th>
            <th> URL</th>
        </tr>

        <?php foreach($rs_result as $item): ?>
          <tr>
            <td> <?= htmlspecialchars($item['artist']); ?> </td>
            <td> <?= htmlspecialchars($item['album']); ?> </td>
            <td> <?= htmlspecialchars($item['song']); ?> </td>
            <td>
              <a href=<?= htmlspecialchars($item['url']); ?> ><?= htmlspecialchars($item['url']); ?> </a>
            </td>
          </tr>
        <?php endforeach; ?>

    </table>


<?php require 'includes/footer.php'; ?>
