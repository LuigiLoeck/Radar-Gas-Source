<?php
include "../../controllers/function_db.php";
include "../../email/emailer.php";
session_start();

$data = date("m-d-Y");
$hora = date("H:i:s");

// var_dump($_POST);
// die();

if (isset($_POST["cadastrarUser"])) {
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $cpf = $_POST["cpf"];
  $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

  $array = [$email];
  $query = "select * from usuario where email = ?";
  $check = getSQL($query, "one", $array);
  $array = [$cpf];
  $query = "select * from usuario where cpf = ?";
  $check2 = getSQL($query, "one", $array);

  if (!$check && !$check2) {
    $hash = md5($email);
    $msg = file_get_contents("../components/tempConfEmail.html");
    $msg = str_replace("{{nome}}", $nome, $msg);
    $msg = str_replace("{{hash}}", $hash, $msg);
    $assunto = "Confirme seu cadastro";
    $return = enviaEmail($nome, $email, $msg, $assunto, null);
    if ($return) {
      $array = [$nome, $email, $cpf, $senha];
      $query =
        "insert into usuario (nm_pessoa, email, cpf, senha) values (?, ?, ?, ?)";
      $return2 = getSQL($query, "mod", $array);

      if ($return2) {
        echo "emailsent";
      } else {
        echo "error";
      }
    } else {
      echo "nouser";
    }
    return;
  } else {
    if ($check) {
      echo "haveemail";
    }
    if ($check2) {
      echo "havecpf";
    }
    return;
  }
}

if (isset($_POST["entrar"])) {
  $query = @unserialize(file_get_contents("http://ip-api.com/php/"));
  if ($query && $query["status"] == "success") {
    $ip = $query["query"];
  }

  $email = $_POST["email"];
  $senha = $_POST["senha"];

  $array = [$email];
  $query = "select * from usuario where email=?  and status=true";
  $pessoa = getSQL($query, "one", $array);

  if ($pessoa) {
    if (password_verify($senha, $pessoa["senha"])) {
      $_SESSION["logado"] = true;
      $_SESSION["cpf"] = $pessoa["cpf"];
      $_SESSION["cod_pessoa"] = $pessoa["cod_pessoa"];
      $_SESSION["nome"] = $pessoa["nm_pessoa"];
      $_SESSION["email"] = $email;
      $msg = file_get_contents("../components/tempLogin.html");
      $msg = str_replace("{{email}}", $email, $msg);
      $msg = str_replace(
        "{{date}}",
        date("d/m/Y") . " às " . date("H:i"),
        $msg
      );
      $msg = str_replace("{{ip}}", $ip, $msg);
      enviaEmail(
        $pessoa["nm_pessoa"],
        $pessoa["email"],
        $msg,
        "Acesso a sua conta",
        null
      );
      echo "valid";
      return;
    }
    echo "nopass";
    return;
  }
  echo "nouser";
  return;
}

if (isset($_POST["recover"])) {
  $email = $_POST["email"];

  $array = [$email];
  $query = "select * from usuario where email=?";
  $user = getSQL($query, "one", $array);
  if ($user) {
    $key = sha1(uniqid(mt_rand(), true));
    $hash = md5($email);

    $array = [$hash, $key];
    $query = "insert into recuperacao values (?, ?)";
    $result = getSQL($query, "mod", $array);
    if ($result) {
      $msg = file_get_contents("../components/tempRecPass.html");
      $msg = str_replace("{{nome}}", $user["nm_pessoa"], $msg);
      $msg = str_replace("{{user}}", $hash, $msg);
      $msg = str_replace("{{key}}", $key, $msg);
      $assunto = "Recuperação de senha";
      $return = enviaEmail($user["nm_pessoa"], $email, $msg, $assunto, null);
      if ($return) {
        echo "recsent";
        return;
      } else {
        $query = "delete from recuperacao where user = ? and user_key = ?";
        $result = getSQL($query, "mod", $array);
      }
    }
    echo "error";
    return;
  } else {
    echo "nouser";
    return;
  }
}

