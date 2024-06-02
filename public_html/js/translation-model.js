import EUtils from "./exercise-utils.js";

export default class Translation_exercise {

  #result_delay = 2000 // time in milliseconds after which the result will be cleared

  #translations_data

  #correct_answers   = 0
  #incorrect_answers = 0
  #streak            = 0

  #number_of_attempts = 0 // number of failed attempts
  #index              = 0

  #answered_before_to_foreign = []
  #answered_before_to_primary = []

  constructor(translations_data) {
    this.#translations_data = translations_data

    this.#assignDOMElements()
    this.clearResultTimeout = new EUtils.MyTimeout(this.clearResult);
    this.#settingsManager()

    this.#handleButtonsEvents()

    this.renderQuestion()

    Array.from(document.getElementsByClassName('fetching-data'))
      .forEach(e => e.classList.remove('fetching-data'))
    // in CSS, elements with class fetching-data have `cursor: wait;` property 
  }

  #assignNextIndex() {
    if (this.is_random_order)
      this.#index = EUtils.getRandomInt(this.#translations_data.length - 1)
    else
      this.#index = (this.#index + 1) % this.#translations_data.length


    // if everything was answered, delete the contents of the array
    if (this.#answered_before_to_foreign.length >= this.#translations_data.length)
      this.#answered_before_to_foreign.splice(0, this.#answered_before_to_foreign.length)

    if (this.#answered_before_to_primary.length >= this.#translations_data.length)
      this.#answered_before_to_primary.splice(0, this.#answered_before_to_primary.length)


    if (this.is_mode_to_foreign)
      while (this.#answered_before_to_foreign.includes(this.#index))
        this.#index = (this.#index + 1) % this.#translations_data.length
    else
      while (this.#answered_before_to_foreign.includes(this.#index))
        this.#index = (this.#index + 1) % this.#translations_data.length
  }

  #getPhrase(is_mode_to_foreign, index) {
    const keys = ['phrase', 'translation'];
    return this.#translations_data[index][keys[+is_mode_to_foreign]]
  }

  renderQuestion() {
    this.question.innerHTML = 
      `Wyrażenie: <strong>${this.#getPhrase(this.is_mode_to_foreign, this.#index)}</strong>`
  }


  check() {
    if (this.input_answer.value === this.#getPhrase(!this.is_mode_to_foreign, this.#index)) {
      this.#correct()
      this.clearResultTimeout.changeTimeout(this.#result_delay)
      this.clearInput()
      this.#assignNextIndex()
      this.renderQuestion()
    } else
      this.#incorrect()
  }

  hint() {
    this.#streak = 0
    this.renderStats()
    this.#number_of_attempts++

    this.result.innerHTML = 
      `Podpowiedź: <strong>${
        this.#getPhrase(this.is_mode_to_foreign, this.#index)
      }</strong> to <strong>${
        this.#getPhrase(!this.is_mode_to_foreign, this.#index)
      }</strong>`;
  }
  
  skip() {
    this.#streak = 0
    this.renderStats()
    this.clearInput()
    this.#assignNextIndex()
    this.renderQuestion()
  }


  #correct() {
    this.#correct_answers++
    this.#streak++
    this.renderStats()

    if (this.#number_of_attempts === 0) {
      if (this.is_mode_to_foreign)
        this.#answered_before_to_foreign.push(this.#index)
      else
        this.#answered_before_to_primary.push(this.#index)
    }

    this.#number_of_attempts = 0
    this.result.innerHTML = 'Dobrze ✅'
  }

  #incorrect() {
    this.#incorrect_answers++
    this.#streak = 0
    this.renderStats()

    if (this.#number_of_attempts > 0) {
      this.hint()
      // `hint()` functions method `this.#number_of_attempts++` instruction
      this.clearResultTimeout.clearLastTimeout()
    } else {
      this.#number_of_attempts++
      this.result.innerHTML = 'Źle ❌ <br> Spróbuj jeszcze raz'
      this.clearResultTimeout.changeTimeout(this.#result_delay)
    }
  }


  #settingsManager() {
    // mode to foreign / to primary
    if (EUtils.isLocalStorageEnabled()) {

      const ls_is_mode_to_foreign = localStorage.getItem('is_mode_to_foreign');

      if (ls_is_mode_to_foreign === 'true') {
        this.is_mode_to_foreign = true
        this.mode_input_to_foreign.checked = true;
      } else {
        this.is_mode_to_foreign = false
        this.mode_input_to_primary.checked = true;
      }
    
      this.mode_input_to_foreign.addEventListener('change', () => {
        this.is_mode_to_foreign = true
        localStorage.setItem('is_mode_to_foreign', this.is_mode_to_foreign)
        this.#assignNextIndex()
        this.renderQuestion()
      })

      this.mode_input_to_primary.addEventListener('change', () => {
        this.is_mode_to_foreign = false
        localStorage.setItem('is_mode_to_foreign', this.is_mode_to_foreign)
        this.#assignNextIndex()
        this.renderQuestion()
      })

    } else {

      this.mode_input_to_foreign.addEventListener('change', () => {
        this.is_mode_to_foreign = true
        this.#assignNextIndex()
        this.renderQuestion()
      })

      this.mode_input_to_primary.addEventListener('change', () => {
        this.is_mode_to_foreign = false
        this.#assignNextIndex()
        this.renderQuestion()
      })

    }
    
    // random order
    if (EUtils.isLocalStorageEnabled()) {

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

  #handleButtonsEvents() {
    this.check_button.addEventListener('click', () => this.check())
    this.hint_button .addEventListener('click', () => this.hint())
    this.skip_button .addEventListener('click', () => this.skip())
  }
  
  #assignDOMElements() {
    this.question = document.getElementById('question')
    this.result   = document.getElementById('result')

    this.input_answer          = document.getElementById('answer')
    this.mode_input_to_foreign = document.getElementById('mode_to_foreign')
    this.mode_input_to_primary = document.getElementById('mode_to_primary')
    this.random_order_input    = document.getElementById('random_order')

    this.check_button = document.getElementById('check_button')
    this.hint_button  = document.getElementById('hint_button')
    this.skip_button  = document.getElementById('skip_button')

    this.correct_answers_element   = document.getElementById('correct')
    this.incorrect_answers_element = document.getElementById('incorrect')
    this.streak_element            = document.getElementById('streak')
  }

  clearInput() {
    this.input_answer.value = '' 
  }

  clearResult() {
    this.result.innerHTML = ''
  }

  renderStats() {
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
