import UserService from "../vezit-service-global/js/services/user-service.js"
import PostLoginRequest from "../vezit-service-global/js/dto/post-login-request/post-login-request.js"

// check if user is logged in

const checkLogin = async () => {
    const email = null
    const password = null
    const postLoginRequest = new PostLoginRequest(email, password)
    const response = await UserService.login(postLoginRequest)


    if (false === response.post_login_response.access_granted) {
        // user is not logged in
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

checkLogin()