if (isset($_POST["editPass"])) {
  $password = $_POST["senha1"];
  $confirmation = $_POST["senha2"];
  $email = $_POST["email"];

  $array = [$email];
  $query = "select * from usuario where email=?";
  $pessoa = getSQL($query, "one", $array);

  if ($pessoa) {
    if ($password == $confirmation) {
      $newpass = password_hash($password, PASSWORD_DEFAULT);
      $array = [$newpass, $email];
      $query = "update usuario set senha= ? where email = ?";
      $status = getSQL($query, "mod", $array);

      if ($status) {
        echo "valid";
        return;
      }
    }
  }
  echo "error";
  return;
}

if (isset($_GET["sair"])) {
  session_destroy();
  header("location:../../index.html");
}

if (isset($_POST['id']) && isset($_POST['tipo'])) {
  switch ($_POST['tipo']) {
    case 'posto':
      $query = "SELECT p.*,b.* from postos p natural join bandeiras b where cod_posto like ?";
      $posto = getSQL($query, "one", array($_POST['id']));
      $query = "SELECT * from bandeiras";
      $band = getSQL($query, "all");
      $query = "SELECT * from combustiveis";
      $comb = getSQL($query, "all");
      $option ='';
      foreach ($band as $single){
        if($single['cod_band']==$posto['cod_band']){
          $option.= "<option selected value='".$single["cod_band"]."'>".$single["nm_band"]."</option>";
        } else {
          $option.= "<option value='".$single["cod_band"]."'>".$single["nm_band"]."</option>";
        }
      }
      $combinput = '';
      foreach ($comb as $single){
        if($_SESSION["cod_pessoa"]!=1){
          $combinput .= "<div class='cardcomb'>
          <h1>".$single['nm_comb']."</h1>
          <h2>{{".$single['nm_comb']."}}</h2>
        </div>";
        } else {
          $combinput .= "<div class='input comb'>
          <label for='".$single['nm_comb']."'>".$single['nm_comb'].": </label
          ><input type='number' value='{{".$single['nm_comb']."}}' id='".$single['nm_comb']."' name='".$single['nm_comb']."'/>
        </div>";
        }
      }
      $query = "SELECT c.nm_comb, v.valor FROM combustiveis c LEFT JOIN 
      (SELECT v1.cod_comb, v1.valor FROM vende v1 JOIN 
      (SELECT cod_comb, MAX(dt_registro) AS max_dt FROM vende WHERE cod_posto = ? GROUP BY cod_comb) v2 
      ON v1.cod_comb = v2.cod_comb AND v1.dt_registro = v2.max_dt
      WHERE v1.cod_posto = ? ) v ON c.cod_comb = v.cod_comb";
      $comb = getSQL($query, "all", array($_POST['id'],$_POST['id']));
      if($_SESSION["cod_pessoa"]!=1){
        $msg = file_get_contents("../../Posto/tempUser.html");
      } else {
        $msg = file_get_contents("../../Posto/tempInput.html");
      }
      $msg = str_replace("{{img}}", $posto["img_band"], $msg);
      $msg = str_replace("{{nome}}", $posto["nm_posto"], $msg);
      $msg = str_replace("{{endereco}}", $posto["endereco"], $msg);
      $msg = str_replace("{{cod}}", $posto["cod_posto"], $msg);
      $msg = str_replace("{{nota}}", $posto["nota"], $msg);
      if($_SESSION["cod_pessoa"]==1){
        $msg = str_replace("{{cnpj}}", $posto["cnpj"], $msg);
        $msg = str_replace("{{bands}}", $option, $msg);
      }
      $msg = str_replace("{{combsinput}}", $combinput, $msg);
      foreach ($comb as $single){
        if(!$single['valor']||$single['valor']==0.000){
          $msg = str_replace("{{".$single['nm_comb']."}}", "---", $msg);
        } else {
          $msg = str_replace("{{".$single['nm_comb']."}}", $single['valor'], $msg);
        }
      }
      echo $msg;
      break;
    case 'combustivel':
      $query = "SELECT * from combustiveis where cod_comb = ?";
      $comb = getSQL($query, "one", array($_POST['id']));
      $msg = file_get_contents("../../Comb/tempInput.html");
      $msg = str_replace("{{nome}}", $comb["nm_comb"], $msg);
      $msg = str_replace("{{cod}}", $comb["cod_comb"], $msg);
      echo $msg;
      break;
    case 'bandeira':
      $query = "SELECT * from bandeiras where cod_band = ?";
      $band = getSQL($query, "one",array($_POST['id']));
      $msg = file_get_contents("../../Bandeira/tempInput.html");
      $msg = str_replace("{{img}}", $band["img_band"], $msg);
      $msg = str_replace("{{nome}}", $band["nm_band"], $msg);
      $msg = str_replace("{{cod}}", $band["cod_band"], $msg);
      echo $msg;
      break;
    case 'user':
      $query = "SELECT * from usuario where cod_pessoa = ?";
      $user = getSQL($query, "one",array($_POST['id']));
      $msg = file_get_contents("../../Usuario/tempInput.html");
      $msg = str_replace("{{nome}}", $user["nm_pessoa"], $msg);
      $msg = str_replace("{{email}}", $user["email"], $msg);
      $msg = str_replace("{{cod}}", $user["cod_pessoa"], $msg);
      $msg = str_replace("{{cpf}}", $user["cpf"], $msg);
      if ($user['status']==1){
        $msg = str_replace("{{truecheck}}", 'checked', $msg);
        $msg = str_replace("{{falsecheck}}", '', $msg);
      } else {
        $msg = str_replace("{{truecheck}}", '', $msg);
        $msg = str_replace("{{falsecheck}}", 'checked', $msg);
      }
      echo $msg;
      break;
    
    default:
      break;
  }
}


