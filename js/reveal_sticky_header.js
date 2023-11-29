const header_element = document.getElementById("main_header")

function getScrollPosition() {
  return scrollY || pageYOffset || document.documentElement.scrollTop;
}

let previous_scroll_position = getScrollPosition()

window.addEventListener('scroll', () => {
  if (previous_scroll_position > getScrollPosition())
    header_element.style.top = "0"
  else
    header_element.style.top = "-85px"

  previous_scroll_position = getScrollPosition()
})