window.onload = async function () {

  session = await getOrSetSessionObj();

  


  function addOrderItem(product_id, quantity) {
    // ringer server op og tilføj
    

    // opdatere session objekt

    // 
  }


  // console.log(session.order.order_items);

  session.order.order_items.forEach(element => {
    console.log(element)
  });

}
