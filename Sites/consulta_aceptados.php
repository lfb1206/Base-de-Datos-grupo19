<?php include('templates/header.html');   ?>

<body>

  <div class="surface">
    <?php
    #Llama a conexión, crea el objeto PDO y obtiene la variable $db
    require("config/conexion.php");

    $aerolinea_escogida = $_POST["aerolinea_escogida"];
    $codigo = $_POST["codigo"];
    $codigo = strtoupper($codigo);

    $query = "SELECT Vuelo.numero_vuelo, Origen.nombre as origen, Destino.nombre as destino,
                Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.estado
              FROM Vuelo, CompaniaAerea, Aerodromo as Origen, Aerodromo as Destino
              WHERE UPPER(CompaniaAerea.nombre_aerolinea) LIKE '%$aerolinea_escogida%'
                AND CompaniaAerea.codigo_aerolinea = Vuelo.codigo_aerolinea 
                AND UPPER(Vuelo.destino_icao) LIKE '%$codigo%' 
                AND Vuelo.estado = 'aceptado'
                AND Vuelo.origen_icao = Origen.codigo_icao
                AND Vuelo.destino_icao = Destino.codigo_icao;";
    $result = $db -> prepare($query);
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <?php
    echo "<h1 align=\"center\">Vuelos aceptados para aerolínea \"$aerolinea_escogida\" y con destino \"$codigo\"</h1>";
    ?>

    <table>
      <tr>
        <th>Numero</th>
        <th>Aerodromo origen</th>
        <th>Aerodromo destino</th>
        <th>Fecha salida</th>
        <th>Fecha llegada</th>
      </tr>
    <?php
    foreach ($dataCollected as $data) {
        echo "<tr><td>$data[0]</td><td>$data[1]</td><td>$data[2]</td><td>$data[3]</td><td>$data[4]</td></tr>";
    }
    ?>
    </table>
  </div>

<?php include('templates/footer.html'); ?>
