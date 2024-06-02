import getData              from "./fetch_data.js";
import Translation_exercise from "./translation_irregular-model.js";

(async () => {
  const data                 = await getData()
  const translations_data    = data.irregular_translations
  const translation_exercise = new Translation_exercise(translations_data)
})()
