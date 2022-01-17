import Interface from "../classes/interface.js";

export default class ProductService extends Interface {

  async getAllProducts() {
    const functioncall = 'get_all_products'
    const controller = 'product'
    const url = `https://steengede.com/controller/${controller}.php?functioncall=${functioncall}`
    const body = null
    const options = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
      body: body
    }    
    const serverResponse = await this.callServerByFetchReturnObject(url, options)
    return serverResponse
  }


















  presentProducts(divtarget, products) {

    const productDiv = document.getElementById(divtarget)

    products.forEach(element => {
      console.log(element);
      
      const productPill = document.createElement("div")
      productPill.setAttribute("id", element.id)

      const img = document.createElement("img")
      img.src = `/img/${element.id}.png`
      productPill.appendChild(img)

      const name = document.createElement("h1")
      name.innerHTML = element.name
      productPill.appendChild(name)


      const price = document.createElement("p")
      const stringPrice = element.price.toString()
      const kroner = stringPrice.substr(0,3)
      const ore = stringPrice.substr(-2)
      price.innerHTML = kroner.concat(",", ore, " ", "kr.")
      productPill.appendChild(price)

      const buyBtn = document.createElement("a")
      buyBtn.setAttribute("id", `buyBtn.${element.id}`)
            
      
      productDiv.appendChild(productPill)
    });

  }




}
