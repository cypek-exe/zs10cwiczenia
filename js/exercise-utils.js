export default class EUtils {

  static getRandomInt(max) {
    return Math.round((Math.random() * max))
  }

}

EUtils.MyTimeout = class {

  #lastTimeoutID

  changeTimeout = (callback, delay, ...args) => {
    clearTimeout(this.#lastTimeoutID)
    this.#lastTimeoutID = setTimeout(callback, delay, ...args)
  }

  clearLastTimeout = () => {
    clearTimeout(this.#lastTimeoutID)
  }

}

