<?php
session_start();
include_once '../controllers/function_db.php'; ?>
    <?php
    $query = 'SELECT u.* from usuario u';
    if(isset($_SESSION['status'])){
      $query.=  " where status = ".$_SESSION['status'].";";
    }
    $pessoas = getSQL($query, 'all');
    if($pessoas){
    foreach ($pessoas as $pessoa) { ?>

<div class="card">
  <input type="hidden" name="user" value="<?php echo $pessoa['cod_pessoa']?>" />
  <div class="about" style="margin: 0; width: 100%; justify-content:space-between ;text-align: left;">
    <div class="text" style="margin: 0; width: 15vw;">
      <h1><?php echo $pessoa['nm_pessoa']?></h1>
    </div>
    <div class="text" style="margin: 0; width: 15vw;">
      <h1><?php echo substr_replace($pessoa['email'], '</br>', (strpos($pessoa['email'],'@')), 0);?></h1>
    </div>
    <div class="text" style="margin: 0; width: 15vw;">
      <h1><?php 
      switch ($pessoa['status']) {
        case 1:
            echo 'Verificado';
            break;
        case 0:
            echo 'Pendente';
            break;
        default:
            break;
      }
      ?></h1>
    </div>
  </div>
</div>
<?php }} else {
          ?> <h1>Não há resultados com o filtro escolhido</h1> <?php
        }


?>
