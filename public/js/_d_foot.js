// Script som eksekvere for alle sider
// console.log('Hello World from _d_foot.js')

// Gør at hvis der ikke er nogen session med php så skal du logge ind
window.onload = async function () {

  // ------ Hvis ikke siden før at hele siden er loadet ----- //
  await (async () => {
    document.getElementById("header").style.display = "none"
    document.getElementById("main").style.display = "none"
    document.getElementById("footer").style.display = "none"
  })()
  // console.log(1)
  // Evaluer om brugeren er logget ind medmindre du er på login siden.
  await (async () => {
    if (location.href != 'http://' + location.hostname + '/login.php') {
      const userObj = await evaluate()
      // console.log(userObj)
      // global variable fra _b_header.js
      navigation.logout.innerHTML = `Log ud (${userObj.username})`
    }
  })()


  // Evaluer hvilken pille som er aktiv
  await (async () => {
    switch (location.pathname) {
      case '/createpc.php':
        document.getElementById('_header_createpc').style.fontWeight = 'bold'
        break;
      case '/searchpc.php':
        document.getElementById('_header_searchpc').style.fontWeight = 'bold'
        break;
      case '/attachuser.php':
        document.getElementById('_header_attach-user').style.fontWeight = 'bold'
        break;
      case '/searchuser.php':
        document.getElementById('_header_search-user').style.fontWeight = 'bold'
        break;
    }
  })()


  await (async () => {
    document.getElementById("header").style.display = ""
    document.getElementById("main").style.display = ""
    document.getElementById("footer").style.display = ""
  })()
  // ------ Hvis ikke siden før at hele siden er loadet ----- //


  // ------ Opret eventlistener på header ----- //

  // ------ Opret eventlistener på header ----- //

 


  // Evaluer om bruger er logget ind før du viser siden

  // function name(params) {
  //     let promise = new Promise(function(resolve, reject) {
  //         // the function is executed automatically when the promise is constructed

  //         // after 1 second signal that the job is done with the result "done"
  //         setTimeout(() => resolve("done"), 1000);
  //       });
  //       return promise
  // }
  // await name()




}