<?php namespace vezit\dto\internal_dtos\session\order\status;
use vezit\dto\internal_dtos\session\order\status\payment\Payment;
use vezit\dto\internal_dtos\session\order\status\email\Email;
require __DIR__ . '/../../../../../global-requirements.php';

class Status
{

    public function __construct(
        public Payment $payment = new Payment,
        public Email $email = new Email
    ) {
    }
}
