<?php
session_start();
include_once "../controllers/function_db.php"; ?>
    <?php
    $query = "SELECT b.*, count(p.cod_posto) qntd FROM bandeiras b LEFT JOIN postos p ON b.cod_band = p.cod_band GROUP BY b.cod_band";
    if(isset($_SESSION['ordem'])){
      $query.=  " ORDER BY qntd ".$_SESSION['ordem'].";";
    }
    $bands = getSQL($query, "all");
    if($bands){
    foreach ($bands as $band) { ?>
    <div class="card">
            <input type="hidden" name="bandeira" value="<?php echo $band['cod_band']?>"/>
            <div class="about">
              <img src="./Images/<?php echo $band['img_band']?>" alt="Logo" />
              <div class="text">
                <h1><?php echo $band['nm_band']?></h1>
              </div>
            </div>
            <div class="info">
              <h1>Postos: <?php echo $band['qntd']?></h1>
            </div>
          </div>
        <?php }} else {
          ?> <h1>Não há resultados com o filtro escolhido</h1> <?php
        }
?>
