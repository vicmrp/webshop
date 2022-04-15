import ProductService from '../global/js/services/product-service.js'


const productService = new ProductService()

productService.getAllProducts()
  .then( products => {productService.presentProducts("product-div", products.list_of_products)})

