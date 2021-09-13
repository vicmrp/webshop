// Script som eksekvere for alle sider
// console.log('Hello World from _d_foot.js')

// Gør at hvis der ikke er nogen session med php så skal du logge ind
window.onload = async function () {
    await (async () => {
        document.getElementById("header").style.display = "none"
        document.getElementById("main").style.display = "none"
        document.getElementById("footer").style.display = "none"
      })()


      await (async () => {
        document.getElementById("header").style.display = ""
        document.getElementById("main").style.display = ""
        document.getElementById("footer").style.display = ""
      })()

}