<?php

##### MAC ######
// $str = "10E7C67E022A";
// $pattern = "/^([0-9A-Fa-f]{12})$/";

// $str2 = "10-E7-C6-7E-02-2A";
// $pattern2 = "/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/";

// $input = $str;

// if ( preg_match($pattern, $input) === 1 || preg_match($pattern2, $input) === 1 )
// {
//   echo $str;
// }
##### MAC ######


##### UUID #####
$uuid_str0 = 'asdasd';
$uuid_str1 = 'CA761232-ED42-11CE-BACD-00AA0057B223';
$uuid_str2 = 'CA761232+ED42+11CE+BACD+00AA0057B223';
$uuid_str3 = 'CA761232ED4211CEBACD00AA0057B223';

$ptrn1 = "/^\b[0-9a-fA-F]{8}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{12}\b$/";
$ptrn2 = "/^\b[0-9a-fA-F]{8}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{12}\b$/";
$ptrn3 = "/^\b[0-9a-fA-F]{32}\b$/";

$input = $uuid_str3;

if (  preg_match($ptrn1, $input) === 1
  ||  preg_match($ptrn2, $input) === 1
  ||  preg_match($ptrn3, $input) === 1)
  {
    echo 'There is a match!';
  }
##### UUID #####

// $str = "2020-04-01";
// $pattern = "/^(\d{4})-(\d{2})-(\d{2})$/";

// CA761232-ED42-11CE-BACD-00AA0057B223 \b[0-9a-fA-F]{8}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{4}\b-\b[0-9a-fA-F]{12}\b

// CA761232+ED42+11CE+BACD+00AA0057B223 \b[0-9a-fA-F]{8}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{4}\b\+\b[0-9a-fA-F]{12}\b

// CA761232ED4211CEBACD00AA0057B223 \b[0-9a-fA-F]{32}\b


