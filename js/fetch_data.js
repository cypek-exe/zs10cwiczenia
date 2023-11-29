const pathname = window.location.pathname
const path_array = pathname.split('/')

const url = `/get-data.php?s=${path_array[1]}&e=${path_array[2]}`

fetch(url)
  .then(resp_JSON => resp_JSON.json()
    .then(res => {
      if (!resp_JSON.ok)
        throw new Error(`Network response was not ok! Code: ${resp_JSON.status}${('message' in res) && ', message: ' + res.message}.`)
      return res.translations;
    })
    .then(data => start(data))
    .catch(error => console.error(error))
  )