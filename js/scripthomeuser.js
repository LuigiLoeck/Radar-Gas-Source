document.addEventListener('DOMContentLoaded', function () {
  if (localStorage.getItem('dark')) {
    document.body.classList.toggle('lighttheme')
  }

  var params = new URLSearchParams()
  params.append('definefilter', true)
  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  }).then(function (response) {
    if (response.ok) {
      getData('Postos')
    }
  })

  document.getElementById('pagemode').addEventListener('click', function () {
    let theme = localStorage.getItem('dark')
    document.body.classList.toggle('lighttheme')
    if (!theme) {
      localStorage.setItem('dark', 'true')
    } else {
      localStorage.removeItem('dark')
    }
  })

  let optionband = document.getElementById('band')
  var params = new URLSearchParams()
  params.append('optionband', true)
  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        optionband.innerHTML = dados
      }
    })

  let optioncomb = document.getElementById('comb')
  var params = new URLSearchParams()
  params.append('optioncomb', true)
  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        optioncomb.innerHTML = dados
      }
    })

  // menu honz
  // let pages = document.getElementById('pages').querySelectorAll('li')
  // pages.forEach(element => {
  //   element.addEventListener('click', () => {
  //     let temp = document.querySelector('.selected')
  //     temp.classList.remove('selected')
  //     element.classList.add('selected')
  //   })
  // })

  // correto

  let fav = document.getElementById('favorito')
  fav.addEventListener('click', () => {
    getData(fav.innerText)
    document.getElementById('usertouch').checked = false
    document.getElementById('pagetitle').innerHTML = fav.innerText
    document.getElementById("logo").addEventListener("click", ()=>{
      getData("Postos")
      document.getElementById('pagetitle').innerHTML = "Postos"
    })
  })

  let menu = document.querySelector('header')
  menu.addEventListener('mouseleave', () => {
    document.getElementById('usertouch').checked = false
    document.getElementById('touch').checked = false
  })

  let filter = document.getElementById('filter')
  let filtermenu = document.getElementById('filtermenu')
  filter.addEventListener('click', function () {
    filtermenu.classList.toggle('close')
  })

  let applyfilter = document.getElementById('searchfilter')
  let filterform = document.getElementById('filterform')
  applyfilter.addEventListener('click', () => {
    let combinput = document.getElementById('comb')
    var params = new FormData(filterform)
    params.append('comb', combinput.value)
    params.append('definefilter', true)
    fetch('./includes/logic/logica.php', {
      method: 'POST',
      body: params
    })
      .then(function (response) {
        if (response.ok) return response.text()
      })
      .then(function (dados) {
        if (dados) {
          document.getElementById('filtermenu').classList.toggle('close')
          filter.innerHTML = 'Filtro Ativo'
          getData("Postos")
        }
      })
  })

  let filterinputs = filterform.querySelectorAll('select')
  let resetfilter = document.getElementById('resetfilter')
  resetfilter.addEventListener('click', () => {
    var params = new URLSearchParams()
    params.append('definefilter', true)
    fetch('./includes/logic/logica.php', {
      method: 'POST',
      body: params
    })
      .then(function (response) {
        if (response.ok) return response.text()
      })
      .then(function (dados) {
        if (dados) {
          filter.innerHTML = 'Filtro'
          filterinputs.forEach(input => {
            input.value = ''
          })
          document.getElementById('comb').value = "1"
          getData("Postos")
        }
      })
  })
})

function getData(page) {
  const searchLabel = document.querySelector('.searchbar').firstElementChild
  switch (page) {
    case 'Favoritos':
      link = './Usuario/listarFavs.php'
      searchLabel.innerHTML = 'Pesquise pelo nome ou endereço'
      break
    case 'Postos':
      link = './Posto/listarPosto.php'
      searchLabel.innerHTML = 'Pesquise pelo nome ou endereço'
      break

    default:
      break
  }

  fetch(link)
    .then(function (response) {
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        document.getElementById('result').innerHTML = dados
        cardScript()
      }
    })
}

function search() {
  let searchData = document.getElementById('inputSearchBar').value
  var params = new URLSearchParams()
  params.append('pesquisa', searchData)
  params.append('pagina', 'Postos')
  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        document.getElementById('result').innerHTML = dados
        cardScript()
      }
    })
}

function cardScript() {
  let cards = document.querySelectorAll('.card')
  let popup = document.getElementById('popup')
  cards.forEach(card => {
    card.addEventListener('click', () => {
      let type = card.querySelector('input').name
      popup.classList.add(type)
      let data = card.querySelector('input').value
      var params = new URLSearchParams()
      params.append('id', data)
      params.append('tipo', type)

      // console.log(params)

      fetch('./includes/logic/logica.php', {
        method: 'POST',
        body: params,
        cache: "reload"
      })
        .then(function (response) {
          // console.log(response)
          if (response.ok) return response.text()
        })
        .then(function (dados) {
          // console.log(dados)
          document.getElementById('datacrud').innerHTML = dados
          popup.classList.remove('disapear')
          popup.firstElementChild.classList.remove('hidden')
          document.getElementById('close').addEventListener('click', () => {
            popup.classList.add('disapear')
            popup.firstElementChild.classList.add('hidden')
            popup.classList.remove(type)
          })
          popup.addEventListener('click', e => {
            if (e.target.id == 'popup') {
              popup.classList.add('disapear')
              popup.firstElementChild.classList.add('hidden')
              popup.classList.remove(type)
            }
          })
        })
    })
  })
}

window.onscroll = function () {
  scrollFunction()
}

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById('top').style.bottom = '20px'
  } else {
    document.getElementById('top').style.bottom = '-10%'
  }
}

function topFunction() {
  document.body.scrollTop = 0 // For Safari
  document.documentElement.scrollTop = 0 // For Chrome, Firefox, IE and Opera
}

function applyfilter() {
  let filter = document.getElementById('filter')
  let combinput = document.getElementById('comb')
  let filterform = document.getElementById('filterform')
  var params = new FormData(filterform)
  params.append('comb', combinput.value)
  params.append('definefilter', true)
  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        filter.innerHTML = 'Filtro Ativo'
        getData("Postos")
      }
    })
}
