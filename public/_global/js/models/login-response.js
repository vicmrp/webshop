export default class LoginResponse {
  constructor(username, groupmember, userCredentialsIsValid, phpSessionIsActive) {
    this.username = username
    this.groupmember = groupmember
    this.userCredentialsIsValid = userCredentialsIsValid
    this.phpSessionIsActive = phpSessionIsActive
  }
}

// json = 
// `{
//   "username": "vicre",
//   "groupmember": "byg-it-afd",
//   "user_credentials_is_valid": true,
//   "php_session_is_active": true
// }`

// $obj = JSON.parse(json)

// user = new LoginResponse($obj.username,$obj.groupmember,$obj.user_credentials_is_valid,$obj.php_session_is_active)

// console.log(user);