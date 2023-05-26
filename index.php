<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'ripasso');
$provincia = (!empty($_REQUEST["provincia"])) ? $_REQUEST["provincia"] : "";

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<style>
  #menuProv {
    width: 20%;
    padding-top: 20px;
    padding-left: 10px;
  }
</style>

<body>

  <script>
    $("#menuProv").submit();
  </script>
  <?php
  $strSQL = "SELECT DISTINCT provincia from struttureRicettive";
  $query = mysqli_query($conn, $strSQL);

  $row = mysqli_num_rows($query);


  ?>

  <form action="" id="menuProv">
    <select name="provincia" class="form-select" aria-label="Default select example">
      <option selected>Scegli la provincia</option>

      <?php

      if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
      ?>
          <option value="<?php echo $row['provincia']; ?>">
          <?php echo $row['provincia'];
        } ?></option>
        <?php
      }
        ?>

    </select>
    <button type="submit" class="btn btn-primary mb-3">Conferma</button>
  </form>
  <?php



  //echo $provincia;
  if (!empty($provincia)) {
    $strSQL1 = "SELECT * FROM struttureRicettive  WHERE provincia = '$provincia' LIMIT 15 ";
    //echo $strSQL1;
    $query1 = mysqli_query($conn, $strSQL1);
    if (mysqli_num_rows($query1) == 0) {

      echo ("Non esistono articoli che soddisfano la ricerca");
    } else {
  ?>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nome struttura</th>
            <th scope="col">Provincia</th>
            <th scope="col">Email</th>
            <th scope="col">Sito Web</th>
            <th scope="col">Telefono</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($query1)) {
          ?>
            <tr>

              <td> <?php echo $row["nome_struttura"]; ?></td>
              <td> <?php echo $row["provincia"]; ?></td>
              <td> <?php echo $row["email"]; ?></td>
              <?php
              if (empty($row["sito_web"])) { ?>
                <td>Nessun sito web presente</td> <?php ;} else { ?>
                <td> <a class="btn btn-primary mb-3" href="<?php echo "http://" . $row["sito_web"]; ?>" target="_blank"><?php echo $row["sito_web"];} ?> </a> </td>
                <td> <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="<?php echo $row["telefono"]; ?>">
                    Mostra numero</button></td>

            </tr>
        <?php
          }
        }
        ?>
        </tbody>
      </table>
    <?php
  }
    ?>
    <script>
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
      })
    </script>
</body>

</html>