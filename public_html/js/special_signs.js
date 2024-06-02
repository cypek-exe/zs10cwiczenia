const special_signs    = document.getElementById('special-signs')
const answer_container = document.getElementById('answer-container')

let last_focused_input_answer_element = answer_container.children[0] // default value
let mouse_timer // hold-to-uppercase

function insertNewSpecialSign(input_element, sign) {
  const selection_start = input_element.selectionStart
  const selection_end   = input_element.selectionEnd

  const input_answer_array = [ ...input_element.value ]

  input_answer_array.splice(
    selection_start,
    selection_end - selection_start,
    sign
  )

  const new_input_answer = input_answer_array.join('')

  input_element.value = new_input_answer

  input_element.focus()
  input_element.setSelectionRange(selection_start + 1, selection_start + 1)
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

// hold-to-uppercase
function pointerDown() {
  mouse_timer = setTimeout(buttonContentToUpperCase, 500)
}
function pointerUp(target) {
  if (mouse_timer) clearTimeout(mouse_timer)

  if (target.value !== undefined) {
    if (target.classList.contains('special-sign')) {
      insertNewSpecialSign(last_focused_input_answer_element, target.value)
    }
  }

  buttonContentToLowerCase()
}



answer_container.addEventListener('focusin', e => {
  const target = e.target

  if (target.tagName === 'INPUT' && target.type === 'text') {
    last_focused_input_answer_element = e.target;
  }
})


// press shift to uppercase special buttons
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
special_signs.addEventListener("mouseup", () => last_focused_input_answer_element.focus())
