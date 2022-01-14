import ProductService from '../global/js/services/product-service.js'

console.log("Hello World");

const productService = new ProductService()

productService.hello()
productService.getAllProducts().then( object => {console.log(object);})