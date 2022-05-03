<!DOCTYPE html>
<html>

  <head>
    <?php include("header.php"); ?>
  </head>

  <body>
    <?php include("sidebar.php"); ?>
    <div class="main">
      <a href="<?php echo $_POST['table'] . ".php" ?>" class="popup_button">BACK</a>
      <table> 
      <?php
        if ($_POST['table'] == "station") {
          echo "
          <tr>
            <th>Station ID</th>
            <th>Station Name</th>
            <th>Number of Platforms</th>
            <th>Is Open</th>
          </tr> ";
          include("connect.php");
          $s_q = "SELECT * FROM station WHERE ";
          if ($_POST['sea'] == "id") {
            $s_q = $s_q . " station.station_id = " . $_POST['term'];
          }
          if ($_POST['sea'] == "name") {
            $s_q = $s_q . " station.station_name LIKE '%" . $_POST['term'] . "%'";
          }
          if ($_POST['sea'] == "num_more") {
            $s_q = $s_q . " station.num_platforms > '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "num_less") {
            $s_q = $s_q . " station.num_platforms < '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "isop") {
            $s_q = $s_q . " station.is_open = '1'";
          }
          if ($_POST['sea'] == "iscl") {
            $s_q = $s_q . " station.is_open = '0'";
          }
          $stmt = $conn->query($s_q);
          if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
              echo "<tr><td>" . $row["station_id"] . "</td><td>" . $row["station_name"] . "</td>
              <td>" . $row["num_platforms"] . "</td><td>" . (($row["is_open"]=='1')?'Yes':'No') . "</td>
              </tr>
              ";
            }
          }
          $conn->close();
        }
        
        if ($_POST['table'] == "train") {
          echo "
          <tr>
            <th>Train ID</th>
            <th>Train Name</th>
            <th>Number of Cars</th>
            <th>Number of Seats</th>
            <th>Service Type</th>
          </tr> ";
          include("connect.php");
          $s_q = "SELECT * FROM train WHERE ";
          if ($_POST['sea'] == "id") {
            $s_q = $s_q . " train.train_id = " . $_POST['term'];
          }
          if ($_POST['sea'] == "name") {
            $s_q = $s_q . " train.train_name LIKE '%" . $_POST['term'] . "%'";
          }
          if ($_POST['sea'] == "car_more") {
            $s_q = $s_q . " train.num_cars > '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "car_less") {
            $s_q = $s_q . " train.num_cars < '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "seat_more") {
            $s_q = $s_q . " train.num_seats > '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "seat_less") {
            $s_q = $s_q . " train.num_seats < '" . $_POST['term'] . "'";
          }
          if ($_POST['sea'] == "ser") {
            $s_q = $s_q . " train.service_type LIKE '%" . $_POST['term'] . "%'";
          }
          $stmt = $conn->query($s_q);
          if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
              echo "<tr><td>" . $row["train_id"] . "</td><td>" . $row["train_name"] . "</td>
              <td>" . $row["num_cars"] . "</td><td>" .  $row["num_seats"] . "</td><td>". $row["service_type"] . "</td>
              </tr>
              ";
            }
          }
          $conn->close();
        }

        if ($_POST['table'] == "track") {
          echo "
          <tr>
            <th>Track Id</th>
            <th>Station 1</th>
            <th>Station 2</th>
          </tr> ";
          include("connect.php");
          $s_q = "SELECT DISTINCT track_id, station_id_1, station_id_2 FROM track, station WHERE ";
          if ($_POST['sea'] == "id") {
            $s_q = $s_q . "track.track_id = " . $_POST['term'];
          }
          if ($_POST['sea'] == "stn1") {
            $s_q = $s_q . "track.station_id_1 = station.station_id AND station.station_name LIKE '%" . $_POST['term'] . "%'";
          }
          if ($_POST['sea'] == "st1") {
            $s_q = $s_q . "track.station_id_1 = " . $_POST['term'];
          }
          if ($_POST['sea'] == "stn2") {
            $s_q = $s_q . "track.station_id_2 = station.station_id AND station.station_name LIKE '%" . $_POST['term'] . "%'";
          }
          if ($_POST['sea'] == "st2") {
            $s_q = $s_q . "track.station_id_2 = " . $_POST['term'];
          }
          $stmt = $conn->query($s_q);
          if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
              $stmt_s = $conn->query('SELECT station_id, station_name FROM station');
              $stn_1 = '';
              $stn_2 = '';
              while ($row_s = $stmt_s->fetch_assoc()) {
                if ($row_s["station_id"] == $row["station_id_1"]) $stn_1 = $row_s["station_name"];
                if ($row_s["station_id"] == $row["station_id_2"]) $stn_2 = $row_s["station_name"];
              }
              echo "<tr><td>" . $row["track_id"] . "</td><td>" . $stn_1 . " (" . $row["station_id_1"] . ") </td>
              <td>" . $stn_2 . " (" . $row["station_id_2"] .  ") </td>
              </tr>
              ";
            }
          }
          $conn->close();
        }
      ?>
      </table>
    </div>
  </body>

</html>