if (isset($_POST["pesquisa"]) && isset($_POST['pagina'])) {
  $array = array("%".$_POST["pesquisa"]."%");
  switch ($_POST["pagina"]) {
    case "Postos":
      $array = array("%".$_POST["pesquisa"]."%","%".$_POST["pesquisa"]."%");

      if(isset($_SESSION['comb'])){
        $query = "SELECT p.*, v.valor, b.img_band
        FROM postos p
        JOIN vende v using (cod_posto)
        JOIN bandeiras b using (cod_band)
        WHERE ".(isset($_SESSION['band']) ? "b.cod_band = " . $_SESSION['band'] . " AND ":"")."
        v.cod_comb = ".$_SESSION['comb']."
        AND (p.nm_posto like ? or p.endereco like ?)
        AND v.dt_registro = (
          SELECT MAX(dt_registro)
          FROM vende
          WHERE cod_posto = p.cod_posto
          AND cod_comb = ".$_SESSION['comb']."
        )";
      } else {
        $query = "SELECT p.*,b.img_band, count(f.cod_pessoa) favs from postos p natural join bandeiras b left join favoritos f using (cod_posto) where (p.nm_posto like ? or p.endereco like ?)
        ".(isset($_SESSION['band']) ? "AND b.cod_band = " . $_SESSION['band'] : "")." group by cod_posto";
      }
      
      if(isset($_SESSION['ordem'])){
        $query.= isset($_SESSION['comb'])? " ORDER BY valor ".$_SESSION['ordem'].";" : " ORDER BY favs ".$_SESSION['ordem'].";";
      }

      // $query = "SELECT p.*,b.img_band, count(f.cod_pessoa) favs from postos p natural join bandeiras b left join favoritos f using (cod_posto)
      // where p.nm_posto like ? or p.endereco like ? group by cod_posto";
    $postos = getSQL($query, "all", $array);
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
            <div class="info"><h1>
              <?php echo isset($_SESSION['comb']) ? "R$ ".($posto["valor"]==0.000?"---":$posto["valor"]) : "Usuários: ".$posto["favs"];?>
            </h1></div>
          </div> <?php }
    } else {
      ?> <h1>Não há resultados com a pesquisa</h1> <?php
    }
      break;
    case "Bandeiras":
      $query = "SELECT b.*, count(p.cod_posto) qntd FROM bandeiras b LEFT JOIN postos p ON b.cod_band = p.cod_band WHERE b.nm_band like ? GROUP BY b.cod_band";
    if(isset($_SESSION['ordem'])){
      $query.=  " ORDER BY qntd ".$_SESSION['ordem'].";";
    }
    // $query = "SELECT b.*, count(p.cod_posto) qntd FROM bandeiras b LEFT JOIN postos p ON b.cod_band = p.cod_band WHERE b.nm_band like ? GROUP BY b.cod_band;";
    $bands = getSQL($query, "all", $array);
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
        <?php }
        } else {
          ?> <h1>Não há resultados com a pesquisa</h1> <?php
        }
      break;
    case "Combustiveis":
      $query = "SELECT c.*, COUNT(DISTINCT v.cod_posto) qntd FROM combustiveis c LEFT JOIN vende v ON c.cod_comb = v.cod_comb WHERE c.nm_comb like ? GROUP BY c.nm_comb";
    if(isset($_SESSION['ordem'])){
      $query.=  " ORDER BY qntd ".$_SESSION['ordem'].";";
    }
      // $query = "SELECT c.*, COUNT(DISTINCT v.cod_posto) qtnd FROM combustiveis c INNER JOIN vende v ON c.cod_comb = v.cod_comb WHERE c.nm_comb like ? GROUP BY c.nm_comb;";
    $combs = getSQL($query, "all", $array);
    if($combs){
    foreach ($combs as $comb) { ?>
    <div class="card">
            <input type="hidden" name="combustivel" value="<?php echo $comb['cod_comb']?>"/>
            <div class="about">
              <div class="text">
                <h1><?php echo $comb['nm_comb']?></h1>
              </div>
            </div>
            <div class="info"><h1>Postos: <?php echo $comb['qtnd']?></h1></div>
          </div>
          <?php }
          } else {
            ?> <h1>Não há resultados com a pesquisa</h1> <?php
          }
      break;
    case "Usuários":
      $array = array("%".$_POST["pesquisa"]."%","%".$_POST["pesquisa"]."%");
      $query = 'SELECT u.* from usuario u where (u.nm_pessoa like ? or u.email like ?)';
      if(isset($_SESSION['status'])){
        $query.=  " status = ".$_SESSION['status'].";";
      }
    $pessoas = getSQL($query, 'all', $array);
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
                        echo 'Não confirmado';
                        break;
                    default:
                        break;
                }
                ?></h1>
              </div>
            </div>
          </div> <?php }
} else {
  ?> <h1>Não há resultados com a pesquisa</h1> <?php
}
      break;

    default:
      break;
  }
}

