<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Champion Win Rates</title>
  </head>
  <body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="main.php">Champions</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Win Rate</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Ban Rate</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pick Rate</a>
      </li>
    </ul>
  </nav>

    <?php 
        $servername = "mysql:unix_socket=/cloudsql/s3599191-cc2019:australia-southeast1:assignment2";
        $username = "root";
        $password = "abc123";
        $dbname = "assignment2";
        $conn = new PDO("$servername;dbname=$dbname", $username, $password);
       
       //If a sort button was pressed do this
       if(isset($_POST['sort']) && $_POST['sort'] != 'all') {
          $query = $conn->prepare('SELECT * FROM Champions WHERE Role = :sort');
          $query->bindParam(':sort', $_POST['sort']);
          $query->execute();
          $result = $query -> fetchAll();
       }
       else if(strcmp($_POST['sort'],'all') == 0) {
          $query = $conn->prepare('SELECT * FROM Champions');
          $query->execute();
          $result = $query -> fetchAll();
       }
       //No sort button pressed
       else {
          $query = $conn->prepare('SELECT * FROM Champions');
          $query->execute();
          $result = $query -> fetchAll();
       }
      ?>


    <script type="text/javascript">
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
        // Create the data table.
        var data = new google.visualization.arrayToDataTable([
          ['Champion', 'Win Rate'],
          <?php
            foreach( $result as $row ) {
              echo "['".$row["ChampionName"]."', ".$row["WinRate"]."],"; 
            } ?>
          ]);
        // Set chart options
        var options = {'title':'Champion Win Rate',
                       width: 2500,
                       height :750, 
                       hAxis : { 
                        textStyle : {
                          fontSize: 9 // or the number you want
                      }
                    }
                     };
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <form action="#" method="post">
      <button type="submit" value="Top" name="sort">Sort by Top</button>
    </form>
    <form action="#" method="post">
      <button type="submit" value="Jungle" name="sort">Sort by Jungle</button>
    </form>
        <form action="#" method="post">
      <button type="submit" value="Mid" name="sort">Sort by Mid</button>
    </form>
    <form action="#" method="post">
      <button type="submit" value="Marksman" name="sort">Sort by Marksman</button>
    </form>
    <form action="#" method="post">
      <button type="submit" value="Support" name="sort">Sort by Support</button>
    </form>
    <form action="#" method="post">
      <button type="submit" value="all" name="sort">Show All</button>
    </form>

    <!--Div that will hold the pie chart-->
    <div class="" id="chart_div"></div>
    <a href="http://s3599191-cc2019.appspot.com.storage.googleapis.com/champion_data.txt">Download Data</a>

    <?php
      $handle = fopen('gs://s3599191-cc2019.appspot.com/champion_data.txt','w');
      foreach( $result as $row ) {
          fwrite($handle,$row['ChampionName'].','.$row['WinRate'].',');
      }
      fclose($handle);
    ?>
  </body>
</html>