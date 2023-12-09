const header_element = document.getElementById("main_header")

function getScrollPosition() {
  return scrollY || pageYOffset || document.documentElement.scrollTop;
}

let previous_scroll_position = getScrollPosition()

window.addEventListener('scroll', () => {
  if (previous_scroll_position > getScrollPosition())
    header_element.classList.remove('hidden')
  else
    header_element.classList.add('hidden')

  previous_scroll_position = getScrollPosition()
})