if (isset($_POST["alterar"])) {
  switch ($_POST['page']) {
    case 'posto':
      $cod = $_POST['id'];
      $nome = $_POST['nome'];
      $endereco = $_POST['endereco'];
      $cnpj = $_POST['cnpj'];
      $nota = $_POST['nota'];
      $band = $_POST['band'];
      // $comb = [$_POST['gasolina'],$_POST['gasol_adt'],$_POST['gasol_prem'],$_POST['etanol'],$_POST['etanol_adt'],$_POST['diesel'],$_POST['diesel_adt'],$_POST['gnv']];
      $query = "update postos set nm_posto = ?, endereco = ?, cnpj = ?, nota = ?, cod_band = ? where cod_posto = ?";
      $array = [$nome,$endereco,$cnpj,$nota,$band,$cod];
      if (getSQL($query, "mod", $array)){
        $query = "select nm_comb from combustiveis";
        $combs = getSQL($query, "all");
        foreach ($_POST as $name => $value){
          $query = "select cod_comb from combustiveis where nm_comb = ?";
          $combcode = getSQL($query, "one", array(str_replace("_", ' ', $name)));
          if ($combcode){
            $query = "insert into vende (cod_posto,cod_comb,valor) values (?,?,?)";
            $array = [$cod,$combcode['cod_comb'],$value];
            if (!getSQL($query,'mod',$array)){
              $error = true;
            }
          }
        }
        if(!isset($error)){
          echo "ok";
          die();
        }
      }
      echo "error";

      break;
    case 'band':
      $cod = $_POST['id'];
      $nome = $_POST['nome'];
      if (empty($_FILES['img']['name'])){
        $query = "update bandeiras set nm_band = ? where cod_band = ?";
        $array = [$nome,$cod];
      } else {
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], "../../Images/$img");
        $query = "update bandeiras set nm_band = ?, img_band = ? where cod_band = ?";
        $array = [$nome,$img,$cod];
      }
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'comb':
      $cod = $_POST['id'];
      $nome = $_POST['nome'];
      $query = "update combustiveis set nm_comb = ? where cod_comb = ?";
      $array = [$nome,$cod];
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'user':
      $cod = $_POST['id'];
      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $cpf = $_POST['cpf'];
      $status = $_POST['status'];
      $query = "update usuario set nm_pessoa = ?, email = ?, cpf = ?, status = ? where cod_pessoa = ?";
      $array = [$nome,$email,$cpf,$status,$cod];
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    
    default:
      # code...
      break;
  }
}

