<?php

// Step 1 er at lave et payment url som henviser brugeren til betaling.
// Nar betalingen er gennemført kommer der en callback som fortæller om betalingen er gennemført.
// 
// sa rækkefølgen er saledes
// create-payment
// callback
// authorize-payment


require '../library.php';

$price = 80000;
$orderID = strtolower(generateRandomString(12));
$apiKey = file_get_contents('../../secret/quickpay_apikey');

// Der indsendes en liste med varernumre og antal, i følgende format. (varenummer, antal, varenummer, antal, varenummer, antal)
// Der akumeleres så hvor meget varende skal koste til sammen, og der bliver lavet en ordre seddel, med vareummere og antal.


// Create payment and put information into database generateRandomString(8)
// Det her id er som du laver, og skal bruge som reference til at hænge en ordre op pa den i db.


$createPaymentResponse = shell_exec("curl -u ':$apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$orderID\",\"currency\":\"dkk\"}' https://api.quickpay.net/payments 2> /dev/null");
$createPaymentResponseObj = json_decode($createPaymentResponse);
$createPaymentID = $createPaymentResponseObj->id;

// put ned i en fil
// file_put_contents("../../secret/flow_example/createPaymentResponse.json", $createPaymentResponse);

// Put 'id' og 'merchant_id' i database. Disse data vil vcallbackurl.php så bruge til at håndtere et køb!

// Lav payment link
$createPaymentLinkResponse = shell_exec("curl -u ':$apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{\"amount\":\"$price\"}' https://api.quickpay.net/payments/$createPaymentID/link 2> /dev/null");
$createPaymentLinkObj = json_decode($createPaymentLinkResponse);
echo $createPaymentLinkObj->url;


// put ned i en fil
// file_put_contents("../../secret/flow_example/createPaymentResponse.json", $createPaymentResponse);
// file_put_contents("../../secret/flow_example/createPaymentLinkResponse.json", $createPaymentLinkResponse);


?>