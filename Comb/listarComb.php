<?php
session_start();
include_once "../controllers/function_db.php"; ?>
    <?php
    $query = "SELECT c.*, COUNT(DISTINCT v.cod_posto) qntd FROM combustiveis c LEFT JOIN vende v ON c.cod_comb = v.cod_comb GROUP BY c.nm_comb";
    if(isset($_SESSION['ordem'])){
      $query.=  " ORDER BY qntd ".$_SESSION['ordem'].";";
    }
    $combs = getSQL($query, "all");
    if($combs){
    foreach ($combs as $comb) { ?>
    <div class="card">
            <input type="hidden" name="combustivel" value="<?php echo $comb['cod_comb']?>"/>
            <div class="about">
              <div class="text">
                <h1><?php echo $comb['nm_comb']?></h1>
              </div>
            </div>
            <div class="info"><h1>Postos: <?php echo $comb['qntd']?></h1></div>
          </div>
          <?php }} else {
          ?> <h1>Não há resultados com o filtro escolhido</h1> <?php
        }
?>