<?php
/**
* Music
*
* Class and functionality to get music info
*/
class Music {
  /** Unique identifier @var integer */
  public $id;
  /** Unique identifier @var string */
  public $artist;
  /** Unique identifier @var string  */
  public $album;
  /** Unique identifier @var string */
  public $song;
  /** Validation errors @var array */
  public $errors = [];


  /** -------------------------------------------------------------------- Get Part
  * @param object $conn Connection to the database
  * @param int $row to start from
  * @param int $row to end to
  * @return mixed An object of that class, or NULL if not found
  */
  public static function getPart($conn, $start_from, $num_per_page) {
    $sql = "SELECT *
           FROM music
           ORDER BY artist, album
           limit $start_from, $num_per_page;";
    $results = $conn->query($sql);
    return $results->fetchAll(PDO::FETCH_ASSOC);
  }


  /** ----------------------------------------------------------- get All
  * @param object $conn Coonectionto the database
  * @return array An Associative Array of all music records
  */
  public static function getAll($conn) {
    $sql = "SELECT *
           FROM music
           ORDER BY artist, album;";

    $results = $conn->query($sql);
    return $results->fetchAll(PDO::FETCH_ASSOC);
  }

  /** -------------------------------------------------------------------- Get Count
  * @param object $conn Connection to the database
  * @param string $column name to be selected from
  * @return mixed An object of that class, or NULL if not found
  */
   public static function getCount($conn, $column) {
     $sql = "SELECT COUNT(DISTINCT $column) as res FROM music";
     $result = $conn->query($sql);
     return $result->fetch(PDO::FETCH_ASSOC);
   }

   /** -------------------------------------------------------------------- Get Count ForArtist
   * @param object $conn Connection to the database
   * @param string $column name to be selected from
   * @param string $artis name to be selected by
   * @return mixed An object of that class, or NULL if not found
   */
    public static function getCountForArtist($conn, $column, $artist) {
      $sql = "SELECT COUNT(DISTINCT $column) as res
              FROM music
              WHERE artist = '$artist'";
      $result = $conn->query($sql);
      return $result->fetch(PDO::FETCH_ASSOC);
    }

    /** -------------------------------------------------------------------- Get Count for Artist and Album
    * @param object $conn Connection to the database
    * @param string $column name to be selected from
    * @param string $artis name to be selected by
    * @return mixed An object of that class, or NULL if not found
    */
     public static function getCountForArtistAlbum($conn, $column, $artist, $album) {
       if ($artist == 'All Artists') {
         if ($album == 'All Albums') {
           $sql = "SELECT COUNT(DISTINCT $column) as res
                   FROM music";
         } else {
           $sql = "SELECT COUNT(DISTINCT $column) as res
                   FROM music
                   WHERE album = '$album'";
         }
       }
       else {
         if ($album == 'All Albums') {
           $sql = "SELECT COUNT(DISTINCT $column) as res
                   FROM music
                   WHERE artist = '$artist'";
         } else {
           $sql = "SELECT COUNT(DISTINCT $column) as res
                   FROM music
                   WHERE artist = '$artist'
                     AND album = '$album'";
        }
       }

       $result = $conn->query($sql);
       return $result->fetch(PDO::FETCH_ASSOC);
     }

     /** ----------------------------------------------------------- get DataForArtistAlbum
     * @param object $conn Coonectionto the database
     * @return array An Associative Array of all music records
     */
     public static function getDataForArtistAlbum($conn, $artist, $album) {
       if ($artist == 'All Artists') {
         $sql = "SELECT *
                FROM music
                WHERE album = '$album'
                ORDER BY artist, album;";
       }
       else {
         //$album = str_replace("'", "''", $album);
         $sql = "SELECT *
                FROM music
                WHERE artist = '$artist'
                  AND album = '$album'
                ORDER BY artist, album;";
       }
       $results = $conn->query($sql);
       return $results->fetchAll(PDO::FETCH_ASSOC);
     }

   /** -----------------------------------------------------------------getDistinctColumn
   * @param object $conn Connection to the database
   * @param string $columns OPtional list of columns for SELECT, default to *
   * @return mixed An object of that class, or NULL if not found
   */
    public static function getDistinctColumn($conn, $column) {
      $sql = "SELECT $column
              FROM music
              GROUP BY $column
              ORDER BY $column ASC";
      $results = $conn->query($sql);
      return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /** -----------------------------------------------------------------getDistinctColumn
    * @param object $conn Connection to the database
    * @param string $artis value for specific artist to select for
    * @return mixed An object of that class, or NULL if not found
    */
     public static function getDistinctAlbums($conn, $artist) {
       $sql = "SELECT album
               FROM music
               WHERE artist = '$artist'
               GROUP BY album
               ORDER BY album  ASC";
       $results = $conn->query($sql);
       return $results->fetchAll(PDO::FETCH_ASSOC);
     }

    /** ---------------------------------------------------------------getDataForArtist
    * @param object $conn Connection to the database
    * @param string $artist OPtional for specific artist to select *
    * @return mixed An object of that class, or NULL if not found
    */
    public static function getDataForArtist($conn, $artist) {
      if ($artist == 'All Artists') {
        $sql = "SELECT * FROM music'";
      } else {
        $sql = "SELECT * FROM music
                WHERE artist = '$artist'";
      }
      $result = $conn->query($sql);
      return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
