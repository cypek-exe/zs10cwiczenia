import getData              from "./fetch_data.js";
import Translation_exercise from "./translation-model.js";

(async () => {
  const data                 = await getData()
  const translations_data    = data.translations
  const translation_exercise = new Translation_exercise(translations_data)
})()
