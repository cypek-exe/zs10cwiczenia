const section      = document.getElementById('exercise')
const question     = document.getElementById('question')
const input_answer = document.getElementById('answer')
const result       = document.getElementById('result')
const mode_input_to_foreign = document.getElementById('mode_to_foreign')
const mode_input_to_primary = document.getElementById('mode_to_primary')
const random_order_input    = document.getElementById('random_order')

const check_button = document.getElementById('check_button')
const hint_button  = document.getElementById('hint_button')
const skip_button  = document.getElementById('skip_button')

const answered_before = []
let index = 0
let is_mode_to_foreign = true
let is_random_order    = true
let number_of_attempts = 0 // number of failed attempts
let translations_data

function start(data) { // starts when data fetch ended successfully
  translations_data = data
  renderNewPhrase()
}


// LocalStorage

// - mode
if (typeof(Storage) !== "undefined" && navigator.cookieEnabled) {
  const ls_is_mode_to_foreign = localStorage.getItem('is_mode_to_foreign');
  if (ls_is_mode_to_foreign === 'true') {
    is_mode_to_foreign = true
    mode_input_to_foreign.checked = true;
  } else {
    is_mode_to_foreign = false
    mode_input_to_primary.checked = true;
  }

  mode_input_to_foreign.addEventListener('change', () => {
    is_mode_to_foreign = true
    localStorage.setItem('is_mode_to_foreign', is_mode_to_foreign)
  })
  mode_input_to_primary.addEventListener('change', () => {
    is_mode_to_foreign = false
    localStorage.setItem('is_mode_to_foreign', is_mode_to_foreign)
  })
} else {
  mode_input_to_foreign.addEventListener('change', () => {
    is_mode_to_foreign = true
  })
  mode_input_to_primary.addEventListener('change', () => {
    is_mode_to_foreign = false
  })
}

// - random order
if (typeof(Storage) !== "undefined" && navigator.cookieEnabled) {
  const ls_is_random_order = localStorage.getItem('is_random_order')

  if (ls_is_random_order === 'true')
    is_random_order = true
  else
    is_random_order = false

  random_order_input.checked = is_random_order

  random_order_input.addEventListener('change', () => {
    is_random_order = random_order_input.checked
    localStorage.setItem('is_random_order', is_random_order)
  })
} else {
  random_order_input.addEventListener('change', () => {
    is_random_order = random_order_input.checked
  })
}


function getRandomInt(max) { return Math.round((Math.random() * max)) }

function getPhrase(is_mode_to_foreign, index) {
  return is_mode_to_foreign ? translations_data[index][0] : translations_data[index][1]
}

function renderNewPhrase() {
  if (is_random_order)
    index = getRandomInt(translations_data.length - 1)
  else
    index = (index + 1) % translations_data.length

  if (answered_before.length >= translations_data.length) 
    answered_before.splice(0, answered_before.length) // if everything was answered, delete the contents of the array

  while (answered_before.includes(index)) {
    index = (index + 1) % translations_data.length
  }

  question.innerHTML = `Definicja: "<strong>${getPhrase(is_mode_to_foreign, index)}</strong>"`
  input_answer.placeholder  = 'Wpisz odpowiedź tutaj'
}

function clear_result() {
  result.innerHTML = ''
}

function hint() {

}

function correct() {
  number_of_attempts = 0
  result.innerHTML =  'Dobrze ✅'
  input_answer.value = ''
  renderNewPhrase()
  setTimeout(clear_result, 2000)
}

function incorrect() {
  if (number_of_attempts === 0)
    result.innerHTML = 'Źle ❌ <br> Spróbuj jeszcze raz'
  else
    hint()

  setTimeout(clear_result, 2000)
  number_of_attempts++
}

function check() {
  if (input_answer.value === getPhrase(!is_mode_to_foreign, index)) {
    if (number_of_attempts === 0) answered_before.push(
      {
        index: index,
        is_mode_to_foreign: !is_mode_to_foreign
      }
    )

    correct()
  } else {
    incorrect()
  }
}

check_button.addEventListener('click', () => check())