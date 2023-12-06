const special_signs = document.getElementById('special-signs')

function insertNewSpecialSign(sign) {
  const selection_start = input_answer.selectionStart
  const selection_end   = input_answer.selectionEnd

  const input_answer_array = [ ...input_answer.value ]

  input_answer_array.splice(
    selection_start,
    selection_end - selection_start,
    sign
  )

  const new_input_answer = input_answer_array.join('')

  input_answer.value = new_input_answer

  input_answer.focus()
  input_answer.setSelectionRange(selection_start + 1, selection_start + 1)
}

function buttonContentToUpperCase() {
  [ ...special_signs.children ].forEach(el => {
    if (el.classList.contains('case-changeable'))
      el.value = el.value.toUpperCase()
  });
}
function buttonContentToLowerCase() {
  [ ...special_signs.children ].forEach(el => {
    if (el.classList.contains('case-changeable'))
      el.value = el.value.toLowerCase()
  });
}

let mouse_timer
function pointerDown() {
  mouse_timer = setTimeout(buttonContentToUpperCase, 500);
}
function pointerUp(target) {
  if (mouse_timer) clearTimeout(mouse_timer)

  if (target.value !== undefined) {
    if (target.classList.contains('special-sign'))
      insertNewSpecialSign(target.value)
  }

  buttonContentToLowerCase()
}


window.addEventListener('keydown', e =>
  e.key === 'Shift' && buttonContentToUpperCase()
)
window.addEventListener('keyup', e =>
  e.key === 'Shift' && buttonContentToLowerCase()
)


special_signs.addEventListener("pointerdown", e => {
  if (e.target.classList.contains('special-sign')) pointerDown()
});
document.body.addEventListener("pointerup", e => pointerUp(e.target))
special_signs.addEventListener("mouseup", () => input_answer.focus())
