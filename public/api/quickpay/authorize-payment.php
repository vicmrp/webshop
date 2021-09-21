<?php

shell_exec(`curl -u ':apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{"amount":1000}' https://api.quickpay.net/payments/99685196/link`);


?>



