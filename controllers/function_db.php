<?php
function conecta_DB()
{
  try {
    $conexao = new PDO(
      "mysql:host=localhost; dbname=radargas; charset=utf8",
      "root",
      ""
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conexao;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getSQL($sql, $op, $parametros = [])
{
  try {
    $conexaoBD = conecta_DB();
    $operacao = $conexaoBD->prepare($sql);

    if (sizeof($parametros) > 0) {
      $result = $operacao->execute($parametros);
    } else {
      $result = $operacao->execute();
    }

    switch ($op) {
      case "all":
        $result = $operacao->fetchAll(PDO::FETCH_ASSOC);
        break;

      case "one":
        $result = $operacao->fetch(PDO::FETCH_ASSOC);
        break;

      default:
        break;
    }

    return $result;
  } catch (PDOException $e) {
    echo $e;
  }
}

?>
