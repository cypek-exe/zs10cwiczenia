const pathname = window.location.pathname
const path_array = pathname.split('/')

const url = `/get-data.php?s=${path_array[1]}&e=${path_array[2]}`

export default async function getData() {
  try {
    const fetch_data = await fetch(url)
    const json_data  = await fetch_data.json()

    if (!fetch_data.ok) throw new Error(
      `status: ${fetch_data.status},
      statusText: ${fetch_data.statusText},
      ${!!json_data?.message ? `message: ${json_data?.message}` : 'No message response from server'}!`
    )

    return json_data;
  } catch (error) {
    console.error(`An error occurs! ${error}`)
  }
}

