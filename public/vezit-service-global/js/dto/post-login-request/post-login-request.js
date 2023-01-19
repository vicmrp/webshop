export default class PostLoginRequest {

    constructor(
        email = null
        ,password = null
        ) {
            this.email = email
            this.password = password
            Object.seal(this)
        }
}