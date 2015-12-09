<?php
 
//Upload a blank cookie.txt to the same directory as this file with a CHMOD/Permission to 777
$email = "name@domain.com";// email
$password = "password"; //password

function login($url,$data){
    $fp = fopen(__DIR__ . "/cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR,__DIR__. "/cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, __DIR__."/cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec ($login);
    ob_end_clean();
    curl_close ($login);
    unset($login);    
}                  
 
function grab_page($site){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__."/cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
}
 

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


 login("https://www.packtpub.com/","email=" . $email . "&password=" . $password . "&op=Login&form_id=packt_user_login_form"); 
 $input = grab_page("https://www.packtpub.com/packt/offers/free-learning");
 $magic_link = get_string_between($input, "<a href=\"/freelearning-claim/","\"");
 $output_link = "https://www.packtpub.com/freelearning-claim/" . $magic_link;
 grab_page($output_link);
 echo "DONE";

?>
