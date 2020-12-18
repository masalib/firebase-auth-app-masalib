<?php
require_once "vendor/autoload.php";

use \Firebase\JWT\JWT;


$keys = array(
  "type" => $_SERVER['FIREBASE_TYPE'],
  "project_id" => $_SERVER['FIREBASE_PROJECT_ID'],
  "private_key_id" => $_SERVER['FIREBASE_PRIVATE_KEY_ID'],
  "private_key" => $_SERVER['FIREBASE_PRIVATE_KEY'],
  "client_email" => $_SERVER['FIREBASE_CLIENT_EMAIL'],
  "client_id" => $_SERVER['FIREBASE_CLIENT_ID'],
  "auth_uri" => $_SERVER['FIREBASE_AUTH_URI'],
  "token_uri" => $_SERVER['FIREBASE_TOKEN_URI'],
  "auth_provider_x509_cert_url" => $_SERVER['FIREBASE_AUTH_PROVIDER_X509_CERT_URL'],
  "client_x509_cert_url" => $_SERVER['FIREBASE_CLIENT_X509_CERT_URL']
);

$jwt = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjY5NmFhNzRjODFiZTYwYjI5NDg1NWE5YTVlZTliODY5OGUyYWJlYzEiLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoibWFzYSBsaWIiLCJwaWN0dXJlIjoiaHR0cHM6Ly9maXJlYmFzZXN0b3JhZ2UuZ29vZ2xlYXBpcy5jb20vdjAvYi9sZWFybi1maXJlYmFzZS1tYXNhbGliLmFwcHNwb3QuY29tL28vaW1hZ2VzJTJGdXNlcnMlMkZXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyJTJGcHJvZmlsZVBpY3R1cmUucG5nP2FsdD1tZWRpYSZ0b2tlbj0yNjZhMmRmNS0zMTZkLTQ4YjktYmIwMS00NmFjNGJjMTg2MGUvdjAvYi9sZWFybi1maXJlYmFzZS1tYXNhbGliLmFwcHNwb3QuY29tL28vaW1hZ2VzJTJGdXNlcnMlMkZXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyJTJGcHJvZmlsZVBpY3R1cmUucG5nP2FsdD1tZWRpYSIsImlzcyI6Imh0dHBzOi8vc2VjdXJldG9rZW4uZ29vZ2xlLmNvbS9sZWFybi1maXJlYmFzZS1tYXNhbGliIiwiYXVkIjoibGVhcm4tZmlyZWJhc2UtbWFzYWxpYiIsImF1dGhfdGltZSI6MTYwODMxNzQ3MCwidXNlcl9pZCI6IldLc29iVFlIbFpQOWpkM1N2TDRUQkY4aDU5UzIiLCJzdWIiOiJXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyIiwiaWF0IjoxNjA4MzE3NTY1LCJleHAiOjE2MDgzMjExNjUsImVtYWlsIjoibWFzYWxpYkBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJnb29nbGUuY29tIjpbIjEwMDI2MzAyNDg3OTk3NDI0MDU4MiJdLCJlbWFpbCI6WyJtYXNhbGliQGdtYWlsLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6Imdvb2dsZS5jb20ifX0.AQiKIVa2SijXAVN2zhUdbrnSARNlCgBofu298RKiueFViPpc_xkfG83RkaDQxChWETTeADTTGRimOUjnl2nNwCtHM4KE0CzL0cquXsaVHtArsyqmHl7pFyFs1wRAMn5Th2ZU6-nrizFOqe03CymnVuMPXJhzYQ4QmPpkd-69izPt9akru7beh9LUWGAvhcJLaFAjQC_bluL1t-HJlpv-Ow5QXbacwMSlAU7Uz78WgRJrU7RUvV6Ds5Vzt5vuSB3l1QRtddU4z-63b0PPyqWcMthIv0t8EJ0OkeZ_NZj9r0ANwNDSYHmUsz4Smt3md-T2F3ZS-s1jlavH7QTiVR_fGQ";

$decoded = JWT::decode($jwt, $keys, ['RS256']);
var_dump($decoded);



?>