export default class Header {
  #homeBtn

  constructor(elements) { 
    this.#homeBtn   = elements.homeBtn
    this.#homeBtn.addEventListener("click", () => {
      location.href = `${location.protocol}//${location.hostname}`
    })
  }
}