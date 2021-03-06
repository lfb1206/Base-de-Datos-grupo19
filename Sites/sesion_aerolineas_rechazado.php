<?php include('templates/header.php');   ?>

<?php

$aerolinea_escogida = $_SESSION['username'];

$query2 = "SELECT Vuelo.numero_vuelo, Origen.codigo_icao, Origen.nombre as origen,
            Destino.codigo_icao, Destino.nombre as destino,
            Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.estado
          FROM Vuelo, CompaniaAerea, Aerodromo as Origen, Aerodromo as Destino
          WHERE UPPER(CompaniaAerea.codigo_aerolinea) LIKE '%$aerolinea_escogida%'
            AND CompaniaAerea.codigo_aerolinea = Vuelo.codigo_aerolinea 
            AND Vuelo.estado = 'rechazado'
            AND Vuelo.origen_icao = Origen.codigo_icao
            AND Vuelo.destino_icao = Destino.codigo_icao;";
$result2 = $db -> prepare($query2);
$result2 -> execute();
$dataCollected2 = $result2 -> fetchAll();
?>

<?php
echo "<div class=\"title is-4 is-active\" align=\"center\" style=\"color:#006BB3;\">Vuelos rechazados para la aerolínea \"$aerolinea_escogida\"</div>";
?>

<table>
  <tr>
    <th>Código de vuelo</th>
    <th>ICAO origen</th>
    <th>Aeródromo origen</th>
    <th>ICAO destino</th>
    <th>Aeródromo destino</th>
    <th>Fecha salida</th>
    <th>Fecha llegada</th>
    <th>Estado</th>
  </tr>
<?php
foreach ($dataCollected2 as $data2) {
    echo "<tr>
      <td>$data2[0]</td>
      <td>$data2[1]</td>
      <td>$data2[2]</td>
      <td>$data2[3]</td>
      <td>$data2[4]</td>
      <td>$data2[5]</td>
      <td>$data2[6]</td>
      <td>$data2[7]</td>
    </tr>";
}
?>
</table>

</br>
<div class="buttons" style="justify-content: center;">
  <a class="button is-info is-rounded" href="sesion_aerolineas.php">Crear propuesta</a>
</div>

<?php include('templates/footer.php'); ?>
