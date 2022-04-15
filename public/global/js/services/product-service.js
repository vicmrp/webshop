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





  convertIntPriceToDecimalStringObject(intPrice) {
    const stringPrice = intPrice.toString()

    const decimalStringObject = {
      kroner: stringPrice.substr(0,stringPrice.length - 2),
      ore: stringPrice.substr(-2)
    }

    return decimalStringObject

  }












  presentProducts(divTarget, products) {

    // Div som produkterne skal puttes i.
    const productDivTarget = document.getElementById(divTarget)

    products.forEach(element => {
      
      // Skab en ny produktpille
      const productPill = document.createElement("div")
      productPill.setAttribute("id", element.id)

      // Tilføj billede til produktpille
      const img = document.createElement("img")
      img.src = `/img/${element.id}.png`
      productPill.appendChild(img)

      // Tilføj titel til produktpille.
      const name = document.createElement("h1")
      name.innerHTML = element.name
      productPill.appendChild(name)

      // Tilføj pris til produktpille.
      const priceElement = document.createElement("p")
      const PriceObj = this.convertIntPriceToDecimalStringObject(element.price)
      priceElement.innerHTML = `${PriceObj.kroner},${PriceObj.ore} kr.`
      productPill.appendChild(priceElement)


      const buyBtn = document.createElement("a")
      buyBtn.setAttribute("id", `buyBtn.${element.id}`)
      
      
      productDivTarget.appendChild(productPill)
    });

  }

}
