import ProductService from '../global/js/services/product-service.js'


const productService = new ProductService()

productService.getAllProducts().then( products => {
  
  // console.log(products);
  productService.presentProducts("product-div", products.list_of_products)


})

// const productPresentation1 = document.querySelector("steen_karriere")
// const productPresentation2 = document.querySelector("steen_roman")

const div1 = document.getElementById("1")


