<?php

namespace vezit\entities\class\order\status;

require __DIR__ . '/../../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\entities\class\order\status\payment\Payment;
use vezit\entities\class\order\status\email\Email;


class Status
{

    public function __construct(
        public Payment $payment = new Payment,
        public Email $email = new Email
    ) {
    }
}
