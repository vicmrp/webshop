// Log brugeren ud hvis han trykker på log ud knappen -> før personen til login menu

const navigation =  {
    home: document.getElementById("_header_logo_container"),
    createPC: document.getElementById("_header_createpc"),
    searchPC: document.getElementById("_header_searchpc"),
    attachUserToPC: document.getElementById("_header_attach-user"),
    searchUser: document.getElementById("_header_search-user"),
    logout: document.getElementById("_header_logout")
}

// EQUIP ONLINE
navigation.home.addEventListener("click", (e) => {
    console.log("Du har trykket på 'EQUIP ONLINE' knappen; Går til 'Opret PC'")
    let url1 = 'http://' + location.hostname + '/createpc.php'
    location.replace(url1)
})

// Opret PC
navigation.createPC.addEventListener("click", (e) => {
    console.log("Du har trykket på 'Opret PC' knappen; Går til 'Opret PC'")
    let url1 = 'http://' + location.hostname + '/createpc.php'
    location.replace(url1)
})

// Søg PC
navigation.searchPC.addEventListener("click", (e) => {
    console.log("Du har trykket på 'Søg PC' knappen; Går til 'Søg PC'")
    let url1 = 'http://' + location.hostname + '/searchpc.php'
    location.replace(url1)
})

// Tilknyt bruger
navigation.attachUserToPC.addEventListener("click", (e) => {
    console.log("Du har trykket på 'Tilknyt bruger' knappen; Går til 'Tilknyt bruger'")
    let url1 = 'http://' + location.hostname + '/attachuser.php'
    location.replace(url1)
})

// Søg bruger
navigation.searchUser.addEventListener("click", (e) => {
    console.log("Du har trykket på 'Søg bruger' knappen; Går til 'Søg bruger'")
    let url1 = 'http://' + location.hostname + '/searchuser.php'
    location.replace(url1)
})

// Log ud ()
navigation.logout.addEventListener("click", (e) => {
    console.log("Loggin out")
    let url1 = 'http://' + location.hostname + '/server_logout_login_module.php'
    location.replace(url1)
})


// Evaluar hvilke af nav pillerne som skal være oplyste.
// switch (window.location.href) {
//     case "http://equip.byg.dtu.dk/client_index.php":
//         console.log("Lys opret PC op")
//         break;

//     default:
//         break;
// }
// console.log(window.location.href)