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
      getData(document.getElementById('labelpage').innerHTML)
    }
  })

  if (localStorage.getItem('page')) {
    document.getElementById('labelpage').innerHTML =
      localStorage.getItem('page')
    document.getElementById('pagetitle').innerHTML =
      localStorage.getItem('page')
    let pages = document.getElementById('pages').querySelectorAll('li')
    pages.forEach(text => {
      if (localStorage.getItem('page').includes(text.innerHTML)) {
        text.hidden = true
      }
    })
  }

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
    document.getElementById('labelpage').innerHTML = fav.innerText
    localStorage.setItem('page', fav.innerText)
    let pages = document.getElementById('pages').querySelectorAll('li')
    pages.forEach(text => {
      if (text.hidden) {
        text.hidden = false
      }
    })
  })

  let pages = document.getElementById('pages').querySelectorAll('li')
  let text = document.getElementById('labelpage')
  let title = document.getElementById('pagetitle')
  pages.forEach(element => {
    element.addEventListener('click', () => {
      getData(element.innerHTML)
      temp = text.innerHTML
      text.innerHTML = element.innerHTML
      title.innerHTML = element.innerHTML
      localStorage.setItem('page', element.innerHTML)
      document.getElementById('touch').checked = false
      element.hidden = true
      pages.forEach(text => {
        if (text.hidden && temp.includes(text.innerHTML)) {
          text.hidden = false
        }
      })
    })
  })

  let menu = document.querySelector('header')
  menu.addEventListener('mouseleave', () => {
    document.getElementById('usertouch').checked = false
    document.getElementById('touch').checked = false
  })

  let register = document.getElementById('register')
  register.addEventListener('click', () => {
    cadastrar()
  })

  let filter = document.getElementById('filter')
  let filtermenu = document.getElementById('filtermenu')
  filter.addEventListener('click', function () {
    filtermenu.classList.toggle('close')
  })

  let applyfilter = document.getElementById('searchfilter')
  let filterform = document.getElementById('filterform')
  applyfilter.addEventListener('click', () => {
    var params = new FormData(filterform)
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
          getData(document.getElementById('labelpage').innerHTML)
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
          getData(document.getElementById('labelpage').innerHTML)
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
    case 'Bandeiras':
      link = './Bandeira/listarBand.php'
      searchLabel.innerHTML = 'Pesquise pelo nome'
      break
    case 'Combustiveis':
      link = './Comb/listarComb.php'
      searchLabel.innerHTML = 'Pesquise pelo nome'
      break
    case 'Usuários':
      link = './Usuario/listarUser.php'
      searchLabel.innerHTML = 'Pesquise pelo nome ou email'
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
  let page = document.getElementById('labelpage').innerHTML
  var params = new URLSearchParams()
  params.append('pesquisa', searchData)
  params.append('pagina', page)
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
        body: params
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
          document.querySelector('.update').addEventListener('click', () => {
            crudFunction('alterar')
          })
          document.querySelector('.delete').addEventListener('click', () => {
            crudFunction('excluir')
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

function crudFunction(page) {
  if (page == 'excluir') {
    if (!confirm('Comfirmar exclusão?')) {
      return
    }
  }

  var form = document.getElementById('form')
  var params = new FormData(form)

  switch (page) {
    case 'excluir':
      params.append('excluir', 'true')
      break
    case 'alterar':
      params.append('alterar', 'true')
      break
    case 'register':
      params.append('cadastrar', 'true')
      break

    default:
      break
  }

  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      console.log(dados)
      switch (dados) {
        case 'ok':
          if (page == 'alterar') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Alteração feita com sucesso!</h1>'
          }
          if (page == 'excluir') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Exclusão feita com sucesso!</h1>'
          }
          if (page == 'register') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Cadastro concluido com sucesso!</h1>'
          }
          break
        case 'error':
          if (page == 'alterar') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Erro na alteração! Tente novamente mais tarde.</h1>'
          }
          if (page == 'excluir') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Erro na Exclusão! Tente novamente mais tarde.</h1>'
          }
          if (page == 'register') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Erro no cadastro! Tente novamente mais tarde.</h1>'
          }
          break

        default:
          break
      }
      getData(document.getElementById('labelpage').innerHTML)
    })
}

// function alter() {
//   var form = document.getElementById('form')
//   var params = new FormData(form)
//   params.append('alterar', 'true')

//   fetch('./includes/logic/logica.php', {
//     method: 'POST',
//     body: params
//   })
//     .then(function (response) {
//       // console.log(response)
//       if (response.ok) return response.text()
//     })
//     .then(function (dados) {
//       console.log(dados)
//       switch (dados) {
//         case 'ok':
//           document.getElementById('datacrud').innerHTML =
//             '<h1>Alteração feita com sucesso!</h1>'
//           break
//         case 'error':
//           document.getElementById('datacrud').innerHTML =
//             '<h1>Erro na alteração! Tente novamente mais tarde.</h1>'
//           break

//         default:
//           break
//       }
//       getData(document.getElementById('labelpage').innerHTML)
//     })
// }

// function exclude() {
//   if (!confirm('Comfirmar exclusão?')) {
//     return
//   }
//   var form = document.getElementById('form')
//   var params = new FormData(form)
//   params.append('excluir', 'true')

//   fetch('./includes/logic/logica.php', {
//     method: 'POST',
//     body: params
//   })
//     .then(function (response) {
//       // console.log(response)
//       if (response.ok) return response.text()
//     })
//     .then(function (dados) {
//       console.log(dados)
//       switch (dados) {
//         case 'ok':
//           document.getElementById('datacrud').innerHTML =
//             '<h1>Exclusão feita com sucesso!</h1>'
//           break
//         case 'error':
//           document.getElementById('datacrud').innerHTML =
//             '<h1>Erro na Exclusão! Tente novamente mais tarde.</h1>'
//           break

//         default:
//           break
//       }
//       getData(document.getElementById('labelpage').innerHTML)
//     })
// }

function cadastrar() {
  switch (document.getElementById('labelpage').innerHTML) {
    case 'Postos':
      link = './Posto/tempCad.html'
      var script = true
      break
    case 'Bandeiras':
      link = './Bandeira/tempCad.html'
      break
    case 'Combustiveis':
      link = './Comb/tempCad.html'
      break
    case 'Usuários':
      link = './Usuario/tempCad.html'
      break

    default:
      return
  }
  fetch(link, { cache: 'no-cache' })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        var datacrud = document.getElementById('datacrud')
        datacrud.innerHTML = dados
        if (script == true) {
          var params = new URLSearchParams()
          params.append('getbandeiras', true)
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
                document.getElementById('bandoption').innerHTML = dados
              }
            })
          var params = new URLSearchParams()
          params.append('getcombs', true)
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
                document.getElementById('form').innerHTML += dados
              }
            })
        }
        popup.classList.remove('disapear')
        popup.firstElementChild.classList.remove('hidden')
        document.getElementById('close').addEventListener('click', () => {
          popup.classList.add('disapear')
          popup.firstElementChild.classList.add('hidden')
        })

        document.getElementById('cadastro').addEventListener('click', () => {
          crudFunction('register')
        })
        popup.addEventListener('click', e => {
          if (e.target.id == 'popup') {
            popup.classList.add('disapear')
            popup.firstElementChild.classList.add('hidden')
          }
        })
      }
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
