<?php
require_once "vendor/autoload.php";

use \Firebase\JWT\JWT;


$jwt = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjY5NmFhNzRjODFiZTYwYjI5NDg1NWE5YTVlZTliODY5OGUyYWJlYzEiLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoibWFzYSBsaWIiLCJwaWN0dXJlIjoiaHR0cHM6Ly9maXJlYmFzZXN0b3JhZ2UuZ29vZ2xlYXBpcy5jb20vdjAvYi9sZWFybi1maXJlYmFzZS1tYXNhbGliLmFwcHNwb3QuY29tL28vaW1hZ2VzJTJGdXNlcnMlMkZXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyJTJGcHJvZmlsZVBpY3R1cmUucG5nP2FsdD1tZWRpYSZ0b2tlbj0yNjZhMmRmNS0zMTZkLTQ4YjktYmIwMS00NmFjNGJjMTg2MGUvdjAvYi9sZWFybi1maXJlYmFzZS1tYXNhbGliLmFwcHNwb3QuY29tL28vaW1hZ2VzJTJGdXNlcnMlMkZXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyJTJGcHJvZmlsZVBpY3R1cmUucG5nP2FsdD1tZWRpYSIsImlzcyI6Imh0dHBzOi8vc2VjdXJldG9rZW4uZ29vZ2xlLmNvbS9sZWFybi1maXJlYmFzZS1tYXNhbGliIiwiYXVkIjoibGVhcm4tZmlyZWJhc2UtbWFzYWxpYiIsImF1dGhfdGltZSI6MTYwODMxNzQ3MCwidXNlcl9pZCI6IldLc29iVFlIbFpQOWpkM1N2TDRUQkY4aDU5UzIiLCJzdWIiOiJXS3NvYlRZSGxaUDlqZDNTdkw0VEJGOGg1OVMyIiwiaWF0IjoxNjA4MzE3NTY1LCJleHAiOjE2MDgzMjExNjUsImVtYWlsIjoibWFzYWxpYkBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJnb29nbGUuY29tIjpbIjEwMDI2MzAyNDg3OTk3NDI0MDU4MiJdLCJlbWFpbCI6WyJtYXNhbGliQGdtYWlsLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6Imdvb2dsZS5jb20ifX0.AQiKIVa2SijXAVN2zhUdbrnSARNlCgBofu298RKiueFViPpc_xkfG83RkaDQxChWETTeADTTGRimOUjnl2nNwCtHM4KE0CzL0cquXsaVHtArsyqmHl7pFyFs1wRAMn5Th2ZU6-nrizFOqe03CymnVuMPXJhzYQ4QmPpkd-69izPt9akru7beh9LUWGAvhcJLaFAjQC_bluL1t-HJlpv-Ow5QXbacwMSlAU7Uz78WgRJrU7RUvV6Ds5Vzt5vuSB3l1QRtddU4z-63b0PPyqWcMthIv0t8EJ0OkeZ_NZj9r0ANwNDSYHmUsz4Smt3md-T2F3ZS-s1jlavH7QTiVR_fGQ";


$keys_file = "securetoken.json"; // the file for the downloaded public keys
$cache_file = "pkeys.cache"; // this file contains the next time the system has to revalidate the keys
//////////  MUST REPLACE <YOUR FIREBASE PROJECTID> with your own!
$fbProjectId = "learn-firebase-masalib";

$verified_array = verify_firebase_token($jwt);

var_dump($verified_array);



