import EUtils from "./exercise-utils.js";

export default class Map_exercise extends EUtils.MyTimeout {

  #result_delay = 2000 // time in milliseconds after which the result will be cleared

  #places_data
  #places_keys

  #correct_answers   = 0
  #incorrect_answers = 0
  #streak            = 0

  #number_of_attempts = 0 // number of failed attempts
  #index              = 0

  #answered_before = []
  #answered_before_to_primary = []

  constructor(places_data) {
    super()

    this.#places_data = places_data
    this.#places_keys = Object.keys(this.#places_data)

    this.#assignDOMElements()

    this.#settingsManager()
    this.#handleButtonEvent()
    this.#handleMapEvent()

    this.renderQuestion()

    Array.from(document.getElementsByClassName('fetching-data'))
      .forEach(e => e.classList.remove('fetching-data'))
    // in CSS, elements with class fetching-data have `cursor: wait;` property 
  }

  #assignNextIndex = () => {
    if (this.is_random_order)
      this.#index = EUtils.getRandomInt(this.#places_data.length - 1)
    else
      this.#index = (this.#index + 1) % this.#places_keys.length

    // if everything was answered, delete the contents of the array
    if (this.#answered_before.length >= this.#places_data.length)
      this.#answered_before.splice(0, this.#answered_before.length)

    while (this.#answered_before.includes(this.#index))
      this.#index = (this.#index + 1) % this.#places_data.length
  }

  #getPlaceKey = (index) => {
    return this.#places_keys[index]
  }

  #getPlaceName = (key) => {
    return this.#places_data[key]
  }

  renderQuestion = () => {
    const key = this.#getPlaceKey(this.#index)
    this.question.innerHTML = 
      `Wyrażenie: <strong>${this.#getPlaceName(key)}</strong>`
  }


  check = (answer) => {
    // `answer` IS key, NOT index
    // `answer` must be type of string,
    // because `this.#getPlaceKey()` returns string value
    console.log(this.#getPlaceName(answer))
    if (answer === this.#getPlaceKey(this.#index)) {
      this.#correct()
      this.changeTimeout(this.clearResult, this.#result_delay)
      this.#assignNextIndex()
      this.renderQuestion()
    } else
      this.#incorrect(answer)
  }

  skip = () => {
    this.#streak = 0
    this.renderStats()
    this.#assignNextIndex()
    this.renderQuestion()
  }


  #correct = () => {
    this.#correct_answers++
    this.#streak++
    this.renderStats()

    if (this.#number_of_attempts === 0)
      this.#answered_before.push(this.#index)

    this.#number_of_attempts = 0
    this.result.innerHTML = 'Dobrze ✅'
  }

  #incorrect = (answer) => {
    this.#incorrect_answers++
    this.#streak = 0
    this.renderStats()

    this.#number_of_attempts++
    this.result.innerHTML = `Źle ❌ <br> To: <strong>${this.#getPlaceName(answer)}</strong>`
    this.clearLastTimeout()
  }


  #settingsManager = () => {
    // random order
    if (typeof(Storage) !== "undefined" && navigator.cookieEnabled) {

      const ls_is_random_order = localStorage.getItem('is_random_order')

      this.is_random_order = ls_is_random_order === 'true'

      if (this.is_random_order) this.#assignNextIndex()

      this.random_order_input.checked = this.is_random_order

      this.random_order_input.addEventListener('change', () => {
        this.is_random_order = this.random_order_input.checked
        localStorage.setItem('is_random_order', this.is_random_order)
        this.#assignNextIndex()
        this.renderQuestion()
      })

    } else {

      this.random_order_input.addEventListener('change', () => {
        this.is_random_order = this.random_order_input.checked
        this.#assignNextIndex()
        this.renderQuestion()
      })

    }
  }

  #handleButtonEvent = () => {
    this.skip_button.addEventListener('click', this.skip)
  }

  #handleMapEvent = () => {
    this.map_element.addEventListener('click', el => {
      console.log(el.target)
      const target_key_parts = el.target.id.split('_')
      if (target_key_parts[0] === 'map-place-index') {
        const answer = target_key_parts[1] // `answer` must be type of string 
        this.check(answer)
      }
    })
  }
  
  #assignDOMElements = () => {
    this.question = document.getElementById('question')
    this.result   = document.getElementById('result')

    this.map_element = document.getElementById('map-el')

    this.random_order_input = document.getElementById('random_order')
    this.skip_button        = document.getElementById('skip_button')

    this.correct_answers_element   = document.getElementById('correct')
    this.incorrect_answers_element = document.getElementById('incorrect')
    this.streak_element            = document.getElementById('streak')
  }

  clearResult = () => {
    this.result.innerHTML = ''
  }

  renderStats = () => {
    this.correct_answers_element  .textContent = this.correct_answers
    this.incorrect_answers_element.textContent = this.incorrect_answers
    this.streak_element           .textContent = this.streak
  }


  get correct_answers() {
    return this.#correct_answers
  }
  get incorrect_answers() {
    return this.#incorrect_answers
  }
  get streak() {
    return this.#streak
  }
  
}
  