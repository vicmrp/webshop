import UserService from "../vezit-service-global/js/services/user-service.js"
import PostLoginRequest from "../vezit-service-global/js/dto/post-login-request/post-login-request.js"



const loginButton = document.getElementById("login-button");
const emailInput = document.getElementById("email-input");
const passwordInput = document.getElementById("password-input");

// check if user is logged in

const checkLogin = async () => {
    const email = String(emailInput.value)
    const password = String(passwordInput.value)

    // const email = 'admin@vezit.net'
    // const password = 'asdasd'

    const postLoginRequest = new PostLoginRequest(email, password)
    const response = await UserService.login(postLoginRequest)


    if (false === response.post_login_response.access_granted) {
        // user is not logged in
        console.log("user is not logged in")
        window.location.href = "/login/"
    } else {
        // user is logged in
        console.log("user is logged in")
        // show logout button in header
        document.querySelector('.header__logout_button').style.display = 'block';
        document.querySelector('#header-logout-btn').addEventListener('click', logout);
    }

}


const logout = async () => {
    await UserService.logout();
    // redirect to login page
    window.location.href = '/login.html';
}

loginButton.addEventListener("click", checkLogin);