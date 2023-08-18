document.addEventListener('DOMContentLoaded', function () {
  if (localStorage.getItem('dark')) {
    document.body.classList.toggle('lighttheme')
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

  let menu = document.querySelector('header')
  menu.addEventListener('mouseleave', () => {
    document.getElementById('usertouch').checked = false
  })

  let alterUser = document.getElementById('alter')
  alterUser.addEventListener('click', () => {
    alterUser.hidden = true
    document.getElementById('cancel').hidden = false
    document.getElementById('salvar').hidden = false
    let inputs = document.getElementById('form').querySelectorAll('input')
    inputs.forEach(element => {
      if (element.readOnly == true) {
        element.removeAttribute('readonly')
        element.setAttribute('data-original-value', element.value)
      }
    })
    document.getElementById('cancel').addEventListener('click', () => {
      alterUser.hidden = false
      document.getElementById('cancel').hidden = true
      document.getElementById('salvar').hidden = true
      inputs.forEach(element => {
        element.readOnly = true
        element.value = element.getAttribute('data-original-value')
      })
      return
    })
    document.getElementById('salvar').addEventListener('click', () => {
      if (crudFunction('user')) {
        alterUser.hidden = false
        document.getElementById('cancel').hidden = true
        document.getElementById('salvar').hidden = true
        inputs.forEach(element => {
          element.readOnly = true
          element.setAttribute('data-original-value', element.value)
        })
      }
    })
  })

  let alterPass = document.getElementById('alterar')
  alterPass.addEventListener('click', () => {
    var valid = true
    let oldpass = document.getElementById('senhaatual')
    let newpass = document.getElementById('senhanova')
    let confirmpass = document.getElementById('senhaconfirm')
    var params = new URLSearchParams()
    params.append('senhaatual', oldpass.value)
    params.append('senhanova', newpass.value)
    params.append('validPass', 'true')

    fetch('./includes/logic/logica.php', {
      method: 'POST',
      body: params
    })
      .then(function (response) {
        // console.log(response)
        if (response.ok) return response.text()
      })
      .then(function (dados) {
        if (dados.includes('erro')) {
          invalid('senhaatual', 'Senha atual errada')
          valid = false
        }
        if (dados.includes('igual')) {
          invalid('senhanova', 'Senha nova igual a antiga')
          valid = false
        }
        if (confirmpass.value != newpass.value) {
          invalid('senhaconfirm', 'Confirmação não é igual')
          valid = false
        }

        if (valid == true) {
          crudFunction('password')
        }
      })
  })
})

function limitarCPF(element) {
  if (element.value.length > 11) {
    element.value = element.value.slice(0, 11)
  }
}

function crudFunction(page) {
  if (page == 'user') {
    if (validaUser()) {
      var form = document.getElementById('form')
    } else {
      return false
    }
  } else if (page == 'password') {
    var form = document.getElementById('form2')
  }
  var params = new FormData(form)
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
        console.log(dados)
        let popup = document.getElementById('popup')
        if (dados == 'ok') {
          if (page === 'user') {
            document.getElementById('datacrud').innerHTML =
              '<h1>Alteração feita com sucesso!</h1>'
          } else {
            document.getElementById('senhaatual').value = ''
            document.getElementById('senhanova').value = ''
            document.getElementById('senhaconfirm').value = ''
            document.getElementById('datacrud').innerHTML =
              '<h1>Senha alterada com sucesso!</h1>'
          }
        } else {
          document.getElementById('datacrud').innerHTML =
            '<h1>Erro na alteração! Tente novamente mais tarde.</h1>'
        }
        popup.classList.remove('disapear')
        popup.firstElementChild.classList.remove('hidden')
        popup.addEventListener('click', e => {
          if (e.target.id == 'popup') {
            popup.classList.add('disapear')
            popup.firstElementChild.classList.add('hidden')
          }
        })
      }
    })
}

function validaUser() {
  var email = document.getElementById('email')
  var cpf = document.getElementById('cpf')
  var params = new URLSearchParams()
  params.append('email', email.value)
  params.append('cpf', cpf.value)
  params.append('validUser', 'true')

  fetch('./includes/logic/logica.php', {
    method: 'POST',
    body: params
  })
    .then(function (response) {
      // console.log(response)
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      switch (dados) {
        case 'havecpf':
          invalid('cpf', 'CPF já existe')
          return false

        case 'haveemail':
          invalid('email', 'Email já existe')
          return false

        case 'haveemailhavecpf':
          invalid('email', 'Email já existe')
          invalid('cpf', 'CPF já existe')
          return false

        case 'ok':
          return true

        default:
          return false
      }
    })
}

function invalid(id, msg = null) {
  let input = document.getElementById(id)
  input.parentNode.classList.add('invalid')
  const temp = input.parentNode.firstElementChild.innerHTML
  input.addEventListener('keypress', () => {
    input.parentNode.firstElementChild.innerHTML = temp
    input.parentNode.classList.remove('invalid')
  })
  if (msg != null) {
    input.parentNode.firstElementChild.innerHTML = msg
  }
}
