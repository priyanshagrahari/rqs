<!DOCTYPE html>
<html>

  <head>
    <?php include("header.php"); ?>
  </head>

  <body>
    <?php include("sidebar.php"); ?>
    <div class="main">
    <div>
        <input type="checkbox" id="insert" style="display:none;">
        <label for="insert" class="popup_button">INSERT</label>
        <input type="checkbox" id="modify" style="display:none;">
        <label for="modify" class="popup_button">MODIFY</label>
        <input type="checkbox" id="delete" style="display:none;">
        <label for="delete" class="popup_button">DELETE</label>
        <input type="checkbox" id="search" style="display:none;">
        <label for="search" class="popup_button">SEARCH</label>
        
        <!-- form for insert -->
        <div class="popup_content i">
          <label for="insert" class="close_button" title="Close">&#x2BBE;</label>
          Enter data for the new entry: 
          <form action="" method="post"> <!-- form starts -->
            <div class="data_item">
              <label>Train ID</label>
              <select required name="t_id">
              <?php 
                  include("connect.php");
                  $stmt = $conn->query('SELECT train_id FROM train');
                  if ($stmt->num_rows > 0) {
                    while ($row = $stmt->fetch_assoc()) {
                      echo "<option value=" . $row['train_id'] . ">" . $row['train_id'] . "</option>
                      ";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="data_item">
              <label>Station Id</label>
              <select required name="s_id">
                <?php 
                  include("connect.php");
                  $stmt = $conn->query('SELECT station_id FROM station');
                  if ($stmt->num_rows > 0) {
                    while ($row = $stmt->fetch_assoc()) {
                      echo "<option value=" . $row['station_id'] . ">" . $row['station_id'] . "</option>
                      ";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="data_item">
              <label>Arrival Time</label>
              <input type="time" required name="a_time">
            </div>
            <div class="data_item">
              <label>Halt Duration</label>
              <input type="time" requied name="h_duration">
            </div>
            <div class="insert_button">
              <button name="insert">INSERT</button>
            </div>
            <?php 
              if(isset($_POST['insert'])) {
                $id_1 = $_POST['t_id'];
                $id_2= $_POST['s_id'];
                $time= date("H:i:s", strtotime($_POST['a_time']));
                $duration= date("H:i:s",strtotime($_POST['h_duration']));
                include("connect.php");
                try {
                  $inse = $conn->query("INSERT INTO schedule (train_id, station_id, arrival_time, halt_duration) 
                  VALUES ('$id_1', '$id_2', '$time', '$duration')");
                  $conn->close();
                } catch (Exception $e) {
                  echo "
                  <input type=\"checkbox\" id=\"err\" style=\"display:none;\">
                  <div class=\"error_box\">
                  <label for=\"err\" class=\"close_button\" title=\"Close\">&#x2BBE;</label>
                    Could not insert the entered data.<br>
                  </div>";
                  $conn->close();
                }
              } 
            ?>
          </form>
        </div>
      



      <table>
        <tr>
          <th>Train Id</th>
          <th>Station Id</th>
          <th>Arrival Time</th>
          <th>Halt Duration</th>
        </tr>
        <?php
          include("connect.php");
          $stmt = $conn->query('SELECT * FROM schedule');
          if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
              echo "<tr><td>". $row["train_id"] . "</td><td>" . $row["station_id"] . "</td><td>" . $row["arrival_time"] . "</td>
              <td>" . $row["halt_duration"] . "</td><td>" .  "</td>
              </tr>
              ";
            }
          }
        ?>
      </table>
    
    </div>
  </body>

</html>