const menu_icon = document.getElementById('menu-icon')
const menu_list = document.getElementById('menu-list')

function toggle_menu_list() {
  menu_list.classList.toggle('shown')
}

menu_icon.addEventListener('click', toggle_menu_list)
menu_icon.addEventListener('keyup', e => {
  if (e.key === 'Enter') toggle_menu_list()
})