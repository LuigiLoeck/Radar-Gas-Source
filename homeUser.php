<?php
session_start();
include_once "./includes/components/cabecalho.php";
include_once "./controllers/function_db.php";
$_SESSION["pagina"] = "index";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/stylehomeuser.css" />
    <title>Home</title>
  </head>
  <body>
    <header>
      <div id="logo" class="logo">RadarGas</div>
      <div class="pagemenu">
        <div class="userlinks">
          <label class="usericon" for="usertouch" id="labelpage">
            <svg
              fill="currentColor"
              height="40px"
              viewBox="0 0 32 32"
              id="icon"
              xmlns="http://www.w3.org/2000/svg"
            >
              <defs>
                <style>
                  .cls-1 {
                    fill: none;
                  }
                </style>
              </defs>
              <path
                id="_inner-path_"
                data-name="&lt;inner-path&gt;"
                class="cls-1"
                d="M8.0071,24.93A4.9958,4.9958,0,0,1,13,20h6a4.9959,4.9959,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0ZM20.5,12.5A4.5,4.5,0,1,1,16,8,4.5,4.5,0,0,1,20.5,12.5Z"
              />
              <path
                d="M26.7489,24.93A13.9893,13.9893,0,1,0,2,16a13.899,13.899,0,0,0,3.2511,8.93l-.02.0166c.07.0845.15.1567.2222.2392.09.1036.1864.2.28.3008.28.3033.5674.5952.87.87.0915.0831.1864.1612.28.2417.32.2759.6484.5372.99.7813.0441.0312.0832.0693.1276.1006v-.0127a13.9011,13.9011,0,0,0,16,0V27.48c.0444-.0313.0835-.0694.1276-.1006.3412-.2441.67-.5054.99-.7813.0936-.08.1885-.1586.28-.2417.3025-.2749.59-.5668.87-.87.0933-.1006.1894-.1972.28-.3008.0719-.0825.1522-.1547.2222-.2392ZM16,8a4.5,4.5,0,1,1-4.5,4.5A4.5,4.5,0,0,1,16,8ZM8.0071,24.93A4.9957,4.9957,0,0,1,13,20h6a4.9958,4.9958,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0Z"
              />
              <rect
                id="_Transparent_Rectangle_"
                data-name="&lt;Transparent Rectangle&gt;"
                class="cls-1"
                width="32"
                height="32"
              />
            </svg>
          </label>
          <input type="checkbox" id="usertouch" />
          <ul class="dropdownuser">
            <div>
              <h2><?php echo $_SESSION['nome']?></h2>
              <h3><?php echo substr_replace($_SESSION['email'], '</br>', (strpos($_SESSION['email'],'@')), 0);?></h3>
            </div>
            <div>
              <li onclick="window.location.href = './userProfile.php'">
                <svg
                  height="25px"
                  viewBox="0 0 16 16"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m 8 1 c -1.65625 0 -3 1.34375 -3 3 s 1.34375 3 3 3 s 3 -1.34375 3 -3 s -1.34375 -3 -3 -3 z m -1.5 7 c -2.492188 0 -4.5 2.007812 -4.5 4.5 v 0.5 c 0 1.109375 0.890625 2 2 2 h 8 c 1.109375 0 2 -0.890625 2 -2 v -0.5 c 0 -2.492188 -2.007812 -4.5 -4.5 -4.5 z m 0 0"
                    fill="currentColor"
                  />
                </svg>
                Alterar perfil
              </li>
              <li id="favorito">
                <svg
                  fill="#FF9900"
                  height="25px"
                  viewBox="0 0 1000 1000"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M476 801l-181 95q-18 10-36.5 4.5T229 879t-7-36l34-202q2-12-1.5-24T242 596L95 453q-15-14-15.5-33.5T91 385t32-18l203-30q12-2 22-9t16-18l90-184q10-18 28-25t36 0 28 25l90 184q6 11 16 18t22 9l203 30q20 3 32 18t11.5 34.5T905 453L758 596q-8 9-12 21t-2 24l34 202q4 20-7 36t-29.5 21.5T705 896l-181-95q-11-6-24-6t-24 6z"
                  />
                </svg>
                Favoritos
              </li>
              <li id="pagemode">
                <svg
                  class="sun"
                  version="1.1"
                  id="Layer_1"
                  height="25px"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  viewBox="0 0 511.984 511.984"
                  xml:space="preserve"
                >
                  <g>
                    <path
                      style="fill: #f6bb42"
                      d="M255.992,85.333c-5.891,0-10.656-4.781-10.656-10.671V10.664C245.336,4.773,250.102,0,255.992,0
          c5.906,0,10.672,4.773,10.672,10.664v63.998C266.664,80.552,261.898,85.333,255.992,85.333z"
                    />
                    <path
                      style="fill: #FF9900"
                      d="M255.992,511.984C255.992,511.984,256.008,511.984,255.992,511.984
          c-5.875,0-10.656-4.781-10.656-10.656v-63.997c0-5.906,4.781-10.688,10.672-10.688l0,0c5.891,0,10.656,4.781,10.656,10.688v63.997
          C266.664,507.203,261.898,511.984,255.992,511.984z"
                    />
                  </g>
                  <g>
                    <path
                      style="fill: #FF9900"
                      d="M135.324,135.316c-4.172,4.164-10.922,4.164-15.078,0L74.982,90.06
          c-4.156-4.164-4.156-10.914,0-15.078c4.172-4.172,10.922-4.172,15.094,0l45.248,45.248
          C139.496,124.394,139.496,131.152,135.324,135.316z"
                    />
                    <path
                      style="fill: #FF9900"
                      d="M437.018,437.003L437.018,437.003c-4.172,4.172-10.922,4.172-15.094,0l-45.249-45.25
          c-4.172-4.172-4.172-10.921,0-15.077l0,0c4.172-4.172,10.922-4.172,15.094,0l45.249,45.249
          C441.174,426.081,441.174,432.831,437.018,437.003z"
                    />
                  </g>
                  <g>
                    <path
                      style="fill: #FF9900"
                      d="M85.342,255.992c0,5.891-4.781,10.664-10.672,10.664H10.672c-5.891,0-10.656-4.773-10.672-10.664
          c0-5.891,4.781-10.664,10.672-10.664H74.67C80.56,245.328,85.342,250.101,85.342,255.992z"
                    />
                    <path
                      style="fill: #FF9900"
                      d="M511.984,255.992L511.984,255.992c0,5.891-4.766,10.664-10.656,10.664h-63.997
          c-5.891,0-10.672-4.773-10.672-10.664l0,0c0-5.891,4.781-10.664,10.672-10.664h63.997
          C507.219,245.328,511.984,250.101,511.984,255.992z"
                    />
                  </g>
                  <g>
                    <path
                      style="fill: #FF9900"
                      d="M135.324,376.676c4.172,4.156,4.172,10.905,0,15.077l-45.248,45.25
          c-4.172,4.172-10.922,4.172-15.094,0c-4.156-4.172-4.156-10.922,0-15.078l45.264-45.249
          C124.402,372.504,131.152,372.504,135.324,376.676z"
                    />
                    <path
                      style="fill: #FF9900"
                      d="M437.018,74.974C437.018,74.982,437.018,74.974,437.018,74.974c4.155,4.171,4.155,10.921,0,15.085
          l-45.265,45.256c-4.156,4.164-10.906,4.164-15.078,0l0,0c-4.172-4.164-4.172-10.922,0-15.086l45.249-45.256
          C426.096,70.81,432.846,70.81,437.018,74.974z"
                    />
                    <path
                      style="fill: #FF9900"
                      d="M255.992,394.643c-76.45,0-138.651-62.186-138.651-138.651c0-76.458,62.201-138.66,138.651-138.66
          c76.467,0,138.668,62.202,138.668,138.66C394.66,332.458,332.459,394.643,255.992,394.643z"
                    />
                  </g>
                  <path
                    style="fill: #FF9900"
                    d="M255.992,106.661c-82.466,0-149.323,66.857-149.323,149.331c0,82.466,66.857,149.339,149.323,149.339
          c82.482,0,149.34-66.873,149.34-149.339C405.332,173.518,338.474,106.661,255.992,106.661z M346.505,346.489
          c-24.171,24.187-56.311,37.498-90.513,37.498c-34.187,0-66.326-13.312-90.497-37.498c-24.171-24.155-37.499-56.311-37.499-90.497
          s13.328-66.334,37.499-90.505c24.171-24.178,56.311-37.491,90.497-37.491c34.202,0,66.342,13.313,90.513,37.491
          c24.171,24.171,37.483,56.319,37.483,90.505C383.988,290.179,370.676,322.334,346.505,346.489z"
                  />
                </svg>
                <svg
                  viewBox="0 0 16 16"
                  class="moon"
                  fill="none"
                  height="25px"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M7.7066 0.00274765C7.50391 -0.0027381 7.31797 0.114737 7.23588 0.300147C7.15379 0.485558 7.19181 0.702186 7.33213 0.848565C8.36577 1.92686 9.00015 3.3888 9.00015 4.99996C9.00015 8.31366 6.31385 11 3.00015 11C2.5757 11 2.16207 10.956 1.76339 10.8725C1.56489 10.8309 1.36094 10.9133 1.2471 11.0812C1.13325 11.249 1.13207 11.469 1.2441 11.638C2.58602 13.663 4.88682 15 7.50012 15C11.6423 15 15.0001 11.6421 15.0001 7.49996C15.0001 3.42688 11.7534 0.112271 7.7066 0.00274765Z"
                    fill="#DDDDDD"
                  />
                </svg>
                Alterar tema
              </li>
            </div>
            <li onclick="sair()">
              <svg
                height="25px"
                viewBox="0 0 21 21"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g
                  fill="none"
                  fill-rule="evenodd"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  transform="translate(4 3)"
                >
                  <path d="m10.595 10.5 2.905-3-2.905-3" />

                  <path d="m13.5 7.5h-9" />

                  <path
                    d="m10.5.5-8 .00224609c-1.1043501.00087167-1.9994384.89621131-2 2.00056153v9.99438478c0 1.1045695.8954305 2 2 2h8.0954792"
                  />
                </g>
              </svg>
              Sair
            </li>
          </ul>
        </div>
      </div>
    </header>
    <div class="container">
      <section>
        <h1 id="pagetitle">Postos</h1>
      </section>
      <main class="content">
        <!-- pesquisar por estilos de filtros em sites de csgo -->
        <div class="pesquisa">
          <div class="searchbar">
            <label for="inputSearchBar">Pesquise pelo nome</label>
            <input
              type="text"
              name="search"
              id="inputSearchBar"
              placeholder=" "
              onkeyup="search()"
            />
          </div>
          <div class="control comb">
              <label for="comb">Combustivel</label>
              <select name="comb" id="comb" onchange="applyfilter()">
              </select>
            </div>
          <div class="filter">
          <button id="filter">Filtro</button>
          </div>
        </div>
        <div class="filtermenu" id="filtermenu">
          <form class="filteroptions" id="filterform">
            <div class="control band">
              <label for="band">Bandeira</label>
              <select name="band" id="band">
              </select>
            </div>
            <div class="control ordem">
              <label for="ordem">Ordem</label>
              <select name="ordem" id="ordem">
                <option value="">Qualquer</option>
                <option value="asc">Crescente</option>
                <option value="desc">Decrescente</option>
              </select>
            </div>
          </form>
          <div class="filter" style="flex-direction: row; gap: 25px;">
            <button id="resetfilter">Resetar</button>
            <button id="searchfilter">Aplicar</button>
          </div>
        </div>
        <div id="result">
        </div>
        <button onclick="topFunction()" class="top" id="top"><svg xmlns="http://www.w3.org/2000/svg" id="arrow" viewBox="0 0 100 100"><switch><g><path d="M52 83.999V21.655l21.172 21.172a4 4 0 1 0 5.656-5.657l-28-28a4 4 0 0 0-5.656 0l-28 28A3.987 3.987 0 0 0 16 39.999a4 4 0 0 0 6.828 2.828L44 21.655v62.344a4 4 0 0 0 8 0z"></path></g></switch></svg></button>
        <div class="popup disapear" id="popup">
          <div class="popup-inner hidden" id="datacrud">
            
          </div>
        </div>
      </main>
    </div>
    <script>
      function sair(){
    var resposta = confirm("Voce deseja sair do aplicativo?");
    if (resposta){
      window.location.href = "./includes/logic/logica.php?sair=1";
    }
  }
    </script>
    <script src="./js/scripthomeuser.js"></script>
  </body>
</html>
