<?php namespace vezit\models\session\order\status;
use vezit\models\session\order\status\payment\Payment;
use vezit\models\session\order\status\email\Email;
require __DIR__ . '/../../../../global-requirements.php';

class Status
{

    public function __construct(
        public Payment $payment = new Payment,
        public Email $email = new Email
    ) {
    }
}
