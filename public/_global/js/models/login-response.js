export default class LoginResponse {
  constructor(
    username, 
    userCredentialsIsValid, 
    groupmember,
    userSessionVariableIsset
  )
  {
    this.username = username
    this.groupmember = groupmember
    this.userCredentialsIsValid = userCredentialsIsValid
    this.userSessionVariableIsset = userSessionVariableIsset
  }
}