/////// FROM THIS POINT, YOU CAN COPY/PASTE - NO CHANGES REQUIRED
///  (though read through for various comments!)
function verify_firebase_token($token = '')
{
    global $fbProjectId;
    $return = array();
    $userId = $deviceId = "";
    checkKeys();
    $pkeys_raw = getKeys();
    if (!empty($pkeys_raw)) {
        $pkeys = json_decode($pkeys_raw, true);
        try {
            $decoded = \Firebase\JWT\JWT::decode($token, $pkeys, ["RS256"]);
            if (!empty($_GET['debug'])) {
                echo "<hr>BOTTOM LINE - the decoded data<br>";
                print_r($decoded);
                echo "<hr>";
            }
            if (!empty($decoded)) {
                // do all the verifications Firebase says to do as per https://firebase.google.com/docs/auth/admin/verify-id-tokens
                // exp must be in the future
                $exp = $decoded->exp > time();
                // ist must be in the past
                $iat = $decoded->iat < time();
                // aud must be your Firebase project ID
                $aud = $decoded->aud == $fbProjectId;
                // iss must be "https://securetoken.google.com/<projectId>"
                $iss = $decoded->iss == "https://securetoken.google.com/$fbProjectId";
                // sub must be non-empty and is the UID of the user or device
                $sub = $decoded->sub;
                if ($exp && $iat && $aud && $iss && !empty($sub)) {
                    // we have a confirmed Firebase user!
                    // build an array with data we need for further processing
                    $return['UID'] = $sub;
                    $return['email'] = $decoded->email;
                    $return['email_verified'] = $decoded->email_verified;
                    $return['name'] = $decoded->name;
                    $return['picture'] = $decoded->photo;
                } else {
                    if (!empty($_GET['debug'])) {
                        echo "NOT ALL THE THINGS WERE TRUE!<br>";
                        echo "exp is $exp<br>ist is $iat<br>aud is $aud<br>iss is $iss<br>sub is $sub<br>";
                    }
                    /////// DO FURTHER PROCESSING IF YOU NEED TO
                    // (if $sub is false you may want to still return the data or even enter the verified user into the database at this point.)
                }
            }
        } catch (\UnexpectedValueException $unexpectedValueException) {
            $return['error'] = $unexpectedValueException->getMessage();
            if (!empty($_GET['debug'])) {
                echo "<hr>ERROR! " . $unexpectedValueException->getMessage() . "<hr>";
            }
        }
    }
    return $return;
}
/**
* Checks whether new keys should be downloaded, and retrieves them, if needed.
*/
function checkKeys()
{
    global $cache_file;
    if (file_exists($cache_file)) {
        $fp = fopen($cache_file, "r+");
        if (flock($fp, LOCK_SH)) {
            $contents = fread($fp, filesize($cache_file));
            if ($contents > time()) {
                flock($fp, LOCK_UN);
            } elseif (flock($fp, LOCK_EX)) { // upgrading the lock to exclusive (write)
                // here we need to revalidate since another process could've got to the LOCK_EX part before this
                if (fread($fp, filesize($cache_file)) <= time()) 
                {
                    refreshKeys($fp);
                }
                flock($fp, LOCK_UN);
            } else {
                throw new \RuntimeException('Cannot refresh keys: file lock upgrade error.');
            }
        } else {
            // you need to handle this by signaling error
        throw new \RuntimeException('Cannot refresh keys: file lock error.');
        }
        fclose($fp);
    } else {
        refreshKeys();
    }
}

/**
 * Downloads the public keys and writes them in a file. This also sets the new cache revalidation time.
 * @param null $fp the file pointer of the cache time file
 */
function refreshKeys($fp = null)
{
    global $keys_file;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $data = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = trim(substr($data, 0, $header_size));
    $raw_keys = trim(substr($data, $header_size));
    if (preg_match('/age:[ ]+?(\d+)/i', $headers, $age_matches) === 1) 
    {
        $age = $age_matches[1];
        if (preg_match('/cache-control:.+?max-age=(\d+)/i', $headers, $max_age_matches) === 1) {
            $valid_for = $max_age_matches[1] - $age;
            $fp = fopen($keys_file, "w");
            ftruncate($fp, 0);
            fwrite($fp, "" . (time() + $valid_for));
            fflush($fp);
            // $fp will be closed outside, we don't have to
            $fp_keys = fopen($keys_file, "w");
            if (flock($fp_keys, LOCK_EX)) {
                fwrite($fp_keys, $raw_keys);
                fflush($fp_keys);
                flock($fp_keys, LOCK_UN);
            }
            fclose($fp_keys);
        }
    }
}

/**
 * Retrieves the downloaded keys.
 * This should be called anytime you need the keys (i.e. for decoding / verification).
 * @return null|string
 */
function getKeys()
{
   global $keys_file;
    $fp = fopen($keys_file, "r");
    $keys = null;
    if (flock($fp, LOCK_SH)) {
        $keys = fread($fp, filesize($keys_file));
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return $keys;
}




?>