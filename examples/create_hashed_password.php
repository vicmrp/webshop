<?php
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */
$timeTarget = 0.05; // 50 milliseconds

$cost = 8;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost . PHP_EOL;
?>


<?php
/**
 * In this case, we want to increase the default cost for BCRYPT to 12.
 * Note that we also switched to BCRYPT, which will always be 60 characters.
 */
$options = [
    'cost' => 10,
];

// See the password_hash() example to see where this came from.
$hash = password_hash("Passw0rd", PASSWORD_BCRYPT, $options);

// $hash = '$2y$10$Qlq7ejhtU37yj1rPQKQUr.ewscrn3DJ6z6DcFKVuee7WYDIXCf0uy';
// echo hashed password
echo $hash . PHP_EOL;

// if (password_verify('Passw0rd', $hash)) {
    // echo 'Password is valid!';
// } else {
    // echo 'Invalid password.';
// }
?>