if (isset($_POST["excluir"])) {
  switch ($_POST['page']) {
    case 'posto':
      $cod = $_POST['id'];
      $array = [$cod];
      $query = "DELETE FROM postos WHERE cod_posto = ?";
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'band':
      $cod = $_POST['id'];
      $array = [$cod];
      $query = "DELETE FROM bandeiras WHERE cod_band = ?";
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'comb':
      $cod = $_POST['id'];
      $array = [$cod];
      $query = "DELETE FROM combustiveis WHERE cod_comb = ?";
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'user':
      if($_SESSION['cod_pessoa'] == $_POST['id']){
        echo "erro";
        die();
      }
      $cod = $_POST['id'];
      $array = [$cod];
      $query = "DELETE FROM usuario WHERE cod_pessoa = ?";
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    
    default:
      # code...
      break;
  }
}


if (isset($_POST["cadastrar"])) {
  switch ($_POST['page']) {
    case 'posto':
      $nome = $_POST['nome'];
      $endereco = $_POST['endereco'];
      $cnpj = $_POST['cnpj'];
      $nota = $_POST['nota'];
      $band = $_POST['band'];
      // $comb = [$_POST['gasolina'],$_POST['gasol_adt'],$_POST['gasol_prem'],$_POST['etanol'],$_POST['etanol_adt'],$_POST['diesel'],$_POST['diesel_adt'],$_POST['gnv']];
      $query = "insert into postos (nm_posto,endereco,cnpj,nota,cod_band) values (?,?,?,?,?)";
      $array = [$nome,$endereco,$cnpj,$nota,$band];
      if (getSQL($query, "mod", $array)){
        $query = "select cod_posto from postos where cnpj = ?";
        $posto = getSQL($query, "one",array($cnpj));
        $query = "select nm_comb from combustiveis";
        $combs = getSQL($query, "all");
        foreach ($_POST as $name => $value){
          $query = "select cod_comb from combustiveis where nm_comb = ?";
          $combcode = getSQL($query, "one", array(str_replace("_", ' ', $name)));
          if ($combcode){
            $query = "insert into vende (cod_posto,cod_comb,valor) values (?,?,?)";
            $array = [$posto['cod_posto'],$combcode['cod_comb'],$value];
            if (!getSQL($query,'mod',$array)){
              $error = true;
            }
          }
        }
        if(!isset($error)){
          echo "ok";
          die();
        }
      }
      echo "error";

      break;
    case 'band':
      $nome = $_POST['nome'];
      $img = $_FILES['img']['name'];
      move_uploaded_file($_FILES['img']['tmp_name'], "../../Images/$img");
      $query = "insert into bandeiras (nm_band,img_band) values (?,?)";
      $array = [$nome,$img];
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "error";
        }
      break;
    case 'comb':
      $nome = $_POST['nome'];
      $query = "insert into combustiveis (nm_comb) values (?)";
      $array = [$nome];
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    case 'user':
      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $cpf = $_POST['cpf'];
      $status = $_POST['status'];
      $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
      $query = "insert into usuario (nm_pessoa,email,cpf,status,senha) values (?,?,?,?,?)";
      $array = [$nome,$email,$cpf,$status,$senha];
      if (getSQL($query,"mod",$array)) {
        echo "ok";
        die();
        } else {
          echo "erro";
        }
      break;
    
    default:
      # code...
      break;
  }
}

