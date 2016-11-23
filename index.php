<?php

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

// // This is your id token
// $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2xvZ2luLmF1dGgwLmNvbS8iLCJzdWIiOiJnaXRodWJ8MTc4NTEyIiwiYXVkIjoiS2dTak1OM09Dd21yanZ0ako4YmZ1WnlBYW9LT3JnSDMiLCJleHAiOjEzODI3NDcxMTgsImlhdCI6MTM4MjcxMTExOCwiYmxvZyI6Imh0dHA6Ly90d2l0dGVyLmNvbS9qZnJvbWEiLCJjbGllbnRJRCI6IktnU2pNTjNPQ3dtcmp2dGpKOGJmdVp5QWFvS09yZ0gzIiwiY3JlYXRlZF9hdCI6IjIwMTMtMTAtMjRUMDE6MDk6NDIuMDQyWiIsImVtYWlsIjoiamZyb21hbmllbGxvQGdtYWlsLmNvbSIsImV2ZW50c191cmwiOiJodHRwczovL2FwaS5naXRodWIuY29tL3VzZXJzL2pmcm9tYW5pZWxsby9ldmVudHN7L3ByaXZhY3l9IiwiZm9sbG93ZXJzIjo0OCwiZm9sbG93ZXJzX3VybCI6Imh0dHBzOi8vYXBpLmdpdGh1Yi5jb20vdXNlcnMvamZyb21hbmllbGxvL2ZvbGxvd2VycyIsImZvbGxvd2luZyI6MjcsImZvbGxvd2luZ191cmwiOiJodHRwczovL2FwaS5naXRodWIuY29tL3VzZXJzL2pmcm9tYW5pZWxsby9mb2xsb3dpbmd7L290aGVyX3VzZXJ9IiwiZ2lzdHNfdXJsIjoiaHR0cHM6Ly9hcGkuZ2l0aHViLmNvbS91c2Vycy9qZnJvbWFuaWVsbG8vZ2lzdHN7L2dpc3RfaWR9IiwiZ3JhdmF0YXJfaWQiOiJkMWE3ZTBmYmZiMmMxZDlhOGIxMGZkMDM2NDhkYTc4ZiIsImhpcmVhYmxlIjpmYWxzZSwiaHRtbF91cmwiOiJodHRwczovL2dpdGh1Yi5jb20vamZyb21hbmllbGxvIiwiaWRlbnRpdGllcyI6W3siYWNjZXNzX3Rva2VuIjoiYjk2YmRkZDg5MjRhNmZiY2YwYWVkMTljMWFjY2FjNjUwOWI4OGRmMiIsInByb3ZpZGVyIjoiZ2l0aHViIiwidXNlcl9pZCI6MTc4NTEyLCJjb25uZWN0aW9uIjoiZ2l0aHViIiwiaXNTb2NpYWwiOnRydWV9XSwibG9jYXRpb24iOiJDw7NyZG9iYSwgQXJnZW50aW5hIiwibmFtZSI6Ikpvc8OpIEYuIFJvbWFuaWVsbG8iLCJuaWNrbmFtZSI6Impmcm9tYW5pZWxsbyIsIm9yZ2FuaXphdGlvbnNfdXJsIjoiaHR0cHM6Ly9hcGkuZ2l0aHViLmNvbS91c2Vycy9qZnJvbWFuaWVsbG8vb3JncyIsInBpY3R1cmUiOiJodHRwczovLzIuZ3JhdmF0YXIuY29tL2F2YXRhci9kMWE3ZTBmYmZiMmMxZDlhOGIxMGZkMDM2NDhkYTc4Zj9kPWh0dHBzJTNBJTJGJTJGaWRlbnRpY29ucy5naXRodWIuY29tJTJGMzc1MmRiYzViYzYyYzAxZmI2M2FhNzRjM2RhMjgwOTcucG5nJnI9eCIsInB1YmxpY19naXN0cyI6MjAyLCJwdWJsaWNfcmVwb3MiOjExOSwicmVjZWl2ZWRfZXZlbnRzX3VybCI6Imh0dHBzOi8vYXBpLmdpdGh1Yi5jb20vdXNlcnMvamZyb21hbmllbGxvL3JlY2VpdmVkX2V2ZW50cyIsInJlcG9zX3VybCI6Imh0dHBzOi8vYXBpLmdpdGh1Yi5jb20vdXNlcnMvamZyb21hbmllbGxvL3JlcG9zIiwic2l0ZV9hZG1pbiI6ZmFsc2UsInN0YXJyZWRfdXJsIjoiaHR0cHM6Ly9hcGkuZ2l0aHViLmNvbS91c2Vycy9qZnJvbWFuaWVsbG8vc3RhcnJlZHsvb3duZXJ9ey9yZXBvfSIsInN1YnNjcmlwdGlvbnNfdXJsIjoiaHR0cHM6Ly9hcGkuZ2l0aHViLmNvbS91c2Vycy9qZnJvbWFuaWVsbG8vc3Vic2NyaXB0aW9ucyIsInR5cGUiOiJVc2VyIiwidXBkYXRlZF9hdCI6IjIwMTMtMTAtMjRUMTQ6NTY6NDFaIiwidXJsIjoiaHR0cHM6Ly9hcGkuZ2l0aHViLmNvbS91c2Vycy9qZnJvbWFuaWVsbG8iLCJ1c2VyX2lkIjoiZ2l0aHVifDE3ODUxMiJ9.ZVdzRntRHoIK1VObdyoswFpRAuL5doCBa5rHZsZY_XQ';
//
// // This is your client secret
// $key = '5yy6vCe0ChxadKGsVcX47VMCNZLBwWVrBLQdWeFJZ0_S2fLFi2o9wifuzE-U3MRX';
//
// $decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')));
//
// print_r($decoded);

$key = "mykey";
$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

print_r(['key'=>$key]);

print_r(['token'=>$token]);

print_r(['base64'=>base64_encode($key)]);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key);
print_r(['jwt'=>$jwt]);


$decoded = JWT::decode($jwt, $key, array('HS256'));
print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;
// print_r($decoded_array);
/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));
print_r($decoded);
