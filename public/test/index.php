<?php

require_once __DIR__.'/Person.php';

$person = new Person('Zura', '28');

echo "Person name is: ". $person->getName();