fetch('./login.html')
  .then(function (response) {
    if (response.ok) return response.text()
  })
  .then(function (dados) {
    document.getElementById('login').innerHTML = dados
  })

window.onload = function () {
  if (localStorage.getItem('dark')) {
    document.body.classList.toggle('lighttheme')
  }
  var campo = document.querySelectorAll('.input')
  campo.forEach(input => {
    input.addEventListener('keyup', function () {
      btnCheck()
    })
  })

  var olho = document.getElementById('olho')
  olho.addEventListener('mousedown', () => {
    password = olho.parentNode.firstElementChild
    password.type = 'text'
  })
  olho.addEventListener('mouseup', () => {
    password = olho.parentNode.firstElementChild
    password.type = 'password'
  })

  var passInput = document.getElementById('senha')
  passInput.addEventListener('keydown', () => {
    passInput.value == ''
      ? (olho.style.display = 'none')
      : (olho.style.display = 'initial')
  })

  document.getElementById('cpf').addEventListener('keypress', function () {
    limit_cpf(event.keyCode, this, event)
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

function limit_cpf(key, element, event) {
  if (key < 47 || key > 58) {
    event.preventDefault()
  }
  if (element.value.length > 10) {
    event.preventDefault()
  }
}

function crudFunction(event) {
  document.getElementById('load').classList.remove('disapear')
  var formulario = event.target
  event.preventDefault()
  let formData = new FormData(formulario)
  const options = {
    method: 'POST',
    mode: 'cors',
    body: formData,
    cache: 'default'
  }

  fetch('./includes/logic/logica.php', options)
    .then(function (response) {
      document.getElementById('load').classList.add('disapear')
      if (response.ok) return response.text()
    })
    .then(function (dados) {
      if (dados) {
        console.log(dados)
        switch (dados) {
          case 'nouser':
            invalid('email', 'Email inválido')
            break

          case 'nopass':
            invalid('senha', 'Senha inválida')
            break

          case 'havecpf':
            invalid('cpf', 'CPF já existe')
            break
          case 'haveemail':
            invalid('email', 'Email já existe')
            break
          case 'haveemailhavecpf':
            invalid('email', 'Email já existe')
            invalid('cpf', 'CPF já existe')
            break

          case 'emailsent':
            document.getElementById('form').reset()
            popup(
              'Cadastro pendente',
              'Uma confirmação foi enviada ao e-mail informado.'
            )
            break

          case 'error':
            document.getElementById('form').reset()
            popup(
              'Erro no sistema',
              'Ocorreu um erro na aplicação! Tente novamente mais tarde.'
            )
            break

          case 'recsent':
            document.getElementById('form').reset()
            popup(
              'Recuperação pendente',
              'Uma recuperação de senha foi enviada ao e-mail informado.'
            )
            break

          case 'valid':
            window.location.href = './home.php'
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
  let inputs = document.querySelectorAll('input')
  var valid = true
  for (let i = 0; i < inputs.length; i++) {
    if (inputs[i].parentNode.classList.contains('invalid')) {
      inputs[i].parentNode.style.animation = 'none'
      inputs[i].parentNode.offsetHeight
      inputs[i].parentNode.style.animation = null
      valid = false
    } else if (inputs[i].value == '') {
      invalid(inputs[i].id)
      valid = false
    } else if (inputs[i].id == 'email' && inputs[i].value.indexOf('@') === -1) {
      invalid('email', 'Email invalido')
      valid = false
    } else if (inputs[i].id == 'cpf') {
      if (inputs[i].value.length !== 11 || TestaCPF(inputs[i].value) == false) {
        invalid('cpf', 'CPF invalido')
        valid = false
      }
    } else if (inputs[i].id == 'senha' && inputs[i].value.length < 6) {
      invalid('senha', 'Senha deve conter no minimo 6 caracteres')
      valid = false
    }
  }
  if (valid == true) {
    crudFunction(event)
  }
}

function TestaCPF(strCPF) {
  var Soma
  var Resto
  Soma = 0
  if (strCPF == '00000000000') return false

  for (i = 1; i <= 9; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i)
  Resto = (Soma * 10) % 11

  if (Resto == 10 || Resto == 11) Resto = 0
  if (Resto != parseInt(strCPF.substring(9, 10))) return false

  Soma = 0
  for (i = 1; i <= 10; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i)
  Resto = (Soma * 10) % 11

  if (Resto == 10 || Resto == 11) Resto = 0
  if (Resto != parseInt(strCPF.substring(10, 11))) return false
  return true
}

function loadLogin() {
  document.getElementById('login').classList.remove('disapear')
  document.getElementById('login').classList.remove('login')
  document.getElementById('main').classList.add('hidden')
  document.getElementById('main').style.transform = 'translateY(35%)'
  // document.getElementById('login').style.backgroundColor = '#000000ee'
}

function darktheme() {
  let theme = localStorage.getItem('dark')
  document.body.classList.toggle('lighttheme')
  if (!theme) {
    localStorage.setItem('dark', 'true')
  } else {
    localStorage.removeItem('dark')
  }
}