export default class LoginResponse {
  constructor(
    email, 
    userCredentialsIsValid, 
    phpSessionIsActive
  )
  {
    this.email = email
    this.userCredentialsIsValid = userCredentialsIsValid
    this.phpSessionIsActive = phpSessionIsActive
  }
}
