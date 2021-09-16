<?php

shell_exec(`curl -u ':023a7893ff8c4f0159fb9c43dce4178c90cce8833267cdd0b60ba8ea23b03003' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{"amount":1000}' https://api.quickpay.net/payments/99685196/link`);


?>



