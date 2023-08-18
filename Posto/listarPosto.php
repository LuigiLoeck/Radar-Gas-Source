<?php
session_start();
include_once "../controllers/function_db.php"; ?>
    <?php

    if(isset($_SESSION['comb'])||$_SESSION["cod_pessoa"]!= 1){
      $query = "SELECT p.*, v.valor, b.img_band
      FROM postos p
      JOIN vende v using (cod_posto)
      JOIN bandeiras b using (cod_band)
      WHERE ".(isset($_SESSION['band']) ? "b.cod_band = " . $_SESSION['band'] . " AND ":"")."
      v.cod_comb = ".(isset($_SESSION['comb'])?$_SESSION['comb']:"1")."
      AND v.dt_registro = (
        SELECT MAX(dt_registro)
        FROM vende
        WHERE cod_posto = p.cod_posto
        AND cod_comb = ".(isset($_SESSION['comb'])?$_SESSION['comb']:"1")."
      )";
    } else {
      $query = "SELECT p.*,b.img_band, count(f.cod_pessoa) favs from postos p natural join bandeiras b left join favoritos f using (cod_posto)
      ".(isset($_SESSION['band']) ? "WHERE b.cod_band = " . $_SESSION['band'] : "")." group by cod_posto";
    }
    
    if(isset($_SESSION['ordem'])){
      $query.= isset($_SESSION['comb'])? " ORDER BY valor ".$_SESSION['ordem'].";" : " ORDER BY favs ".$_SESSION['ordem'].";";
    }
    $postos = getSQL($query, "all");
    if($postos){
    foreach ($postos as $posto) { ?>
    <div class="card">
            <input type="hidden" name="posto" value="<?php echo $posto["cod_posto"]?>"/>
            <div class="about">
              <img src="./Images/<?php echo $posto["img_band"]?>" alt="Logo" />
              <div class="text" style="text-align: left;">
                <h1><?php echo $posto["nm_posto"]?></h1>
                <h2><?php echo $posto["endereco"]?></h2>
              </div>
            </div>
            <div class="info"><h1>
              <?php echo (isset($_SESSION['comb'])||$_SESSION["cod_pessoa"]!= 1) ? "R$ ".($posto["valor"]==0.000?"---":$posto["valor"]) : "Usuários: ".$posto["favs"];?>
            </h1></div>
          </div>
<?php }} else {
  ?> <h1>Não há resultados com o filtro escolhido</h1> <?php
}
?>
