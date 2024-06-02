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

  #getPhrase(column_index, index) {
    const keys = ['first_column', 'second_column', 'third_column', 'translation'];
    return this.#translations_data[index][keys[column_index]]
  }

  renderQuestion() {
    this.question.innerHTML = 
      `Czasownik: <strong>${this.#getPhrase(3, this.#index)}</strong>`
  }

  #highlight_correct_answer(element) {
    element.classList.remove("incorrect")
    element.classList.add("correct")
  }

  #highlight_incorrect_answer(element) {
    element.classList.remove("correct")
    element.classList.add("incorrect")
  }

  check() {
    let is_FC_answer_correct = this.FC_input_answer.value === this.#getPhrase(0, this.#index)
    if (is_FC_answer_correct) {
      this.#highlight_correct_answer(this.FC_input_answer)
    } else {
      this.#highlight_incorrect_answer(this.FC_input_answer)
    }

    let is_SC_answer_correct = this.SC_input_answer.value === this.#getPhrase(1, this.#index)
    if (is_SC_answer_correct) {
      this.#highlight_correct_answer(this.SC_input_answer)
    } else {
      this.#highlight_incorrect_answer(this.SC_input_answer)
    }

    let is_TC_answer_correct = this.TC_input_answer.value === this.#getPhrase(2, this.#index)
    if (is_TC_answer_correct) {
      this.#highlight_correct_answer(this.TC_input_answer)
    } else {
      this.#highlight_incorrect_answer(this.TC_input_answer)
    }
    
    if (
      is_FC_answer_correct &&
      is_SC_answer_correct &&
      is_TC_answer_correct
    ) {
      this.#correct()
      this.clearResultTimeout.changeTimeout(this.#result_delay)
      this.clearInput()
      this.#assignNextIndex()
      this.renderQuestion()
    } else {
      this.#incorrect()
    }
  }

  hint() {
    this.#streak = 0
    this.renderStats()
    this.#number_of_attempts++

    this.clearResultTimeout.clearLastTimeout()
    this.result.innerHTML = 
      `Podpowiedź: <strong>${
        this.#getPhrase(3, this.#index)
      }</strong> to <strong>${
        this.#getPhrase(0, this.#index)
      }</strong>, 
      <strong>${
        this.#getPhrase(1, this.#index)
      }</strong>, 
      <strong>${
        this.#getPhrase(2, this.#index)
      }</strong>`;
  }
  
  skip() {
    this.#streak = 0
    this.renderStats()
    this.clearInput()
    this.#assignNextIndex()
    this.renderQuestion()
    this.#number_of_attempts = 0
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
    } else {
      this.#number_of_attempts++
      this.result.innerHTML = 'Źle ❌ <br> Spróbuj jeszcze raz'
      this.clearResultTimeout.changeTimeout(this.#result_delay)
    }
  }


  #settingsManager() {
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
    // using "() =>" to prevent using element context as "this"
    this.check_button.addEventListener('click', () => this.check())
    this.hint_button .addEventListener('click', () => this.hint())
    this.skip_button .addEventListener('click', () => this.skip())
  }
  
  #assignDOMElements() {
    this.question = document.getElementById('question')
    this.result   = document.getElementById('result')

    // First, second and third column answer elements
    this.FC_input_answer = document.getElementById('first_column_answer')
    this.SC_input_answer = document.getElementById('second_column_answer')
    this.TC_input_answer = document.getElementById('third_column_answer')

    this.random_order_input    = document.getElementById('random_order')

    this.check_button = document.getElementById('check_button')
    this.hint_button  = document.getElementById('hint_button')
    this.skip_button  = document.getElementById('skip_button')

    this.correct_answers_element   = document.getElementById('correct')
    this.incorrect_answers_element = document.getElementById('incorrect')
    this.streak_element            = document.getElementById('streak')
  }

  clearInput() {
    this.FC_input_answer.value = ''
    this.SC_input_answer.value = ''
    this.TC_input_answer.value = ''

    this.FC_input_answer.classList.remove("correct", "incorrect")
    this.SC_input_answer.classList.remove("correct", "incorrect")
    this.TC_input_answer.classList.remove("correct", "incorrect")
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
