<?php
session_start();
include_once "../controllers/function_db.php"; ?>
    <?php
    $query = "SELECT p.*, v.valor, b.img_band
    FROM postos p
    JOIN vende v using (cod_posto)
    JOIN favoritos f using (cod_posto)
    JOIN bandeiras b using (cod_band)
    WHERE ".(isset($_SESSION['band']) ? "b.cod_band = " . $_SESSION['band'] . " AND ":"")."
    v.cod_comb = ".(isset($_SESSION['comb']) ? $_SESSION['band'] :"1")."
    AND f.cod_pessoa = ?
    AND v.dt_registro = (
      SELECT MAX(dt_registro)
      FROM vende
      WHERE cod_posto = p.cod_posto
      AND cod_comb = ".(isset($_SESSION['comb']) ? $_SESSION['band'] :"1")."
    )";
    // $query = "SELECT p.*, b.img_band FROM usuario u JOIN favoritos f using (cod_pessoa) 
    // JOIN postos p using (cod_posto) JOIN bandeiras b using (cod_band) WHERE u.cod_pessoa = ? ;";
    $postos = getSQL($query, "all", array($_SESSION['cod_pessoa']));
    if($postos){
    foreach ($postos as $posto) { ?>
    <div class="card">
            <input type="hidden" name="posto" value="<?php echo $posto["cod_posto"]?>"/>
            <div class="about">
              <img src="./Images/<?php echo $posto["img_band"]?>" alt="Logo" />
              <div class="text">
                <h1><?php echo $posto["nm_posto"]?></h1>
                <h2><?php echo $posto["endereco"]?></h2>
              </div>
            </div>
            <div class="info"><h1> <?php echo $posto["valor"]?></h1></div>
          </div>
<?php }} else {
          ?> <h1>Não há resultados com o filtro escolhido</h1> <?php
        }
?>
