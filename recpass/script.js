window.onload = function () {
  if (!localStorage.getItem('dark')) {
    document.body.classList.toggle('lighttheme')
  }
  var campo = document.querySelectorAll('.input')
  campo.forEach(input => {
    input.addEventListener('keyup', function () {
      btnCheck()
    })
  })

  var olhos = [
    document.getElementById('olho'),
    document.getElementById('olho1')
  ]
  olhos.forEach(olho => {
    olho.addEventListener('mousedown', () => {
      password = olho.parentNode.firstElementChild
      password.type = 'text'
    })
    olho.addEventListener('mouseup', () => {
      password = olho.parentNode.firstElementChild
      password.type = 'password'
    })
  })

  var passInput = [
    document.getElementById('senha1'),
    document.getElementById('senha2')
  ]
  passInput.forEach(input => {
    input.addEventListener('keydown', () => {
      input.value == ''
        ? (input.nextElementSibling.nextElementSibling.style.display = 'none')
        : (input.nextElementSibling.nextElementSibling.style.display =
            'initial')
    })
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
}

function btnCheck() {
  var inputs = document.querySelectorAll('.input')
  var bnt = document.getElementById('bntEntrar')
  var check = true

  inputs.forEach(input => {
    if (input.value == '') {
      check = false
    }
  })
  if (check) {
    bnt.classList = 'enable'
    bnt.disabled = false
  } else {
    bnt.classList = 'disable'
    bnt.disabled = true
  }
}

function crudFunction(event) {
  var formulario = event.target
  event.preventDefault()
  let formData = new FormData(formulario)
  const options = {
    method: 'POST',
    mode: 'cors',
    body: formData,
    cache: 'default'
  }

  fetch('../includes/logic/logica.php', options)
    .then(function (response) {
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        console.log(dados)
        switch (dados) {
          case 'error':
            document.getElementById('form').reset()
            popup(
              'Erro no sistema',
              'Ocorreu um erro na aplicação! Tente novamente mais tarde.'
            )
            break

          case 'valid':
            popup(
              'Senha alterada',
              'A senha da sua conta foi alterada com sucesso',
              '../log-cad/login.html'
            )
            break

          default:
            break
        }
      }
    })
    .catch(function (e) {
      console.log(e)
    })
}

function invalid(id, msg = null) {
  let input = document.getElementById(id)
  input.parentNode.classList.add('invalid')
  var temp = input.nextElementSibling.innerHTML
  input.addEventListener('keypress', () => {
    input.nextElementSibling.innerHTML = temp
    input.parentNode.classList.remove('invalid')
  })
  if (msg != null) {
    input.nextElementSibling.innerHTML = msg
  }
}

function popup(title, text, path = null) {
  popup = document.getElementById('popup')
  document.getElementById('returnTitle').innerHTML = title
  document.getElementById('returnText').innerHTML = text
  popup.classList.remove('disapear')
  popup.firstElementChild.classList.remove('hidden')
  document.getElementById('close').addEventListener('click', () => {
    popup.classList.add('disapear')
    popup.firstElementChild.classList.add('hidden')
    if (path) {
      window.location.href = path
    }
  })
}

function validForm(event) {
  event.preventDefault()
  let senha = [
    document.getElementById('senha1'),
    document.getElementById('senha2')
  ]
  var valid = true
  senha.forEach(input => {
    if (input.value == '') {
      invalid(input.id)
      valid = false
    }
    if (input.parentNode.classList.contains('invalid')) {
      input.parentNode.style.animation = 'none'
      input.parentNode.offsetHeight
      input.parentNode.style.animation = null
      valid = false
    }
  })

  if (senha[0].value.length < 6) {
    invalid('senha1', 'Senha deve conter no minimo 6 caracteres')
    valid = false
  }

  if (senha[0].value != senha[1].value) {
    invalid('senha2', 'Senhas não são iguais')
    valid = false
  }

  if (valid == true) {
    crudFunction(event)
  }
}
