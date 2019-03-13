<?php
/*											CSV2Chart
						Developed by Filiberto Canino & Francesco Tarantino
		This software is owned by I.I.S. "E. Fermi" of Catanzaro and it is created for EEE Community
			Original source code can be found at following url https://github.com/CATZ-01/CSV2Chart/
											Enjoy it.
*/
include("../inc/ssn.php");

include("../inc/cfg.php");

include("../inc/sql.php");

if (isset($_POST['search'])) {
$Name = $_POST['search'];
$Query = "SELECT * FROM files WHERE telescopio LIKE '%$Name%' LIMIT 5";
$ExecQuery = MySQLi_query($connessione, $Query);
if ($ExecQuery->num_rows == 0) {
  echo "<i class=\"fas fa-times\"></i> No results found.";
} else {

  echo '<ul>';

    while ($Result = $ExecQuery->fetch_array(MYSQLI_ASSOC)) {

?>
      <i class="fas fa-satellite-dish"></i>
      <a href="chart_select.php?id=<?php echo $Result['id']; ?>" title="Open charts">
      <?php echo $Result['telescopio']; ?> from: <?php echo $Result['from_data']; ?> to: <?php echo $Result['to_data']; if($Result['mc']==1){echo" <b>MC</b>";}?></a> - uploaded on <?php echo $Result['data_upload']; ?>
      <br />
<?php
    }

  echo "</ul>";
  }
}
?>
