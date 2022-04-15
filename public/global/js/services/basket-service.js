import InterfaceService from './interface-service.js'

export default class BasketService extends InterfaceService {
  
  addItem(productName, productId, price, quantitity) {

    const basketStorage = window.localStorage
    const newItem = {
      productName: productName,
      productId: productId,
      price: price,
      quantitity: quantitity
    }

    let orderItems = new Array();
    if (basketStorage.getItem("orderItems") !== null)
      orderItems = JSON.parse(basketStorage.getItem("orderItems"))
    
    orderItems.push(newItem);

    basketStorage.setItem("orderItems", JSON.stringify(orderItems))
    
    
    // orderItems.push(newItem);
    // console.log(orderItems);
    // // console.log(JSON.stringify(orderItems));
    // let json = JSON.stringify(orderItems)
    // orderItems = JSON.parse(json)
    // console.log(orderItems);

    // console.log(orderItems);

  // // get storage if exist
  //   if (basketStorage.getItem("orderItems") !== null)
  //   {
  //     orderItems = JSON.parse(basketStorage.getItem("orderItems"))
  //     orderItems 


  //   }
  //   else {

  //   }








  
      


    // else {

    //   orderItems = basketStorage.getItem("orderItems")
    // }
    


    // localStorage.setItem()




    


  }


  // #orderItems = ({
  //   productName:
  //   productId:
  //   price:
  //   quantitity
  // }, {})

}