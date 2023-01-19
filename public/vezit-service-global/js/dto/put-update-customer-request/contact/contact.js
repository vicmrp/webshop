export default class Contact {
    constructor(
        email  = null
        ) {
        this.email = email
        Object.seal(this)
    }
}