if (isset($_POST["getbandeiras"])) {
  $query = "SELECT * FROM bandeiras b;";
  $bands = getSQL($query, "all");
  $text = '';
  foreach ($bands as $single){
    $text .= "<option value='".$single["cod_band"]."'>".$single["nm_band"]."</option>";
  }
  echo $text;
}

if (isset($_POST["getcombs"])){
  $query = "SELECT * from combustiveis";
  $comb = getSQL($query, "all");
  $text = '';
  foreach ($comb as $single){
    $text .= "<div class='input comb' style='display: inline-flex'>
    <label for='".$single['nm_comb']."'>".$single['nm_comb'].": </label
    ><input type='number' id='".$single['nm_comb']."' name='".$single['nm_comb']."'/>
  </div>";
  }
  echo $text;
}

if (isset($_POST['optioncomb'])){
  $query = "SELECT * from combustiveis";
  $comb = getSQL($query, "all");
  if ($_SESSION["cod_pessoa"]!=1){
    $text = "";
  } else {
    $text = "<option selected value=''>Qualquer</option>";
  }
  foreach ($comb as $single){
    $text .= "<option ".(($single['nm_comb']=="Gasolina"&&$_SESSION["cod_pessoa"]!=1)?"selected":"")." value='".$single['cod_comb']."'>".$single['nm_comb']."</option>";
  }
  echo $text;
}
if (isset($_POST['optionband'])){
  $query = "SELECT * from bandeiras";
  $comb = getSQL($query, "all");
  $text = "<option selected value=''>Qualquer</option>";
  foreach ($comb as $single){
    $text .= "<option value='".$single['cod_band']."'>".$single['nm_band']."</option>";
  }
  echo $text;
}

if (isset($_POST['userChange'])){
  $cod = $_SESSION['cod_pessoa'];
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $query = "update usuario set nm_pessoa = ?, email = ?, cpf = ? where cod_pessoa = ?";
  $array = [$nome,$email,$cpf,$cod];
  if (getSQL($query,"mod",$array)) {
      $_SESSION["cpf"] = $cpf;
      $_SESSION["nome"] = $nome;
      $_SESSION["email"] = $email;
      echo "ok";
      die();
    } else {
        echo "erro";
      }
}

if (isset($_POST['validUser'])){
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $msg = '';
  $array = [$email];
  $query = "select * from usuario where email = ?";
  $check = getSQL($query, "one", $array);
  $array = [$cpf];
  $query = "select * from usuario where cpf = ?";
  $check2 = getSQL($query, "one", $array);

  if ($check || $check2) {
    if ($check) {
      $msg .= "haveemail";
    }
    if ($check2) {
      $msg .= "havecpf";
    }
  } else {
    $msg .= 'ok';
  }
  echo $msg;
}

if (isset($_POST['validPass'])){
  $senha = $_POST['senhaatual'];
  $newpass = $_POST['senhanova'];
  $query = "select * from usuario where cod_pessoa = ?";
  $user = getSQL($query, "one", array($_SESSION['cod_pessoa']));

  if(!password_verify($senha, $user["senha"])){
    echo 'erro';
    $valid = false;
  }
  if(password_verify($newpass, $user["senha"])){
    echo 'igual';
    $valid = false;
  }
  if(!isset($valid)){
    echo 'ok';
  }
}

if (isset($_POST['passChange'])){
  $cod = $_SESSION['cod_pessoa'];
  $newpass = password_hash($_POST["senhanova"], PASSWORD_DEFAULT);
  $query = "update usuario set senha = ? where cod_pessoa = ?";
  $array = [$newpass,$cod];
  if (getSQL($query,"mod",$array)) {
      echo "ok";
      die();
    } else {
        echo "erro";
      }
}

if (isset($_POST['definefilter'])){
  $_SESSION['band'] = isset($_POST['band'])&&$_POST['band']!='' ? $_POST['band'] : null;
  $_SESSION['comb'] = isset($_POST['comb'])&&$_POST['comb']!='' ? $_POST['comb'] : null;
  $_SESSION['status'] = isset($_POST['status'])&&$_POST['status']!='' ? $_POST['status'] : null;
  $_SESSION['ordem'] = isset($_POST['ordem'])&&$_POST['ordem']!='' ? $_POST['ordem'] : null;
  echo 'ok';
}