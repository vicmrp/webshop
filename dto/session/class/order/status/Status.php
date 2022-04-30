<?php

namespace vezit\dto\class\session\order\status;

require __DIR__ . '/../../../../../global-requirements.php'; // __DIR__.g_from_top_folder().'/

use vezit\dto\class\session\order\status\payment\Payment;
use vezit\dto\class\session\order\status\email\Email;


class Status
{

    public function __construct(
        public Payment $payment = new Payment,
        public Email $email = new Email
    ) {
    }
}
