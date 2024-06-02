export default class EUtils {

  static getRandomInt(max) {
    return Math.round((Math.random() * max))
  }

  static isLocalStorageEnabled() {
    return typeof(Storage) !== "undefined" && navigator.cookieEnabled;
  }
}

EUtils.MyTimeout = class {

  #lastTimeoutID

  constructor(default_callback) {
    this.callback = default_callback
  }

  changeTimeout = (delay, ...args) => {
    clearTimeout(this.#lastTimeoutID)
    this.#lastTimeoutID = setTimeout(this.callback, delay, ...args)
  }

  clearLastTimeout = () => {
    clearTimeout(this.#lastTimeoutID)
  }
}

