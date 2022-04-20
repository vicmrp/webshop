<?php

namespace vezit\dto\class\session\order\order_status;

require __DIR__ . '/../../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\dto\class\session\order\order_status\payment\Payment;
use vezit\dto\class\session\order\order_status\email\Email;


class Order_Status
{

    public function __construct(
        public Payment $payment = new Payment,
        public Email $email = new Email
    ) {
    }
}
