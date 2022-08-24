
<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

$opt_artist = "All Artists";
$opt_album = "All Albums";

$sel_artists = Music::getDistinctColumn($conn, "artist");
//$sel_albums = Music::getDistinctColumn($conn, "album");

// Count selected or initial
$artists = Music::getCount($conn, "artist");
$albums = Music::getCount($conn, "album");
$songs = Music::getCount($conn, "song");

//-------------------------------------------- POST what hapens after button is pushed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $art_variable = $_POST['taskArtist'];
  $opt_artist = $art_variable;

  $alb_variable = $_POST['taskAlbum'];
  $opt_album = $alb_variable;

  if (isset($_POST['SubmitArtist'])) {
    // Fill dropdown for Albums
    $sel_albums = Music::getDistinctAlbums($conn, $art_variable);

    // ------------- Clicked 'Submit Artist': Find data for an Artist
    if ($art_variable == 'All Artists') {
      //Get items data for all artists
      $items = Music::getAll($conn);

      //Get Count for all
      $art_artists = $artists;
      $art_albums = $albums;
      $art_songs = $songs;
    }
    else {
      // Get items data for one artist
      $items = Music::getDataForArtist($conn, $art_variable);

      //Get Count for one artist
      $art_artists = array('res' => '1');
      $art_albums = Music::getCountForArtist($conn, "album", $art_variable);
      $art_songs = Music::getCountForArtist($conn, "song", $art_variable);
      //echo $art_artists['res'];
    }
    $opt_album = "All Albums";
  }

  else {
    $sel_albums = Music::getDistinctAlbums($conn, $art_variable);

    // ------------------- Clicked 'Submit Album': Find intems for Albom
    $items = Music::getDataForArtistAlbum($conn, $art_variable, $alb_variable);

    //Get Count for artist and album
    $art_artists = Music::getCountForArtistAlbum($conn, "artist", $art_variable, $alb_variable);
    $art_albums = Music::getCountForArtistAlbum($conn, "album", $art_variable, $alb_variable);
    $art_songs = Music::getCountForArtistAlbum($conn, "song", $art_variable, $alb_variable);
  }
  //art_selected = $alb_variable;
} //POST

?>

<?php require 'includes/header.php'; ?>

<center>

<h1> Favorite Music from best APIs </h1>

<b>

<!--Text to show live counts from existing data in table music -->
<?php
echo "Currently we have ", $artists['res'], " artists and ", $albums['res'], " albums with ", $songs['res'], " songs.";
?>
</b>
<br> <br>

<!-- Drop-down selections with two submit buttons -->
<form method="post">

  <table border="0">
      <caption>Please select Artist and/or Album</caption>
      <tr>
          <th align="right">
            <!--Form to select Artist -->
            <select name="taskArtist">
              <option art_selected = "art_selected"> <?php echo $opt_artist; ?>  </option>
              <?php
              foreach ($sel_artists as $selection) {
                foreach ($selection as $line){
                echo " <option value = '$line'> $line </option>";
                }
              }
              ?>
            </select>

          </th>
          <th>
            <!--button to submit selected value from drop-down -->
            <input type = "submit" name = "SubmitArtist" value="Select Artist">
          </th>
      </tr>
      <tr>
          <td align="right">
            <!--Form to select Album -->
            <select name="taskAlbum">
              <option alb_selected = "alb_selected">  <?php echo $opt_album; ?> </option>
              <?php
              foreach ($sel_albums as $selection) {
                foreach ($selection as $line){
                echo " <option value = '$line'> $line </option>";

                }
              }
              ?>
            </select>

          </td>
          <td>
            <!--button to submit selected value from drop-down -->
            <input type = "submit" name = "SubmitAlbum" value="Select Album">
          </td>
      </tr>

  </table>
</form>

<br> <br>

<?php
if(empty($items)): ?>
       <p> No music selected. ;( </p>

<?php else: ?>
       <table border=1>
         <thead>
           <td align="center"> <h3> Artist </td>
           <td align="center"> <h3> Album </td>
           <td align="center"> <h3> Song  </td>
           <td align="center"> <h3> URL  </td>
         </h3>
         </thead>

  <tbody>
      <?php foreach($items as $item): ?>
        <tr>
          <td> <?= htmlspecialchars($item['artist']); ?> </td>
          <td> <?= htmlspecialchars($item['album']); ?> </td>
          <td> <?= htmlspecialchars($item['song']); ?> </td>
          <td>
            <a href=<?= htmlspecialchars($item['url']); ?> ><?= htmlspecialchars($item['url']); ?> </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  <tfoot>
    <tr>
      <td align="center"> <h4> <?= $art_artists['res']; ?> </td>
      <td align="center"> <h4> <?= $art_albums['res']; ?> </td>
      <td align="center"> <h4> <?= $art_songs['res']; ?> </td>
      <td> <h4> <= Totals </td>
    </h4>
    </tr>
  </tfoot>
     </table>

     <br>
     <br>

       <ul class="posts">

   <?php endif; ?>

 </center>

<?php require 'includes/footer.php'; ?>
