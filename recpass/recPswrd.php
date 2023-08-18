<?php
include_once '../controllers/function_db.php';
session_start();
if (isset($_SESSION['logado'])) {
  header('location:../index.php');
}

if (empty($_GET['user']) || empty($_GET['key'])) {
  die('<h1>Não é possível alterar a password: dados em falta</h1>');
}

$user = $_GET['user'];
$key = $_GET['key'];

$array = [$user, $key];
$query = 'select * from recuperacao where user = ? and user_key = ?';

if (getSQL($query, 'one', $array)) {
  $array = [$user, $key];
  $query = 'delete from recuperacao where user = ? and user_key = ?';
  getSQL($query, 'mod', $array);
  $array = [$user];
  $query = 'select * from usuario where md5(email)=?';
  $result = getSQL($query, 'one', $array);
} else {
  die('<p>Link de recuperação invalido</p>');
}
?>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    </style>
    <title>Recuperação</title>
  </head>
  <body>
    <div class="container">
      <div class="form-container">
        <form action="#" method="post" id="form" onsubmit="validForm(event)">
          <div class="text">
            <h1>RadarGas</h1>
            <h2>Criação de nova senha.</h2>
          </div>
          <div class="input">
            <input
              type="password"
              name="senha1"
              id="senha1"
              class="input"
              placeholder=" "
              required
            />
            <label for="senha1">Senha</label>
            <img
              src="./eye.svg"
              alt="<0>"
              id="olho"
              height="32"
              style="transform: translateY(10px); display: none"
            />
          </div>
          <div class="input">
            <input
              type="password"
              name="senha2"
              id="senha2"
              class="input"
              placeholder=" "
              required
            />
            <label for="senha2">Confirma Senha</label>
            <img
              src="./eye.svg"
              alt="<0>"
              id="olho1"
              height="32"
              style="transform: translateY(10px); display: none"
            />
          </div>
          <div class="formLink">
            <button
              type="submit"
              id="bntEntrar"
              name="entrar"
              value="Entrar"
              class="disable"
              style="margin-top: 65px"
              disabled
            >
              Alterar senha
            </button>
            <input type="hidden" name="editPass" id="editPass" value="true" />
            <input type="hidden" name="email" value="<?php echo $result['email']; ?>" readonly/>
          </div>
        </form>
      </div>
    </div>
    <div class="popup disapear" id="popup">
      <div class="popup-inner hidden">
        <div class="popup-close">
          <svg
            height="25px"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            fill="#000000"
            transform="rotate(45)"
            id="close"
          >
            <g id="SVGRepo_bgCarrier" stroke-width="0" />

            <g
              id="SVGRepo_tracerCarrier"
              stroke-linecap="round"
              stroke-linejoin="round"
            />

            <g id="SVGRepo_iconCarrier">
              <title />
              <g id="Complete">
                <g data-name="add" id="add-2">
                  <g>
                    <line
                      fill="none"
                      stroke="#000000"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      x1="12"
                      x2="12"
                      y1="19"
                      y2="5"
                    />
                    <line
                      fill="none"
                      stroke="#000000"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      x1="5"
                      x2="19"
                      y1="12"
                      y2="12"
                    />
                  </g>
                </g>
              </g>
            </g>
          </svg>
        </div>

        <div class="popup-text">
          <h1 id="returnTitle">Cadastro pendente</h1>
          <h2 id="returnText">
            Uma confirmação foi enviada ao e-mail informado.
          </h2>
        </div>
      </div>
    </div>
    <script src="./script.js"></script>
  </body>
</html>