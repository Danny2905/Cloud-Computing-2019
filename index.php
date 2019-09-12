<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>

    <?php 
        $servername = "mysql:unix_socket=/cloudsql/s3599191-cc2019:australia-southeast1:assignment2";
        $username = "root";
        $password = "abc123";
        $dbname = "assignment2";
        $conn = new PDO("$servername;dbname=$dbname", $username, $password);
       
        $query = $conn->prepare('SELECT * FROM Champions');
        $query->execute();

        $result = $query -> fetchAll();

        foreach( $result as $row ) {
          echo '<div class="container">
              Champion Name: '.$row['ChampionName'].'<br>
              Win Rate: '.$row['WinRate'].'<br>
              Pick Rate: '.$row['PickRate'].'<br>
              Ban Rate: '.$row['BanRate'].'<br>
              Role: '.$row['Role'].'<br>
              </div>';
        }
      ?>

  </body>
</html>