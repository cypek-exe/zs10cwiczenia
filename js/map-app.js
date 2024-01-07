import getData      from "./fetch_data.js";
import Map_exercise from "./map-model.js";

(async () => {
  const data         = await getData()
  const places_data  = data.places
  const map_exercise = new Map_exercise(places_data)
})()
