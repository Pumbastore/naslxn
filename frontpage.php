<?php
session_start(); // Must be first

// Database connection
$host = 'localhost';
$db_name = 'sp_chat'; // Your database
$username = 'root';
$password = '';
$db = new mysqli($host, $username, $password, $db_name);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize message
$message = '';
$redirect = false; // Flag to control redirect
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EMAIL'])) {
    if (!empty($_POST['_mc4wp_honeypot'])) {
        $message = "Bot detected!";
        $redirect = true;
    } else {
        $email = filter_var($_POST['EMAIL'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $message = "Invalid email address!";
            $redirect = true;
        } else {
            $stmt_check = $db->prepare("SELECT email FROM emails_subs WHERE email = ?");
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result = $stmt_check->get_result();
            if ($result->num_rows > 0) {
                $message = "Email already subscribed!";
                $redirect = true;
            } else {
                $subscribed_at = date('Y-m-d H:i:s');
                $stmt_insert = $db->prepare("INSERT INTO emails_subs (email, subscribed_at) VALUES (?, ?)");
                $stmt_insert->bind_param("ss", $email, $subscribed_at);
                if ($stmt_insert->execute()) {
                    $message = "Subscription successful!";
                    $redirect = true;
                } else {
                    $message = "Error subscribing. Try again!";
                    $redirect = true;
                }
                $stmt_insert->close();
            }
            $stmt_check->close();
        }
    }

    // Perform redirect only if form submission occurred
    if ($redirect) {
        header("Location: frontpage.php?status=" . ($message === "Subscription successful!" ? "success" : "error") . "&msg=" . urlencode($message) . "#subscribe-form");
        exit();
    }
}

$db->close();

// Get message from query string if present
$status = $_GET['status'] ?? '';
$msg = urldecode($_GET['msg'] ?? '');
?>
<html dir="ltr" lang="en-US" prefix="og: https://ogp.me/ns#"><head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Estonia&display=swap" rel="stylesheet">
<meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ=="><meta http-equiv="origin-trial" content="A7vZI3v+Gz7JfuRolKNM4Aff6zaGuT7X0mf3wtoZTnKv6497cVMnhy03KDqX7kBz/q/iidW7srW31oQbBt4VhgoAAACUeyJvcmlnaW4iOiJodHRwczovL3d3dy5nb29nbGUuY29tOjQ0MyIsImZlYXR1cmUiOiJEaXNhYmxlVGhpcmRQYXJ0eVN0b3JhZ2VQYXJ0aXRpb25pbmczIiwiZXhwaXJ5IjoxNzU3OTgwODAwLCJpc1N1YmRvbWFpbiI6dHJ1ZSwiaXNUaGlyZFBhcnR5Ijp0cnVlfQ==">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Google Tag Manager -->
    <script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5641v9167169657za200&amp;tag_exp=101509157~102015666~103116026~103200004~103233427~103351869~103351871~104617976~104617978~104653070~104653072~104661466~104661468~104698127~104698129"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5641v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351869~103351871~104617976~104617978~104653070~104653072~104661466~104661468~104698127~104698129"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5650h2v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351869~103351871~104651273~104651275~104653070~104653072~104661466~104661468~104698127~104698129"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5641v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351869~103351871~104653070~104653072~104661466~104661468~104698127~104698129"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5641v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351869~103351871~104617976~104617978~104653070~104653072~104661466~104661468~104684208~104684211~104698127~104698129"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5621v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351869~103351871~104611962~104611964"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__fr.js" crossorigin="anonymous" integrity="sha384-xdZ7ICH5PFf9v+mnnEAJ/upCLoG+uGbDw8iweC0V4vY2hhQZpq6c22P8by7Km7A8"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script type="text/javascript" async="" charset="utf-8" src="https://www.gstatic.com/recaptcha/releases/GUGrl5YkSwqiWrzO3ShIKDlu/recaptcha__en.js" crossorigin="anonymous" integrity="sha384-Pgzxh1AwnkDgbWKtYDFLE/r3ApPn/Q8WuDIGgofHUvDRypiXM2Mes4UTV5JTaDp+"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-9415D695Z5&amp;cx=c&amp;gtm=45He5621v9167169657za200&amp;tag_exp=101509157~103116026~103200004~103233427~103351866~103351868~104611962~104611964"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-MGQZPFLV"></script><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MGQZPFLV');</script>
    <!-- End Google Tag Manager -->

    <title>HBZ-Photography</title>
	<style>img:is([sizes="auto" i], [sizes^="auto," i]) { contain-intrinsic-size: 3000px 1500px }</style>
	
		<!-- All in One SEO 4.8.3.1 - aioseo.com -->
	
		<!-- All in One SEO -->


		<script>

/*! This file is auto-generated */
!function(i,n){var o,s,e;function c(e){try{var t={supportTests:e,timestamp:(new Date).valueOf()};sessionStorage.setItem(o,JSON.stringify(t))}catch(e){}}function p(e,t,n){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);var t=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data),r=(e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(n,0,0),new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data));return t.every(function(e,t){return e===r[t]})}function u(e,t,n){switch(t){case"flag":return n(e,"\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f","\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f")?!1:!n(e,"\ud83c\uddfa\ud83c\uddf3","\ud83c\uddfa\u200b\ud83c\uddf3")&&!n(e,"\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f","\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");case"emoji":return!n(e,"\ud83d\udc26\u200d\ud83d\udd25","\ud83d\udc26\u200b\ud83d\udd25")}return!1}function f(e,t,n){var r="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?new OffscreenCanvas(300,150):i.createElement("canvas"),a=r.getContext("2d",{willReadFrequently:!0}),o=(a.textBaseline="top",a.font="600 32px Arial",{});return e.forEach(function(e){o[e]=t(a,e,n)}),o}function t(e){var t=i.createElement("script");t.src=e,t.defer=!0,i.head.appendChild(t)}"undefined"!=typeof Promise&&(o="wpEmojiSettingsSupports",s=["flag","emoji"],n.supports={everything:!0,everythingExceptFlag:!0},e=new Promise(function(e){i.addEventListener("DOMContentLoaded",e,{once:!0})}),new Promise(function(t){var n=function(){try{var e=JSON.parse(sessionStorage.getItem(o));if("object"==typeof e&&"number"==typeof e.timestamp&&(new Date).valueOf()<e.timestamp+604800&&"object"==typeof e.supportTests)return e.supportTests}catch(e){}return null}();if(!n){if("undefined"!=typeof Worker&&"undefined"!=typeof OffscreenCanvas&&"undefined"!=typeof URL&&URL.createObjectURL&&"undefined"!=typeof Blob)try{var e="postMessage("+f.toString()+"("+[JSON.stringify(s),u.toString(),p.toString()].join(",")+"));",r=new Blob([e],{type:"text/javascript"}),a=new Worker(URL.createObjectURL(r),{name:"wpTestEmojiSupports"});return void(a.onmessage=function(e){c(n=e.data),a.terminate(),t(n)})}catch(e){}c(n=f(s,u,p))}t(n)}).then(function(e){for(var t in e)n.supports[t]=e[t],n.supports.everything=n.supports.everything&&n.supports[t],"flag"!==t&&(n.supports.everythingExceptFlag=n.supports.everythingExceptFlag&&n.supports[t]);n.supports.everythingExceptFlag=n.supports.everythingExceptFlag&&!n.supports.flag,n.DOMReady=!1,n.readyCallback=function(){n.DOMReady=!0}}).then(function(){return e}).then(function(){var e;n.supports.everything||(n.readyCallback(),(e=n.source||{}).concatemoji?t(e.concatemoji):e.wpemoji&&e.twemoji&&(t(e.twemoji),t(e.wpemoji)))}))}((window,document),window._wpemojiSettings);
</script>
<link rel="stylesheet" id="sbi_styles-css" href="https://www.purpletree.ca/wp-content/plugins/instagram-feed/css/sbi-styles.min.css?ver=6.9.1" media="all">
<style id="wp-emoji-styles-inline-css">

	img.wp-smiley, img.emoji {
		display: inline !important;
		border: none !important;
		box-shadow: none !important;
		height: 1em !important;
		width: 1em !important;
		margin: 0 0.07em !important;
		vertical-align: -0.1em !important;
		background: none !important;
		padding: 0 !important;
	}
</style>
<link rel="stylesheet" id="wp-block-library-css" href="https://www.purpletree.ca/wp-includes/css/dist/block-library/style.min.css?ver=6.8.1" media="all">
<style id="wp-block-library-theme-inline-css">
.wp-block-audio :where(figcaption){color:#555;font-size:13px;text-align:center}.is-dark-theme .wp-block-audio :where(figcaption){color:#ffffffa6}.wp-block-audio{margin:0 0 1em}.wp-block-code{border:1px solid #ccc;border-radius:4px;font-family:Menlo,Consolas,monaco,monospace;padding:.8em 1em}.wp-block-embed :where(figcaption){color:#555;font-size:13px;text-align:center}.is-dark-theme .wp-block-embed :where(figcaption){color:#ffffffa6}.wp-block-embed{margin:0 0 1em}.blocks-gallery-caption{color:#555;font-size:13px;text-align:center}.is-dark-theme .blocks-gallery-caption{color:#ffffffa6}:root :where(.wp-block-image figcaption){color:#555;font-size:13px;text-align:center}.is-dark-theme :root :where(.wp-block-image figcaption){color:#ffffffa6}.wp-block-image{margin:0 0 1em}.wp-block-pullquote{border-bottom:4px solid;border-top:4px solid;color:currentColor;margin-bottom:1.75em}.wp-block-pullquote cite,.wp-block-pullquote footer,.wp-block-pullquote__citation{color:currentColor;font-size:.8125em;font-style:normal;text-transform:uppercase}.wp-block-quote{border-left:.25em solid;margin:0 0 1.75em;padding-left:1em}.wp-block-quote cite,.wp-block-quote footer{color:currentColor;font-size:.8125em;font-style:normal;position:relative}.wp-block-quote:where(.has-text-align-right){border-left:none;border-right:.25em solid;padding-left:0;padding-right:1em}.wp-block-quote:where(.has-text-align-center){border:none;padding-left:0}.wp-block-quote.is-large,.wp-block-quote.is-style-large,.wp-block-quote:where(.is-style-plain){border:none}.wp-block-search .wp-block-search__label{font-weight:700}.wp-block-search__button{border:1px solid #ccc;padding:.375em .625em}:where(.wp-block-group.has-background){padding:1.25em 2.375em}.wp-block-separator.has-css-opacity{opacity:.4}.wp-block-separator{border:none;border-bottom:2px solid;margin-left:auto;margin-right:auto}.wp-block-separator.has-alpha-channel-opacity{opacity:1}.wp-block-separator:not(.is-style-wide):not(.is-style-dots){width:100px}.wp-block-separator.has-background:not(.is-style-dots){border-bottom:none;height:1px}.wp-block-separator.has-background:not(.is-style-wide):not(.is-style-dots){height:2px}.wp-block-table{margin:0 0 1em}.wp-block-table td,.wp-block-table th{word-break:normal}.wp-block-table :where(figcaption){color:#555;font-size:13px;text-align:center}.is-dark-theme .wp-block-table :where(figcaption){color:#ffffffa6}.wp-block-video :where(figcaption){color:#555;font-size:13px;text-align:center}.is-dark-theme .wp-block-video :where(figcaption){color:#ffffffa6}.wp-block-video{margin:0 0 1em}:root :where(.wp-block-template-part.has-background){margin-bottom:-1050px;margin-top:0;padding:1.25em 2.375em}
</style>
<style id="classic-theme-styles-inline-css">
/*! This file is auto-generated */
.wp-block-button__link{color:#fff;background-color:#32373c;border-radius:9999px;box-shadow:none;text-decoration:none;padding:calc(.667em + 2px) calc(1.333em + 2px);font-size:1.125em}.wp-block-file__button{background:#32373c;color:#fff;text-decoration:none}
</style>
<style id="safe-svg-svg-icon-style-inline-css">
.safe-svg-cover{text-align:center}.safe-svg-cover .safe-svg-inside{display:inline-block;max-width:100%}.safe-svg-cover svg{height:100%;max-height:100%;max-width:100%;width:100%}

</style>
<style id="global-styles-inline-css">
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
</style>
<link rel="stylesheet" id="contact-form-7-css" href="https://www.purpletree.ca/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=6.0.6" media="all">
<link rel="stylesheet" id="walcf7-datepicker-css-css" href="https://www.purpletree.ca/wp-content/plugins/date-time-picker-for-contact-form-7/assets/css/jquery.datetimepicker.min.css?ver=1.0.0" media="all">
<link rel="stylesheet" id="main-css" href="rasta.css" media="all">
<link rel="stylesheet" id="fancybox-css" href="https://www.purpletree.ca/wp-content/themes/marck/assets/css/fancybox.css?ver=6.8.1" media="all">
<link rel="stylesheet" id="lp-page-css" href="https://www.purpletree.ca/wp-content/themes/marck/assets/css/lp-page.css?ver=1.1.4" media="all">
<link rel="stylesheet" id="slick-css" href="https://www.purpletree.ca/wp-content/themes/marck/assets/css/slick.css?ver=6.8.1" media="all">
<link rel="stylesheet" id="main-css" href="rasta1.3.6.css" media="all">
<script src="https://www.purpletree.ca/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
<script src="https://www.purpletree.ca/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
<link rel="https://api.w.org/" href="https://www.purpletree.ca/wp-json/"><link rel="alternate" title="JSON" type="application/json" href="https://www.purpletree.ca/wp-json/wp/v2/pages/3793"><link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.purpletree.ca/xmlrpc.php?rsd">
<meta name="generator" content="WordPress 6.8.1">
<link rel="shortlink" href="https://www.purpletree.ca/">
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="https://www.purpletree.ca/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.purpletree.ca%2F">
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="https://www.purpletree.ca/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.purpletree.ca%2F&amp;format=xml">
<meta name="generator" content="Site Kit by Google 1.154.0"><link rel="icon" href="https://i.imgur.com/nvFGu8G.png" sizes="32x32">
<link rel="icon" href="https://i.imgur.com/nvFGu8G.png" sizes="192x192">
<link rel="apple-touch-icon" href="https://i.imgur.com/nvFGu8G.png">
<meta name="msapplication-TileImage" content="https://i.imgur.com/nvFGu8G.png">

    <meta name="msapplication-TileColor" content="#222">
    <meta name="theme-color" content="#222">

    <style id="admin-custom-css">
                .header .btn_nav::before,
        .header .btn_nav::after {
          background-color: #c4bebe;
        }

        .header .btn_nav::before {
          -webkit-box-shadow: 0 6px 0 0 #c4bebe;
          box-shadow: 0 6px 0 0 #c4bebe;
        }
        
    
    .page_content .section_1 .logo {
        width: auto !important;
    }
    </style>
<script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script><script src="https://www.purpletree.ca/wp-includes/js/wp-emoji-release.min.js?ver=6.8.1" defer=""></script></head>
<body class="home wp-singular page-template-default page page-id-3793 wp-theme-marck marck-blocks">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MGQZPFLV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->
 <header class="header">
        <div class="container">
            <button class="btn_nav" onclick="funNav()"></button>
            <nav class="nav">
                <div class="wrap">
                    <div class="col col--photo">
                    </div>

                    <div class="col col--content mobile-navigation">
                        <button class="btn_close" onclick="funNav()"></button>

                        <div class="menu-main-container"><ul id="menu-main" class="menu"><li id="menu-item-3800" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-3793 current_page_item menu-item-3800"><a href="../hbz-photography.ca/frontpage.php" aria-current="page">Home</a></li>
<li id="menu-item-37270" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-37270"><a href="../hbz-photography.ca/The-Gallery.php">The gallery</a><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div>

</li>
<li id="menu-item-37270" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-37270"><a href="../hbz-photography.ca/contact-us.php#weddingpackages">Our Forfaits</a><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">

</div></li><li id="menu-item-7773" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7773"><a href="../hbz-photography.ca/contact-us.php">Contact</a></li>
<div class="wrap">
                            <a href="contact-us.php" class="btn">Schedule a consult</a>
                        </div>
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </ul></div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div><div class="more">
      <svg width="10px" height="10px" class="icon">
        <use xlink:href="/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
      </svg>
    </div>


</div>
                        <div class="wrap">
                            
    

                            <a href="contact-us.php" class="btn">Schedule a consult</a>
                        </div>
                    </div>
            </nav>
        </div>
    </header>


    <main class="page_content">
<section class="top-section section_1 ">
        <div class="logo">
        <img decoding="async" width="348" height="313" src="https://i.imgur.com/nZt0s6S.png" class="site-logo" alt="" id="40930">    </div>
    
    <div class="top-section__background">
    <img decoding="async" width="2048" height="1365" src="https://lh3.googleusercontent.com/qXErmZHKC8VCdr0rdSX33VssilC4eMah_mFP20CjRD8ApsVD3vdcsCEtLaqAO9a3Li0UJZE0wKsNZjwYNjURjKlVyVs9wdB5rAFiJoU=w1200-h800-rw-e30" class="image desktop-image" alt="" sizes="(max-width: 600px) 1200px, 100vw" style="object-position: center center;" id="76477" srcset="https://lh3.googleusercontent.com/qXErmZHKC8VCdr0rdSX33VssilC4eMah_mFP20CjRD8ApsVD3vdcsCEtLaqAO9a3Li0UJZE0wKsNZjwYNjURjKlVyVs9wdB5rAFiJoU=w1200-h800-rw-e30"><img decoding="async" width="1004" height="1365" src="https://lh3.googleusercontent.com/KMJqoMaspoDHQaMp-EV5NDgNff3vs_RKN5ltB-payKYNG4kDazGIjiUdVgCw0c5-dkIjm9Fj4lErnhKy6zioSDuLRSkZGFG96aK25Q=w1200-h800-rw-e30" class="image mobile-image" alt="" sizes="100vw" style="object-position: center bottom;" id="43277" srcset="https://lh3.googleusercontent.com/KMJqoMaspoDHQaMp-EV5NDgNff3vs_RKN5ltB-payKYNG4kDazGIjiUdVgCw0c5-dkIjm9Fj4lErnhKy6zioSDuLRSkZGFG96aK25Q=w1200-h800-rw-e30">    </div>

    <div class="top-section__overlay" style="background-color: rgba(0,0,0,0.6);"></div>

    <div class="top-section__content">
        <div class="container">
            <div class="content">
            <div class="beforetitle ftype_0">
    Quebec Wedding Photography</div>
<h1 class="title ftype_1"><p><em>IMMORTALIZING</em> life’s<br>Special Chapters,<br>One Image<br>
at <strong>A TIME</strong>.</p>
</h1><a class="btn btn_white" href="contact-us.php" target="">
    Ready to tell yours?</a>            </div>
        </div>
    </div>

    



    </section>
<header class="headerscroll">
    <div class="container">
        <a href="../hbz-photography.ca/contact-us.php" class="btn">
            Pricing <span>&nbsp;&amp; Availability</span>
        </a>

        <a class="link link--phone" target="_blank" rel="noopener noreferrer nofollow">
            +1 514-654-4599        </a>

        <ul id="menu-scroll-navigation" class="menu"><li id="menu-item-40936" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-40936"><a href="../hbz-photography.ca/frontpage.php" aria-current="page">HOME</a></li>
<li id="menu-item-40937" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-40937"><a href="../hbz-photography.ca/The-Gallery.php">THE GALLERY</a></li>
<li id="menu-item-40937" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-40937"><a href="../hbz-photography.ca/contact-us.php#weddingpackages">Our Forfaits</a></li>

</ul>
        <button onclick="funNav()" class="btn_popupnav"></button>
    </div>
</header>


<section class="section_2 bg-grey">
    <div class="container">
        <div class="beforetitle ftype_0">
    wedding photography team </div>
<h2 class="title ftype_2"><p>Seizing the<em> instants</em><br>
that <em>truly</em>&nbsp;<strong>RESONATE</strong>.</p>
</h2>
        <div class="wrap">
            <div class="col col--1">
                <img decoding="async" width="" height="5913" src="https://lh3.googleusercontent.com/AOnxeJyJUanRxcTzGtmQ-dvSvExddOA7tufcT5HmEMXODyCeq5lPMbxic9ttfoD-2O4fqrm1IyTNuZmhAxK1NRKdICC1_U-w73Kl1w=w1200-h800-rw-e30" class="img" alt="" sizes="300px" id="74393" srcset="https://lh3.googleusercontent.com/AOnxeJyJUanRxcTzGtmQ-dvSvExddOA7tufcT5HmEMXODyCeq5lPMbxic9ttfoD-2O4fqrm1IyTNuZmhAxK1NRKdICC1_U-w73Kl1w=w1200-h800-rw-e30">            </div>

            <div class="col col--2">
                <div class="text ftype_4">
    <p>Our method of capturing life’s most treasured moments is genuine and purposeful. We believe the finest images unfold like a love story—organically. Join us on this adventure, and we’ll lead you every step along the path.</p>
</div>
<img decoding="async" width="2048" height="1365" src="https://lh3.googleusercontent.com/8CxPxwmAlLLQ4CuzFk2wQ6apJ-uxySWHrAj8esLolUUNjKIpvuaeQOzzhXZBA68NzBtTgZhNJ4acU30Ur0_nNuxm9rbwDtRSvcsviw=w1200-h800-rw-e30" class="img" alt="" sizes="800px" id="51453" srcset="https://lh3.googleusercontent.com/8CxPxwmAlLLQ4CuzFk2wQ6apJ-uxySWHrAj8esLolUUNjKIpvuaeQOzzhXZBA68NzBtTgZhNJ4acU30Ur0_nNuxm9rbwDtRSvcsviw=w1200-h800-rw-e30">
                <div class="wrap">
                    <div class="subcol">
                        <div class="tit ftype_3">
    Featured Work</div>
<div class="subtit ftype_4">
    <p>Some of our favourite love stories</p>
</div>
                    </div>

                    <div class="subcol">
                        <a class="btn" href="../hbz-photography.ca/The-Gallery.php" target="">
    View portfolio</a>                    </div>
                </div>
            </div>

            <div class="col col--3">
                <img decoding="async" width="1365" height="2048" src="https://lh3.googleusercontent.com/qtQcDkFoUCB6i0EejbcjOfIRM6UOZ52S9fYvcKgHATumBkKMKdUB2KFnBU6grU9qUbAdA_0tVpOKlgUf6UbRsvixvFVnnA1tR_4xtA=w294-h441-rw-e30" class="img" alt="" sizes="300px" id="74394" srcset="https://lh3.googleusercontent.com/qtQcDkFoUCB6i0EejbcjOfIRM6UOZ52S9fYvcKgHATumBkKMKdUB2KFnBU6grU9qUbAdA_0tVpOKlgUf6UbRsvixvFVnnA1tR_4xtA=w294-h441-rw-e30">            </div>
        </div>
    </div>
</section>





<section class="section_3 bg-white">
    <div class="container">
        <h2 class="title ftype_2">ABOUT US</h2><div class="text ftype_4 flipp">
    <p>Hello there! Let us share why we embrace the most enchanting and rewarding vocation imaginable at HBZ-Photography. We are captivated by love. We are enchanted by graceful brides, gentle illumination, natural surroundings, and the lively spirits of the bride and groom. We are the creators who seize the rhythm of your wedding day and craft it into timeless visual markers. Our enthusiasm has evolved into a fulfilling pursuit. We enjoy sharing laughter and maintain a relaxed demeanor – we are approachable and a pleasure to engage with. Hearing your narratives and aspirations for your wedding day holds great value to us, and no detail is ever considered too minor!</p>
<p>A vital part of being a photographer is drawing visual inspiration from EVERYTHING (yes, truly everything!) at HBZ-Photography. Our visual style has been honed over the years, focusing on tenderness and refinement. We take deep pride in upholding a consistent aesthetic. We cherish all things natural – your radiant joy, the ache from dancing – all those authentic moments are yours, and it’s our role to serve as visual guardians of your wedding day.</p>
<p>We treasure and value the faith our clients entrust to us. Authentic feelings, smiles, heartfelt moments… We firmly believe the best images blossom as effortlessly as romance. That’s why we see photos as “timeless mementos.” We hold dear the preservation of family history and traditions – heirlooms to share with future generations across Quebec.</p>
<p>The enchantment starts the moment you step into our space and grows even stronger when we lift the camera on your wedding day across Quebec. We’ll guide you through every moment – the deep bonds we form with clients and the stunning images born from those ties fuel our joy each morning. The best part? We genuinely find beauty in every detail.</p>
<p>We are imaginative, enthusiastic, and inquisitive. We approach photography with the excitement of a child in a wonderland – we stand out (and remain modest!). Our commitment to high standards and pursuit of perfection have shaped our journey to this point. Delighted to connect with you at last!</p>
<p>Don’t let chilly weather halt your union with the one you adore! The cold doesn’t deter us, and we’d be thrilled to capture your special day amidst the natural charm of winter across Quebec.</p>
</div>

        
    </div>
</section>



<section class="section_4 section-bg">
    <div class="section-bg__background">
        <img decoding="async" width="2048" height="1366" src="https://lh3.googleusercontent.com/JXuT2CSw-xfnEKpjFsJcqSbOBYxCeo3UTkFCcYy-E0sa2n1iZFwrFk3TPH2QGMr2yiUWyAi79F22o1zzSlUYPS2eVDuS7oPGl1ru=w1200-h800-rw-e30" class="" alt="" sizes="(max-width: 600px) 1200px, 100vw" style="object-position: center;" id="76410" srcset="https://lh3.googleusercontent.com/JXuT2CSw-xfnEKpjFsJcqSbOBYxCeo3UTkFCcYy-E0sa2n1iZFwrFk3TPH2QGMr2yiUWyAi79F22o1zzSlUYPS2eVDuS7oPGl1ru=w1200-h800-rw-e30">    </div>

    <div class="section-bg__overlay" style="background-color: rgba(12,12,12,0.59);"></div>

    <div class="section-bg__content">
        <div class="container">
            <div class="wrap">
                <div class="col col--photo">
                                    </div>

                <div class="col col--text">
                    <div class="beforetitle ftype_0">
    MEET THE TEAM</div>
<h1 class="title ftype_2"><div><div>Our Story</div></div></h1><div class="text ftype_4">
    <p>For the last decade, Hassan Ben Zid has had the privilege of documenting unique love stories across Quebec, a pursuit that has proven to be the most meaningful work he could have ever imagined.</p>
</div>
<a class="link btn_link" href="/our-team/" target="">
    <span>
        Read more    </span>

    <svg width="8px" height="8px" class="icon">
        <use xlink:href="https://www.purpletree.ca/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
    </svg>
</a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section_5">
    <div class="container">
        <div class="brforetitle ftype_0">
    Signature work</div>
<h2 class="title ftype_2">Portfolio</h2>    </div>

    <div class="container scroll">
        <div class="wrap sliderPortfolio" style="height: 836px;">
            <button class="btn_left">
<img src="https://i.imgur.com/sVWx6de.png" width="30px" height="24px" class="icon">

            </button>

            <button class="btn_right">
<img src="https://i.imgur.com/qC1lNVz.png" width="30px" height="24px" class="icon">
            </button>

                                        <div class="col">
                                                            <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/pio0Kyx.jpeg" class="img slider_start" alt="" id="55494" srcset="https://i.imgur.com/pio0Kyx.jpeg 1365w, https://i.imgur.com/2ClmwQM.jpeg 200w, https://i.imgur.com/oCBKzr2.jpeg 683w, https://i.imgur.com/jGehri2.jpeg 768w, https://i.imgur.com/n17Bj2u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"></div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/oMJgqwN.jpeg" class="img slider_start" alt="" id="51458" srcset="https://i.imgur.com/oMJgqwN.jpeg 1365w, https://i.imgur.com/eg8n121.jpeg 200w, https://i.imgur.com/u1UIEjt.jpeg 683w, https://i.imgur.com/rllmlaS.jpeg 768w, https://i.imgur.com/sELLqsI.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/BGrs5Ow.jpeg" class="img slider_start" alt="" id="76532" srcset="https://i.imgur.com/BGrs5Ow.jpeg 1365w, https://i.imgur.com/pOIEgwu.jpeg 200w, https://i.imgur.com/PtJbr4p.jpeg 683w, https://i.imgur.com/RUpMLUZ.jpeg 768w, https://i.imgur.com/A48eHJl.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AcIzEkO.jpeg" class="img slider_start" alt="" id="74421" srcset="https://i.imgur.com/AcIzEkO.jpeg 1365w, https://i.imgur.com/UU45hXH.jpeg 200w, https://i.imgur.com/MYx3OmP.jpeg 683w, https://i.imgur.com/vW4X1j8.jpeg 768w, https://i.imgur.com/Z5kAnQd.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/zvbOL5V.jpeg" class="img slider_start" alt="" id="76732" srcset="https://i.imgur.com/zvbOL5V.jpeg 1365w, https://i.imgur.com/k2id9cy.jpeg 200w, https://i.imgur.com/IvILrya.jpeg 683w, https://i.imgur.com/kNnHne0.jpeg 768w, https://i.imgur.com/HhM2hHK.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AyD0Ot3.jpeg" class="img slider_start" alt="" id="76546" srcset="https://i.imgur.com/AyD0Ot3.jpeg 1365w, https://i.imgur.com/C0chsCS.jpeg 200w, https://i.imgur.com/TTINLQA.jpeg 683w, https://i.imgur.com/9ENG0QP.jpeg 768w, https://i.imgur.com/lx0k1BQ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rQQfXHo.jpeg" class="img slider_start" alt="" id="76823" srcset="https://i.imgur.com/rQQfXHo.jpeg 1365w, https://i.imgur.com/GqcVH0l.jpeg 200w, https://i.imgur.com/c2R4BHZ.jpeg 683w, https://i.imgur.com/1o4z1O6.jpeg 768w, https://i.imgur.com/OksvHzZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/lvCFv9F.jpeg" class="img slider_start" alt="" id="76547" srcset="https://i.imgur.com/lvCFv9F.jpeg 1365w, https://i.imgur.com/9f8BVpr.jpeg 200w, https://i.imgur.com/cYxub8f.jpeg 683w, https://i.imgur.com/wwHlxXG.jpeg 768w, https://i.imgur.com/t9ZgII4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/26hGBdF.jpeg" class="img slider_start" alt="" id="76542" srcset="https://i.imgur.com/26hGBdF.jpeg 1365w, https://i.imgur.com/kikbPGz.jpeg 200w, https://i.imgur.com/dBTR4cu.jpeg 683w, https://i.imgur.com/3EhO4Pp.jpeg 768w, https://i.imgur.com/98zV2kZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/vPD6q6r.jpeg" class="img slider_start" alt="" id="76528" srcset="https://i.imgur.com/vPD6q6r.jpeg 1365w, https://i.imgur.com/mVc4sJE.jpeg 200w, https://i.imgur.com/kGQBIwt.jpeg 683w, https://i.imgur.com/Xu8cPMu.jpeg 768w, https://i.imgur.com/RaXJAcZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rLdqNNz.jpeg" class="img slider_start" alt="" id="76745" srcset="https://i.imgur.com/rLdqNNz.jpeg 1365w, https://i.imgur.com/doXk8CN.jpeg 200w, https://i.imgur.com/sXXfyJO.jpeg 683w, https://i.imgur.com/YPYHrSX.jpeg 768w, https://i.imgur.com/PUZhvKV.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yR4ShrC.jpeg" class="img slider_start" alt="" id="76523" srcset="https://i.imgur.com/yR4ShrC.jpeg 1365w, https://i.imgur.com/paFBSfa.jpeg 200w, https://i.imgur.com/Y4T4UIx.jpeg 683w, https://i.imgur.com/7DvlDIv.jpeg 768w, https://i.imgur.com/VQq8VOT.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/QvryBm2.jpeg" class="img slider_start" alt="" id="76733" srcset="https://i.imgur.com/QvryBm2.jpeg 1365w, https://i.imgur.com/pZIKmF6.jpeg 200w, https://i.imgur.com/CQ1s7TW.jpeg 683w, https://i.imgur.com/8y9oX5E.jpeg 768w, https://i.imgur.com/I5kKNYx.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/WRYIWXX.jpeg" class="img slider_start" alt="" id="76548" srcset="https://i.imgur.com/WRYIWXX.jpeg 1365w, https://i.imgur.com/urIzIu3.jpeg 200w, https://i.imgur.com/KiaYtRF.jpeg 683w, https://i.imgur.com/wbnyAFs.jpeg 768w, https://i.imgur.com/G2BAc0u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/JFM2Wjj.jpeg" class="img slider_start" alt="" id="76734" srcset="https://i.imgur.com/JFM2Wjj.jpeg 1365w, https://i.imgur.com/SKJ271Z.jpeg 200w, https://i.imgur.com/KbsgWir.jpeg 683w, https://i.imgur.com/fSImbxj.jpeg 768w, https://i.imgur.com/ACbNkTb.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/aUPxWjm.jpeg" class="img slider_start" alt="" id="76530" srcset="https://i.imgur.com/aUPxWjm.jpeg 1365w, https://i.imgur.com/zSYdgHs.jpeg 200w, https://i.imgur.com/DJxVbSn.jpeg 683w, https://i.imgur.com/Am6MKU0.jpeg 768w, https://i.imgur.com/x8jt1jD.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/6k4saMK.jpeg" class="img slider_start" alt="" id="76504" srcset="https://i.imgur.com/6k4saMK.jpeg 1365w, https://i.imgur.com/KvfIdDt.jpeg 200w, https://i.imgur.com/q38Z4iH.jpeg 683w, https://i.imgur.com/MIaT61y.jpeg 768w, https://i.imgur.com/ZGDLqWY.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/Iy6FHWI.jpeg" class="img slider_start" alt="" id="76447" srcset="https://i.imgur.com/Iy6FHWI.jpeg 1365w, https://i.imgur.com/hPbngSC.jpeg 200w, https://i.imgur.com/jId6jAZ.jpeg 683w, https://i.imgur.com/ygoM6Sf.jpeg 768w, https://i.imgur.com/nrNcdXu.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yWWZ0ir.jpeg" class="img slider_start" alt="" id="76535" srcset="https://i.imgur.com/yWWZ0ir.jpeg 1365w, https://i.imgur.com/UCBy2wi.jpeg 200w, https://i.imgur.com/YgGVVw3.jpeg 683w, https://i.imgur.com/8TbF1sh.jpeg 768w, https://i.imgur.com/hWur2o0.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RkbOwSQ.jpeg" class="img slider_start" alt="" id="42010" srcset="https://i.imgur.com/RkbOwSQ.jpeg 1365w, https://i.imgur.com/CywojLi.jpeg 200w, https://i.imgur.com/LrJf25J.jpeg 683w, https://i.imgur.com/USjIiCJ.jpeg 768w, https://i.imgur.com/hFHg64C.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/9b2tKwE.jpeg" class="img slider_start" alt="" id="76543" srcset="https://i.imgur.com/9b2tKwE.jpeg 1365w, https://i.imgur.com/mIX7ubV.jpeg 200w, https://i.imgur.com/xkSvtmd.jpeg 683w, https://i.imgur.com/ZdNURuR.jpeg 768w, https://i.imgur.com/nEZxFpw.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/mQSkGNt.jpeg" class="img slider_start" alt="" id="76531" srcset="https://i.imgur.com/mQSkGNt.jpeg 1365w, https://i.imgur.com/ruSYC4V.jpeg 200w, https://i.imgur.com/UZQ8L7q.jpeg 683w, https://i.imgur.com/23GoSNa.jpeg 768w, https://i.imgur.com/ugAFAES.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/L5aS54z.jpeg" class="img slider_start" alt="" id="51452" srcset="https://i.imgur.com/L5aS54z.jpeg 1365w, https://i.imgur.com/8DiD0m1.jpeg 200w, https://i.imgur.com/OmwsEIX.jpeg 683w, https://i.imgur.com/yznZPRd.jpeg 768w, https://i.imgur.com/XJmmTNZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RM3o67m.jpeg" class="img slider_start" alt="" id="76529" srcset="https://i.imgur.com/RM3o67m.jpeg 1365w, https://i.imgur.com/pL7LdyU.jpeg 200w, https://i.imgur.com/j6MZedD.jpeg 683w, https://i.imgur.com/2GtLmQH.jpeg 768w, https://i.imgur.com/uiE3Twt.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1366" height="2048" src="https://i.imgur.com/mJCTVqq.jpeg" class="img slider_start" alt="" id="54106" srcset="https://i.imgur.com/mJCTVqq.jpeg 1366w, https://i.imgur.com/bqVkVNS.jpeg 200w, https://i.imgur.com/juxz7Yf.jpeg 683w, https://i.imgur.com/TFRltjb.jpeg 768w, https://i.imgur.com/7055D12.jpeg 1024w" sizes="(max-width: 1366px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/S5OzVf1.jpeg" class="img slider_start" alt="" id="76824" srcset="https://i.imgur.com/S5OzVf1.jpeg 1365w, https://i.imgur.com/dGPrN5A.jpeg 200w, https://i.imgur.com/o7aaxon.jpeg 683w, https://i.imgur.com/c15qeUG.jpeg 768w, https://i.imgur.com/Yu6A2iR.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/HoJujOi.jpeg" class="img slider_start" alt="" id="51483" srcset="https://i.imgur.com/HoJujOi.jpeg 1365w, https://i.imgur.com/jhr3sRB.jpeg 200w, https://i.imgur.com/lvLplWL.jpeg 683w, https://i.imgur.com/DJQNZbf.jpeg 768w, https://i.imgur.com/00J0fU4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/feWpotC.jpeg" class="img slider_start" alt="" id="51461" srcset="https://i.imgur.com/feWpotC.jpeg 1365w, https://i.imgur.com/g6ok9KP.jpeg 200w, https://i.imgur.com/nhvPlfz.jpeg 683w, https://i.imgur.com/840aUGY.jpeg 768w, https://i.imgur.com/wmqfuvq.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/f9jBGLZ.jpeg" class="img slider_start" alt="" id="76534" srcset="https://i.imgur.com/f9jBGLZ.jpeg 1365w, https://i.imgur.com/jhFKKUD.jpeg 200w, https://i.imgur.com/snmlPPg.jpeg 683w, https://i.imgur.com/JlWX7JC.jpeg 768w, https://i.imgur.com/dViG5bk.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/eYSUSdf.jpeg" class="img slider_start" alt="" id="51469" srcset="https://i.imgur.com/eYSUSdf.jpeg 1365w, https://i.imgur.com/tgazdRG.jpeg 200w, https://i.imgur.com/MuJ0R06.jpeg 683w, https://i.imgur.com/UVEC4er.jpeg 768w, https://i.imgur.com/ekJz0cP.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/pio0Kyx.jpeg" class="img slider_start" alt="" id="55494" srcset="https://i.imgur.com/pio0Kyx.jpeg 1365w, https://i.imgur.com/2ClmwQM.jpeg 200w, https://i.imgur.com/oCBKzr2.jpeg 683w, https://i.imgur.com/jGehri2.jpeg 768w, https://i.imgur.com/n17Bj2u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/oMJgqwN.jpeg" class="img slider_start" alt="" id="51458" srcset="https://i.imgur.com/oMJgqwN.jpeg 1365w, https://i.imgur.com/eg8n121.jpeg 200w, https://i.imgur.com/u1UIEjt.jpeg 683w, https://i.imgur.com/rllmlaS.jpeg 768w, https://i.imgur.com/sELLqsI.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/BGrs5Ow.jpeg" class="img slider_start" alt="" id="76532" srcset="https://i.imgur.com/BGrs5Ow.jpeg 1365w, https://i.imgur.com/pOIEgwu.jpeg 200w, https://i.imgur.com/PtJbr4p.jpeg 683w, https://i.imgur.com/RUpMLUZ.jpeg 768w, https://i.imgur.com/A48eHJl.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AcIzEkO.jpeg" class="img slider_start" alt="" id="74421" srcset="https://i.imgur.com/AcIzEkO.jpeg 1365w, https://i.imgur.com/UU45hXH.jpeg 200w, https://i.imgur.com/MYx3OmP.jpeg 683w, https://i.imgur.com/vW4X1j8.jpeg 768w, https://i.imgur.com/Z5kAnQd.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/zvbOL5V.jpeg" class="img slider_start" alt="" id="76732" srcset="https://i.imgur.com/zvbOL5V.jpeg 1365w, https://i.imgur.com/k2id9cy.jpeg 200w, https://i.imgur.com/IvILrya.jpeg 683w, https://i.imgur.com/kNnHne0.jpeg 768w, https://i.imgur.com/HhM2hHK.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AyD0Ot3.jpeg" class="img slider_start" alt="" id="76546" srcset="https://i.imgur.com/AyD0Ot3.jpeg 1365w, https://i.imgur.com/C0chsCS.jpeg 200w, https://i.imgur.com/TTINLQA.jpeg 683w, https://i.imgur.com/9ENG0QP.jpeg 768w, https://i.imgur.com/lx0k1BQ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rQQfXHo.jpeg" class="img slider_start" alt="" id="76823" srcset="https://i.imgur.com/rQQfXHo.jpeg 1365w, https://i.imgur.com/GqcVH0l.jpeg 200w, https://i.imgur.com/c2R4BHZ.jpeg 683w, https://i.imgur.com/1o4z1O6.jpeg 768w, https://i.imgur.com/OksvHzZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/lvCFv9F.jpeg" class="img slider_start" alt="" id="76547" srcset="https://i.imgur.com/lvCFv9F.jpeg 1365w, https://i.imgur.com/9f8BVpr.jpeg 200w, https://i.imgur.com/cYxub8f.jpeg 683w, https://i.imgur.com/wwHlxXG.jpeg 768w, https://i.imgur.com/t9ZgII4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/26hGBdF.jpeg" class="img slider_start" alt="" id="76542" srcset="https://i.imgur.com/26hGBdF.jpeg 1365w, https://i.imgur.com/kikbPGz.jpeg 200w, https://i.imgur.com/dBTR4cu.jpeg 683w, https://i.imgur.com/3EhO4Pp.jpeg 768w, https://i.imgur.com/98zV2kZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/vPD6q6r.jpeg" class="img slider_start" alt="" id="76528" srcset="https://i.imgur.com/vPD6q6r.jpeg 1365w, https://i.imgur.com/mVc4sJE.jpeg 200w, https://i.imgur.com/kGQBIwt.jpeg 683w, https://i.imgur.com/Xu8cPMu.jpeg 768w, https://i.imgur.com/RaXJAcZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rLdqNNz.jpeg" class="img slider_start" alt="" id="76745" srcset="https://i.imgur.com/rLdqNNz.jpeg 1365w, https://i.imgur.com/doXk8CN.jpeg 200w, https://i.imgur.com/sXXfyJO.jpeg 683w, https://i.imgur.com/YPYHrSX.jpeg 768w, https://i.imgur.com/PUZhvKV.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yR4ShrC.jpeg" class="img slider_start" alt="" id="76523" srcset="https://i.imgur.com/yR4ShrC.jpeg 1365w, https://i.imgur.com/paFBSfa.jpeg 200w, https://i.imgur.com/Y4T4UIx.jpeg 683w, https://i.imgur.com/7DvlDIv.jpeg 768w, https://i.imgur.com/VQq8VOT.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/QvryBm2.jpeg" class="img slider_start" alt="" id="76733" srcset="https://i.imgur.com/QvryBm2.jpeg 1365w, https://i.imgur.com/pZIKmF6.jpeg 200w, https://i.imgur.com/CQ1s7TW.jpeg 683w, https://i.imgur.com/8y9oX5E.jpeg 768w, https://i.imgur.com/I5kKNYx.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/WRYIWXX.jpeg" class="img slider_start" alt="" id="76548" srcset="https://i.imgur.com/WRYIWXX.jpeg 1365w, https://i.imgur.com/urIzIu3.jpeg 200w, https://i.imgur.com/KiaYtRF.jpeg 683w, https://i.imgur.com/wbnyAFs.jpeg 768w, https://i.imgur.com/G2BAc0u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/JFM2Wjj.jpeg" class="img slider_start" alt="" id="76734" srcset="https://i.imgur.com/JFM2Wjj.jpeg 1365w, https://i.imgur.com/SKJ271Z.jpeg 200w, https://i.imgur.com/KbsgWir.jpeg 683w, https://i.imgur.com/fSImbxj.jpeg 768w, https://i.imgur.com/ACbNkTb.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/aUPxWjm.jpeg" class="img slider_start" alt="" id="76530" srcset="https://i.imgur.com/aUPxWjm.jpeg 1365w, https://i.imgur.com/zSYdgHs.jpeg 200w, https://i.imgur.com/DJxVbSn.jpeg 683w, https://i.imgur.com/Am6MKU0.jpeg 768w, https://i.imgur.com/x8jt1jD.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/6k4saMK.jpeg" class="img slider_start" alt="" id="76504" srcset="https://i.imgur.com/6k4saMK.jpeg 1365w, https://i.imgur.com/KvfIdDt.jpeg 200w, https://i.imgur.com/q38Z4iH.jpeg 683w, https://i.imgur.com/MIaT61y.jpeg 768w, https://i.imgur.com/ZGDLqWY.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/Iy6FHWI.jpeg" class="img slider_start" alt="" id="76447" srcset="https://i.imgur.com/Iy6FHWI.jpeg 1365w, https://i.imgur.com/hPbngSC.jpeg 200w, https://i.imgur.com/jId6jAZ.jpeg 683w, https://i.imgur.com/ygoM6Sf.jpeg 768w, https://i.imgur.com/nrNcdXu.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yWWZ0ir.jpeg" class="img slider_start" alt="" id="76535" srcset="https://i.imgur.com/yWWZ0ir.jpeg 1365w, https://i.imgur.com/UCBy2wi.jpeg 200w, https://i.imgur.com/YgGVVw3.jpeg 683w, https://i.imgur.com/8TbF1sh.jpeg 768w, https://i.imgur.com/hWur2o0.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RkbOwSQ.jpeg" class="img slider_start" alt="" id="42010" srcset="https://i.imgur.com/RkbOwSQ.jpeg 1365w, https://i.imgur.com/CywojLi.jpeg 200w, https://i.imgur.com/LrJf25J.jpeg 683w, https://i.imgur.com/USjIiCJ.jpeg 768w, https://i.imgur.com/hFHg64C.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/9b2tKwE.jpeg" class="img slider_start" alt="" id="76543" srcset="https://i.imgur.com/9b2tKwE.jpeg 1365w, https://i.imgur.com/mIX7ubV.jpeg 200w, https://i.imgur.com/xkSvtmd.jpeg 683w, https://i.imgur.com/ZdNURuR.jpeg 768w, https://i.imgur.com/nEZxFpw.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/mQSkGNt.jpeg" class="img slider_start" alt="" id="76531" srcset="https://i.imgur.com/mQSkGNt.jpeg 1365w, https://i.imgur.com/ruSYC4V.jpeg 200w, https://i.imgur.com/UZQ8L7q.jpeg 683w, https://i.imgur.com/23GoSNa.jpeg 768w, https://i.imgur.com/ugAFAES.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/L5aS54z.jpeg" class="img slider_start" alt="" id="51452" srcset="https://i.imgur.com/L5aS54z.jpeg 1365w, https://i.imgur.com/8DiD0m1.jpeg 200w, https://i.imgur.com/OmwsEIX.jpeg 683w, https://i.imgur.com/yznZPRd.jpeg 768w, https://i.imgur.com/XJmmTNZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RM3o67m.jpeg" class="img slider_start" alt="" id="76529" srcset="https://i.imgur.com/RM3o67m.jpeg 1365w, https://i.imgur.com/pL7LdyU.jpeg 200w, https://i.imgur.com/j6MZedD.jpeg 683w, https://i.imgur.com/2GtLmQH.jpeg 768w, https://i.imgur.com/uiE3Twt.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1366" height="2048" src="https://i.imgur.com/mJCTVqq.jpeg" class="img slider_start" alt="" id="54106" srcset="https://i.imgur.com/mJCTVqq.jpeg 1366w, https://i.imgur.com/bqVkVNS.jpeg 200w, https://i.imgur.com/juxz7Yf.jpeg 683w, https://i.imgur.com/TFRltjb.jpeg 768w, https://i.imgur.com/7055D12.jpeg 1024w" sizes="(max-width: 1366px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/S5OzVf1.jpeg" class="img slider_start" alt="" id="76824" srcset="https://i.imgur.com/S5OzVf1.jpeg 1365w, https://i.imgur.com/dGPrN5A.jpeg 200w, https://i.imgur.com/o7aaxon.jpeg 683w, https://i.imgur.com/c15qeUG.jpeg 768w, https://i.imgur.com/Yu6A2iR.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/HoJujOi.jpeg" class="img slider_start" alt="" id="51483" srcset="https://i.imgur.com/HoJujOi.jpeg 1365w, https://i.imgur.com/jhr3sRB.jpeg 200w, https://i.imgur.com/lvLplWL.jpeg 683w, https://i.imgur.com/DJQNZbf.jpeg 768w, https://i.imgur.com/00J0fU4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/feWpotC.jpeg" class="img slider_start" alt="" id="51461" srcset="https://i.imgur.com/feWpotC.jpeg 1365w, https://i.imgur.com/g6ok9KP.jpeg 200w, https://i.imgur.com/nhvPlfz.jpeg 683w, https://i.imgur.com/840aUGY.jpeg 768w, https://i.imgur.com/wmqfuvq.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/f9jBGLZ.jpeg" class="img slider_start" alt="" id="76534" srcset="https://i.imgur.com/f9jBGLZ.jpeg 1365w, https://i.imgur.com/jhFKKUD.jpeg 200w, https://i.imgur.com/snmlPPg.jpeg 683w, https://i.imgur.com/JlWX7JC.jpeg 768w, https://i.imgur.com/dViG5bk.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/eYSUSdf.jpeg" class="img slider_start" alt="" id="51469" srcset="https://i.imgur.com/eYSUSdf.jpeg 1365w, https://i.imgur.com/tgazdRG.jpeg 200w, https://i.imgur.com/MuJ0R06.jpeg 683w, https://i.imgur.com/UVEC4er.jpeg 768w, https://i.imgur.com/ekJz0cP.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    
                            <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/pio0Kyx.jpeg" class="img slider_start" alt="" id="55494" srcset="https://i.imgur.com/pio0Kyx.jpeg 1365w, https://i.imgur.com/2ClmwQM.jpeg 200w, https://i.imgur.com/oCBKzr2.jpeg 683w, https://i.imgur.com/jGehri2.jpeg 768w, https://i.imgur.com/n17Bj2u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/oMJgqwN.jpeg" class="img slider_1" alt="" id="51458" srcset="https://i.imgur.com/oMJgqwN.jpeg 1365w, https://i.imgur.com/eg8n121.jpeg 200w, https://i.imgur.com/u1UIEjt.jpeg 683w, https://i.imgur.com/rllmlaS.jpeg 768w, https://i.imgur.com/sELLqsI.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/BGrs5Ow.jpeg" class="img slider_2" alt="" id="76532" srcset="https://i.imgur.com/BGrs5Ow.jpeg 1365w, https://i.imgur.com/pOIEgwu.jpeg 200w, https://i.imgur.com/PtJbr4p.jpeg 683w, https://i.imgur.com/RUpMLUZ.jpeg 768w, https://i.imgur.com/A48eHJl.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AcIzEkO.jpeg" class="img slider_3" alt="" id="74421" srcset="https://i.imgur.com/AcIzEkO.jpeg 1365w, https://i.imgur.com/UU45hXH.jpeg 200w, https://i.imgur.com/MYx3OmP.jpeg 683w, https://i.imgur.com/vW4X1j8.jpeg 768w, https://i.imgur.com/Z5kAnQd.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/zvbOL5V.jpeg" class="img slider_4" alt="" id="76732" srcset="https://i.imgur.com/zvbOL5V.jpeg 1365w, https://i.imgur.com/k2id9cy.jpeg 200w, https://i.imgur.com/IvILrya.jpeg 683w, https://i.imgur.com/kNnHne0.jpeg 768w, https://i.imgur.com/HhM2hHK.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AyD0Ot3.jpeg" class="img slider_5" alt="" id="76546" srcset="https://i.imgur.com/AyD0Ot3.jpeg 1365w, https://i.imgur.com/C0chsCS.jpeg 200w, https://i.imgur.com/TTINLQA.jpeg 683w, https://i.imgur.com/9ENG0QP.jpeg 768w, https://i.imgur.com/lx0k1BQ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rQQfXHo.jpeg" class="img slider_end" alt="" id="76823" srcset="https://i.imgur.com/rQQfXHo.jpeg 1365w, https://i.imgur.com/GqcVH0l.jpeg 200w, https://i.imgur.com/c2R4BHZ.jpeg 683w, https://i.imgur.com/1o4z1O6.jpeg 768w, https://i.imgur.com/OksvHzZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/lvCFv9F.jpeg" class="img slider_end" alt="" id="76547" srcset="https://i.imgur.com/lvCFv9F.jpeg 1365w, https://i.imgur.com/9f8BVpr.jpeg 200w, https://i.imgur.com/cYxub8f.jpeg 683w, https://i.imgur.com/wwHlxXG.jpeg 768w, https://i.imgur.com/t9ZgII4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/26hGBdF.jpeg" class="img slider_end" alt="" id="76542" srcset="https://i.imgur.com/26hGBdF.jpeg 1365w, https://i.imgur.com/kikbPGz.jpeg 200w, https://i.imgur.com/dBTR4cu.jpeg 683w, https://i.imgur.com/3EhO4Pp.jpeg 768w, https://i.imgur.com/98zV2kZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/vPD6q6r.jpeg" class="img slider_end" alt="" id="76528" srcset="https://i.imgur.com/vPD6q6r.jpeg 1365w, https://i.imgur.com/mVc4sJE.jpeg 200w, https://i.imgur.com/kGQBIwt.jpeg 683w, https://i.imgur.com/Xu8cPMu.jpeg 768w, https://i.imgur.com/RaXJAcZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rLdqNNz.jpeg" class="img slider_end" alt="" id="76745" srcset="https://i.imgur.com/rLdqNNz.jpeg 1365w, https://i.imgur.com/doXk8CN.jpeg 200w, https://i.imgur.com/sXXfyJO.jpeg 683w, https://i.imgur.com/YPYHrSX.jpeg 768w, https://i.imgur.com/PUZhvKV.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yR4ShrC.jpeg" class="img slider_end" alt="" id="76523" srcset="https://i.imgur.com/yR4ShrC.jpeg 1365w, https://i.imgur.com/paFBSfa.jpeg 200w, https://i.imgur.com/Y4T4UIx.jpeg 683w, https://i.imgur.com/7DvlDIv.jpeg 768w, https://i.imgur.com/VQq8VOT.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/QvryBm2.jpeg" class="img slider_end" alt="" id="76733" srcset="https://i.imgur.com/QvryBm2.jpeg 1365w, https://i.imgur.com/pZIKmF6.jpeg 200w, https://i.imgur.com/CQ1s7TW.jpeg 683w, https://i.imgur.com/8y9oX5E.jpeg 768w, https://i.imgur.com/I5kKNYx.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/WRYIWXX.jpeg" class="img slider_end" alt="" id="76548" srcset="https://i.imgur.com/WRYIWXX.jpeg 1365w, https://i.imgur.com/urIzIu3.jpeg 200w, https://i.imgur.com/KiaYtRF.jpeg 683w, https://i.imgur.com/wbnyAFs.jpeg 768w, https://i.imgur.com/G2BAc0u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/JFM2Wjj.jpeg" class="img slider_end" alt="" id="76734" srcset="https://i.imgur.com/JFM2Wjj.jpeg 1365w, https://i.imgur.com/SKJ271Z.jpeg 200w, https://i.imgur.com/KbsgWir.jpeg 683w, https://i.imgur.com/fSImbxj.jpeg 768w, https://i.imgur.com/ACbNkTb.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/aUPxWjm.jpeg" class="img slider_end" alt="" id="76530" srcset="https://i.imgur.com/aUPxWjm.jpeg 1365w, https://i.imgur.com/zSYdgHs.jpeg 200w, https://i.imgur.com/DJxVbSn.jpeg 683w, https://i.imgur.com/Am6MKU0.jpeg 768w, https://i.imgur.com/x8jt1jD.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/6k4saMK.jpeg" class="img slider_end" alt="" id="76504" srcset="https://i.imgur.com/6k4saMK.jpeg 1365w, https://i.imgur.com/KvfIdDt.jpeg 200w, https://i.imgur.com/q38Z4iH.jpeg 683w, https://i.imgur.com/MIaT61y.jpeg 768w, https://i.imgur.com/ZGDLqWY.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/Iy6FHWI.jpeg" class="img slider_end" alt="" id="76447" srcset="https://i.imgur.com/Iy6FHWI.jpeg 1365w, https://i.imgur.com/hPbngSC.jpeg 200w, https://i.imgur.com/jId6jAZ.jpeg 683w, https://i.imgur.com/ygoM6Sf.jpeg 768w, https://i.imgur.com/nrNcdXu.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yWWZ0ir.jpeg" class="img slider_end" alt="" id="76535" srcset="https://i.imgur.com/yWWZ0ir.jpeg 1365w, https://i.imgur.com/UCBy2wi.jpeg 200w, https://i.imgur.com/YgGVVw3.jpeg 683w, https://i.imgur.com/8TbF1sh.jpeg 768w, https://i.imgur.com/hWur2o0.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            </div>
                                                    <div class="col"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/aUPxWjm.jpeg" class="img slider_end" alt="" id="76530" srcset="https://i.imgur.com/aUPxWjm.jpeg 1365w, https://i.imgur.com/zSYdgHs.jpeg 200w, https://i.imgur.com/DJxVbSn.jpeg 683w, https://i.imgur.com/Am6MKU0.jpeg 768w, https://i.imgur.com/x8jt1jD.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/6k4saMK.jpeg" class="img slider_end" alt="" id="76504" srcset="https://i.imgur.com/6k4saMK.jpeg 1365w, https://i.imgur.com/KvfIdDt.jpeg 200w, https://i.imgur.com/q38Z4iH.jpeg 683w, https://i.imgur.com/MIaT61y.jpeg 768w, https://i.imgur.com/ZGDLqWY.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/Iy6FHWI.jpeg" class="img slider_end" alt="" id="76447" srcset="https://i.imgur.com/Iy6FHWI.jpeg 1365w, https://i.imgur.com/hPbngSC.jpeg 200w, https://i.imgur.com/jId6jAZ.jpeg 683w, https://i.imgur.com/ygoM6Sf.jpeg 768w, https://i.imgur.com/nrNcdXu.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yWWZ0ir.jpeg" class="img slider_end" alt="" id="76535" srcset="https://i.imgur.com/yWWZ0ir.jpeg 1365w, https://i.imgur.com/UCBy2wi.jpeg 200w, https://i.imgur.com/YgGVVw3.jpeg 683w, https://i.imgur.com/8TbF1sh.jpeg 768w, https://i.imgur.com/hWur2o0.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RkbOwSQ.jpeg" class="img slider_end" alt="" id="42010" srcset="https://i.imgur.com/RkbOwSQ.jpeg 1365w, https://i.imgur.com/CywojLi.jpeg 200w, https://i.imgur.com/LrJf25J.jpeg 683w, https://i.imgur.com/USjIiCJ.jpeg 768w, https://i.imgur.com/hFHg64C.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">
                                <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/RkbOwSQ.jpeg" class="img slider_end" alt="" id="42010" srcset="https://i.imgur.com/RkbOwSQ.jpeg 1365w, https://i.imgur.com/CywojLi.jpeg 200w, https://i.imgur.com/LrJf25J.jpeg 683w, https://i.imgur.com/USjIiCJ.jpeg 768w, https://i.imgur.com/hFHg64C.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">                            <img decoding="async" width="1365" height="2048" src="https://i.imgur.com/pio0Kyx.jpeg" class="img slider_end" alt="" id="55494" srcset="https://i.imgur.com/pio0Kyx.jpeg 1365w, https://i.imgur.com/2ClmwQM.jpeg 200w, https://i.imgur.com/oCBKzr2.jpeg 683w, https://i.imgur.com/jGehri2.jpeg 768w, https://i.imgur.com/n17Bj2u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/oMJgqwN.jpeg" class="img slider_end" alt="" id="51458" srcset="https://i.imgur.com/oMJgqwN.jpeg 1365w, https://i.imgur.com/eg8n121.jpeg 200w, https://i.imgur.com/u1UIEjt.jpeg 683w, https://i.imgur.com/rllmlaS.jpeg 768w, https://i.imgur.com/sELLqsI.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/BGrs5Ow.jpeg" class="img slider_end" alt="" id="76532" srcset="https://i.imgur.com/BGrs5Ow.jpeg 1365w, https://i.imgur.com/pOIEgwu.jpeg 200w, https://i.imgur.com/PtJbr4p.jpeg 683w, https://i.imgur.com/RUpMLUZ.jpeg 768w, https://i.imgur.com/A48eHJl.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AcIzEkO.jpeg" class="img slider_end" alt="" id="74421" srcset="https://i.imgur.com/AcIzEkO.jpeg 1365w, https://i.imgur.com/UU45hXH.jpeg 200w, https://i.imgur.com/MYx3OmP.jpeg 683w, https://i.imgur.com/vW4X1j8.jpeg 768w, https://i.imgur.com/Z5kAnQd.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/zvbOL5V.jpeg" class="img slider_end" alt="" id="76732" srcset="https://i.imgur.com/zvbOL5V.jpeg 1365w, https://i.imgur.com/k2id9cy.jpeg 200w, https://i.imgur.com/IvILrya.jpeg 683w, https://i.imgur.com/kNnHne0.jpeg 768w, https://i.imgur.com/HhM2hHK.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/AyD0Ot3.jpeg" class="img slider_end" alt="" id="76546" srcset="https://i.imgur.com/AyD0Ot3.jpeg 1365w, https://i.imgur.com/C0chsCS.jpeg 200w, https://i.imgur.com/TTINLQA.jpeg 683w, https://i.imgur.com/9ENG0QP.jpeg 768w, https://i.imgur.com/lx0k1BQ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rQQfXHo.jpeg" class="img slider_end" alt="" id="76823" srcset="https://i.imgur.com/rQQfXHo.jpeg 1365w, https://i.imgur.com/GqcVH0l.jpeg 200w, https://i.imgur.com/c2R4BHZ.jpeg 683w, https://i.imgur.com/1o4z1O6.jpeg 768w, https://i.imgur.com/OksvHzZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/lvCFv9F.jpeg" class="img slider_end" alt="" id="76547" srcset="https://i.imgur.com/lvCFv9F.jpeg 1365w, https://i.imgur.com/9f8BVpr.jpeg 200w, https://i.imgur.com/cYxub8f.jpeg 683w, https://i.imgur.com/wwHlxXG.jpeg 768w, https://i.imgur.com/t9ZgII4.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/26hGBdF.jpeg" class="img slider_end" alt="" id="76542" srcset="https://i.imgur.com/26hGBdF.jpeg 1365w, https://i.imgur.com/kikbPGz.jpeg 200w, https://i.imgur.com/dBTR4cu.jpeg 683w, https://i.imgur.com/3EhO4Pp.jpeg 768w, https://i.imgur.com/98zV2kZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/vPD6q6r.jpeg" class="img slider_end" alt="" id="76528" srcset="https://i.imgur.com/vPD6q6r.jpeg 1365w, https://i.imgur.com/mVc4sJE.jpeg 200w, https://i.imgur.com/kGQBIwt.jpeg 683w, https://i.imgur.com/Xu8cPMu.jpeg 768w, https://i.imgur.com/RaXJAcZ.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/rLdqNNz.jpeg" class="img slider_end" alt="" id="76745" srcset="https://i.imgur.com/rLdqNNz.jpeg 1365w, https://i.imgur.com/doXk8CN.jpeg 200w, https://i.imgur.com/sXXfyJO.jpeg 683w, https://i.imgur.com/YPYHrSX.jpeg 768w, https://i.imgur.com/PUZhvKV.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/yR4ShrC.jpeg" class="img slider_end" alt="" id="76523" srcset="https://i.imgur.com/yR4ShrC.jpeg 1365w, https://i.imgur.com/paFBSfa.jpeg 200w, https://i.imgur.com/Y4T4UIx.jpeg 683w, https://i.imgur.com/7DvlDIv.jpeg 768w, https://i.imgur.com/VQq8VOT.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/QvryBm2.jpeg" class="img slider_end" alt="" id="76733" srcset="https://i.imgur.com/QvryBm2.jpeg 1365w, https://i.imgur.com/pZIKmF6.jpeg 200w, https://i.imgur.com/CQ1s7TW.jpeg 683w, https://i.imgur.com/8y9oX5E.jpeg 768w, https://i.imgur.com/I5kKNYx.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/WRYIWXX.jpeg" class="img slider_end" alt="" id="76548" srcset="https://i.imgur.com/WRYIWXX.jpeg 1365w, https://i.imgur.com/urIzIu3.jpeg 200w, https://i.imgur.com/KiaYtRF.jpeg 683w, https://i.imgur.com/wbnyAFs.jpeg 768w, https://i.imgur.com/G2BAc0u.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/JFM2Wjj.jpeg" class="img slider_end" alt="" id="76734" srcset="https://i.imgur.com/JFM2Wjj.jpeg 1365w, https://i.imgur.com/SKJ271Z.jpeg 200w, https://i.imgur.com/KbsgWir.jpeg 683w, https://i.imgur.com/fSImbxj.jpeg 768w, https://i.imgur.com/ACbNkTb.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/aUPxWjm.jpeg" class="img slider_end" alt="" id="76530" srcset="https://i.imgur.com/aUPxWjm.jpeg 1365w, https://i.imgur.com/zSYdgHs.jpeg 200w, https://i.imgur.com/DJxVbSn.jpeg 683w, https://i.imgur.com/Am6MKU0.jpeg 768w, https://i.imgur.com/x8jt1jD.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/6k4saMK.jpeg" class="img slider_end" alt="" id="76504" srcset="https://i.imgur.com/6k4saMK.jpeg 1365w, https://i.imgur.com/KvfIdDt.jpeg 200w, https://i.imgur.com/q38Z4iH.jpeg 683w, https://i.imgur.com/MIaT61y.jpeg 768w, https://i.imgur.com/ZGDLqWY.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px"><img decoding="async" width="1365" height="2048" src="https://i.imgur.com/Iy6FHWI.jpeg" class="img slider_end" alt="" id="76447" srcset="https://i.imgur.com/Iy6FHWI.jpeg 1365w, https://i.imgur.com/hPbngSC.jpeg 200w, https://i.imgur.com/jId6jAZ.jpeg 683w, https://i.imgur.com/ygoM6Sf.jpeg 768w, https://i.imgur.com/nrNcdXu.jpeg 1024w" sizes="(max-width: 1365px) 100vw, 1365px">
                                </div>
    </div>

    <a class="link btn_link" href="../hbz-photography.ca/The-Gallery.php" target="">
    <span>
        view the portfolio    </span>

    <svg width="8px" height="8px" class="icon">
        <use xlink:href="https://www.purpletree.ca/wp-content/themes/marck/assets/img/sprite.svg#arrow"></use>
    </svg>
</a>

    <script>
        var position = document.querySelector('.section_5 .wrap').offsetWidth - document.querySelector('.section_5 .scroll').offsetWidth;
        document.querySelector('.section_5 .scroll').scrollLeft = position / 2 + 20;
    </script>
</div></section>


<section class="section_7">
    <div class="container">
        <div class="wrap">
            <div class="col col--left">
            <img decoding="async" width="1365" height="1853" src="https://i.imgur.com/tNRUcc7.jpeg" class="img" alt="" sizes="500px" id="74401" srcset="https://i.imgur.com/tNRUcc7.jpeg 1365w, https://i.imgur.com/pVIvjZS.jpeg 221w, https://i.imgur.com/euW71Cq.jpeg 754w, https://i.imgur.com/DS7BEPM.jpeg 768w, https://i.imgur.com/cIdtLcV.jpeg 1131w"><div class="brforetitle ftype_0">
    get inspired</div>
<h2 class="title ftype_2">HBZ-Photography</h2>            </div>

            <div class="col col--right">
            <img decoding="async" width="2048" height="1365" src="https://lh3.googleusercontent.com/h-pIQMjL9Y_DUOCC7JRlbgGa783UKZo8tBXacFXxctabxklTJWMrQKeQMIox0XARFO6evRjYKG4EiEiwhy0kZsnvr8mXBX14y_ppVsM=w627-h418-rw-e30" class="img" alt="" sizes="500px" id="42181" srcset="https://lh3.googleusercontent.com/h-pIQMjL9Y_DUOCC7JRlbgGa783UKZo8tBXacFXxctabxklTJWMrQKeQMIox0XARFO6evRjYKG4EiEiwhy0kZsnvr8mXBX14y_ppVsM=w627-h418-rw-e30"><div class="brforetitle ftype_0">ARE YOU FEELING LOST?</div>
<h2 class="title ftype_2">HBZ-Photography</h2><div class="text ftype_4">
    <p>At HBZ-Photography, we offer exceptional wedding packages tailored to make your day unforgettable, with flexible forfaits starting at affordable rates to suit your needs, ensuring every cherished moment is captured beautifully across Quebec.</p>
</div>
<a class="link btn" href="../hbz-photography.ca/contact-us.php#weddingpackages" target="">
    Explore Our Forfaits</a>            </div>
        </div>
    </div>
</section>


<section class="section_3 bg-grey">
    <div class="container">
        <h2 class="title ftype_2">OUR PHILOSOPHY</h2><div class="text ftype_4 flipp">
    <p>"In Photography and in Life Always Look For The Light , If You Don't See It , Bring it."</p>
<p>Over the years, Hassan Ben Zid has shaped a unique emotional and creative vision that characterizes his work across Quebec. He cherishes a welcoming ambiance and serenity – and this is the essence he strives to bring when you’re with him – every moment will unfold effortlessly, guided with gentle care throughout your wedding day.</p>
<p>We see every photo as a timeless marker; a heritage that endures forever – every moment of your day holds deep value to us. Preserving legacy is our core, and we craft it daily with our gentle, evocative images (they softly narrate the tale to future generations!). We aren’t self-centered, and let us clarify that. Your special day isn’t about us orchestrating poses or setting the scene. It’s entirely about you and your beloved, and we’ll go all out to ensure the journey is joyful and unforgettable from beginning to end across Quebec!</p>
<p>It’s all about fostering an environment of trust and admiration – these are the cornerstones of our craft – leading to stunning visual records from your joyful day and a sense of fulfillment in our work! YOU are never just a statistic to us, and after all these years in wedding photography across Quebec, we still embrace each client as if they were our very first, making every experience feel uniquely precious. We believe joyful souls radiate beauty, and a smile has the power to transform the world, so let’s share a grin together!</p>
</div>

        <button class="readmore btn_line" onclick="funFlipp(this)">
            <span>Read more</span>
            <span>Close</span>
        </button>
    </div>
</section>



<section class="section_8">
    <div class="container">
        <div class="wrap">
            <div class="top-image">
                <img decoding="async" width="2048" height="1365" src="https://lh3.googleusercontent.com/L6zs2OXyumrmQOBOuN2kS3b_1lirgYN8KbEudU2YRqNrPAXSg-xtmy0PXICxXkuz5bjElLLAcH6-TLaq2jG-burWCQ0TZTp0Bxja=w825-h550-rw-e30" class="img" alt="" sizes="600px" id="53246" srcset="https://lh3.googleusercontent.com/L6zs2OXyumrmQOBOuN2kS3b_1lirgYN8KbEudU2YRqNrPAXSg-xtmy0PXICxXkuz5bjElLLAcH6-TLaq2jG-burWCQ0TZTp0Bxja=w825-h550-rw-e30">
            </div>

            <div class="col col--1">
    <img decoding="async" width="1365" height="2048" src="https://lh3.googleusercontent.com/UklSekBFyDL60s1jaA61D6t77QxKI0uiqdADT2NyA9h4q3l752cDbFQw_fT11b5JdEWITCyZ_SuRUzNFxgRNWojvsxr9wNwCJhjP1Sw=w294-h441-rw-e30" class="img" alt="" sizes="400px" id="74415" srcset="https://lh3.googleusercontent.com/UklSekBFyDL60s1jaA61D6t77QxKI0uiqdADT2NyA9h4q3l752cDbFQw_fT11b5JdEWITCyZ_SuRUzNFxgRNWojvsxr9wNwCJhjP1Sw=w294-h441-rw-e30">
    <style>
        .col--1 .img {
            max-width: 90%; /* Retain the 80% width from section_8 */
            height: auto;
            margin-left: 20%; /* Shift right by 15px; adjust as needed */
            /* OR use position if preferred: */
            /* position: relative; left: 15px; */
        }
    </style>
</div>

            <div class="col col--2">
                <h2 class="title ftype_2"><p>The <em>fleeting </em>INSTANTS may slip away, but, you will <strong>FOREVER </strong>HOLD <em>the photographs </em>to <strong>REKINDLE</strong> those memories.</p>
                </h2><div class="text ftype_4">
                    <p>We don’t merely capture images with a lens, we seize them with our soul.</p>
                </div>
                <a class="btn" href="../hbz-photography.ca/contact-us.php" target="">
                    let’s work together</a>
            </div>

            <div class="col col--3">
                <img decoding="async" width="1365" height="2048" src="https://lh3.googleusercontent.com/F0DhxMiyUJ-3bJnBIKmLyov_OCQmDZwkdqnpVu7j4YwjRkju_foMXB43Izfsya2KJLtx_IVQzVhg5GZAEf0u7BygfksRPZXJQ7Ix11A=w395-h592-rw-e30" class="img" alt="" sizes="400px" id="52866" srcset="https://lh3.googleusercontent.com/F0DhxMiyUJ-3bJnBIKmLyov_OCQmDZwkdqnpVu7j4YwjRkju_foMXB43Izfsya2KJLtx_IVQzVhg5GZAEf0u7BygfksRPZXJQ7Ix11A=w395-h592-rw-e30">
            </div>
        </div>
    </div>
    <style>
        .section_8 .img {
            max-width: 80%; /* Reduce images to 80% of their container width */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</section>
    </main>

    <footer class="footer">
        <div class="section_instagramm">
            <div class="container">
                <div class="title ftype_3">
                    Follow Us on Instagram :
                </div>

                <div class="wrap">
                    
<div id="sb_instagram" class="sbi sbi_mob_col_3 sbi_tab_col_4 sbi_col_4 sbi_medium" style="width: 100%;" data-feedid="sbi_purpletreephotography#4" data-res="full" data-cols="4" data-colsmobile="3" data-colstablet="4" data-num="4" data-nummobile="3" data-item-padding="0" data-shortcode-atts="{}" data-postid="3793" data-locatornonce="5aac37edd7" data-imageaspectratio="1:1" data-sbi-flags="favorLocal" data-sbi-index="1">
	
	<div id="sbi_images">
		<div class="sbi_item sbi_type_carousel sbi_had_error" id="sbi_17934200283040075" data-date="1748879802">
	<div class="sbi_photo_wrap">
		<a class="sbi_photo" href="https://www.instagram.com/p/CrLrqcKuEo4/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==" target="_blank" alt="Un toast à la @rosana_mtl
.
.
.
#montrealphotographer #couplesphotograhy #photographer #downtownphotography #montrealdowntown #terrebonne #514 #montreal #couplesphotoshoot #photography #love #photooftheday #instagood #photoshoot #torontophotography #couple #inlove #romanticphotoshoot #mtlwedding #montrealwedding #mtlweddingphotographer #montrealweddingplanner #photographybyhbz #mtl #couplesinlove #montrealweddingdress #brideandgroom #weddingdressinspo #weddinginspo" rel="noopener nofollow" style="height: 252.5px; opacity: 1;">
			<span class="sbi-screenreader">Angeila Wedding 🥂</span>
			<svg class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" aria-label="Clone" data-fa-proƒcessed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path>
                </svg>						<img src="https://lh3.googleusercontent.com/2uoo3rw7aQNP9553Jzh4WQLzAP5RSjfTV-AmihNYSri66RGeFSzRsv0EKSs14twTHQXJxLTws9p3ISJYHQpWf4rorux7D26CTakzdA=w1200-h800-rw-e30" aria-hidden="true" class="sbi_img_error">
		</a>
	</div>
</div><div class="sbi_item sbi_type_carousel sbi_had_error" id="sbi_17934200283040075" data-date="1748879802">
	<div class="sbi_photo_wrap">
		<a class="sbi_photo" href="https://www.instagram.com/p/CgAF_f4uTGr/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==" target="_blank" alt="@hchiaki wedding ceremony 🌹

.
.
.
.
#montrealphotographer #couplesphotograhy #photographer #downtownphotography #montrealdowntown #terrebonne #514 #montreal #couplesphotoshoot #photography #love #photooftheday #instagood #photoshoot #torontophotography #couple #inlove #romanticphotoshoot #mtlwedding #montrealwedding #mtlweddingphotographer #montrealweddingplanner #photographybyhbz #mtl #couplesinlove #montrealweddingdress #brideandgroom #weddingdressinspo #weddinginspo" rel="noopener nofollow" style="height: 252.5px; opacity: 1;">
			<span class="sbi-screenreader">Hara wedding 🥂</span>
			<svg class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" aria-label="Clone" data-fa-proƒcessed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path>
                </svg>						<img src="https://lh3.googleusercontent.com/3with19X1vZDHcvfu5ISHGddXh748YAiOODxNHitt3uWykcRr_i5XGzCB9wA7HjIpHiSsmzAgUe8KL4pgWoh4gtnADnXlTY-avZ7xA=w1200-h800-l90-rw-e30" aria-hidden="true" class="sbi_img_error">
		</a>
	</div>
</div><div class="sbi_item sbi_type_carousel" id="sbi_18071788837755973" data-date="1748534609">
	<div class="sbi_photo_wrap">
		<a class="sbi_photo" href="https://www.instagram.com/p/CTTUNk6jlE0/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==" target="_blank" rel="noopener nofollow" alt="A great photoshoot session with @isacristinacz 🌸

.
.
.
.
#montrealphotographer #couplesphotograhy #photographer #downtownphotography #montrealdowntown #terrebonne #514 #montreal #couplesphotoshoot #photography #love #photooftheday #instagood #photoshoot #torontophotography #couple #inlove #romanticphotoshoot #mtlwedding #montrealwedding #mtlweddingphotographer #montrealweddingplanner #photographybyhbz #mtl #couplesinlove #montrealweddingdress #brideandgroom #weddingdressinspo #weddinginspo" style="height: 252.5px; opacity: 1;">
			<span class="sbi-screenreader">isacristinacz wedding 🌸</span>
			<svg class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" aria-label="Clone" data-fa-proƒcessed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path>
                </svg>						<img src="https://i.imgur.com/0BNL6k4.jpeg" aria-hidden="true">
		</a>
	</div>
</div><div class="sbi_item sbi_type_carousel" id="sbi_18071788837755973" data-date="1748534609">
	<div class="sbi_photo_wrap">
		<a class="sbi_photo" href="https://www.instagram.com/p/DE8ftyjpEQo/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==" target="_blank" rel="noopener nofollow" alt="Captured pure magic on a private island—where love met paradise. 🏝️📸 Every detail, every moment, a masterpiece.
Congratulations again Noelle and Kevin 🥂
.
.
.
.
.
.
.
.
.
.
#MontrealWeddingPhotographer
#WeddingPhotographerMontreal
#WeddingPhotographyMontreal
#MontrealWeddingPhotography
#WeddingPhotosMontreal
#MontrealWeddings
#MontrealBride
#MontrealCouples
#LoveInMontreal
#MontrealWeddingStyle
#ElegantWeddingsMontreal
#RomanticWeddingsMTL
#FineArtWeddingPhotography
#WeddingInspirationMontreal
#MontrealWeddingVibes
#SupportLocalMontreal
#WeddingVendorsMontreal
#MontrealWeddingPros
#MTLWeddingDream
#QuebecWeddings
#MontrealLoveStory
#CapturingLoveMTL
#WeddingMomentsMontreal
#CoupleGoalsMontreal
#ForeverInMontreal" style="height: 252.5px; opacity: 1;">
			<span class="sbi-screenreader">N&amp;K wedding 🌸</span>
			<svg class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" aria-label="Clone" data-fa-proƒcessed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path>
                </svg>						<img src="https://lh3.googleusercontent.com/r-FxtyzBKa-TrfWQmehtkFah-9GYIbirJRmhd0DoAO_48QMhcG7eWDt4ONvxi-8-11FFlup8NDg1rlUHsPXyR0kFtr1SDHLRdOZcDOw=w1200-h800-l90-rw-e30" aria-hidden="true">
		</a>
	</div>
</div>	</div>

	<div id="sbi_load">

	
	
</div>
		
	</div>

<script type="text/javascript">var sb_instagram_js_options = {"font_method":"svg","placeholder":"https:\/\/www.purpletree.ca\/wp-content\/plugins\/instagram-feed\/img\/placeholder.png","resized_url":"https:\/\/www.purpletree.ca\/wp-content\/uploads\/sb-instagram-feed-images\/","ajax_url":"https:\/\/www.purpletree.ca\/wp-admin\/admin-ajax.php"};</script><script type="text/javascript" src="https://www.purpletree.ca/wp-content/plugins/instagram-feed/js/sbi-scripts.min.js?ver=6.9.1"></script>                </div>
            </div>
        </div>

        <div class="footer_content">
            <div class="container">
                <div class="wrap">
                    <div class="col col--left">
                        <nav class="nav">
                            <div class="menu-footer-container"><ul id="menu-footer" class="menu"><li id="menu-item-7370" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-3793 current_page_item menu-item-7370"><a href="../hbz-photography.ca/frontpage.php" aria-current="page">Home</a></li>
<li id="menu-item-37271" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37271"><a href="../hbz-photography.ca/The-Gallery.php">The gallery</a></li>
<li id="menu-item-37275" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37275"><a href="../hbz-photography.ca/contact-us.php">Contact</a></li>
<li id="menu-item-37271" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37271"><a href="../hbz-photography.ca/contact-us#weddingpackages.php">Our Forfaits</a></li>
</ul></div>                    </nav>


                    </div>

                    <div class="col col--right">
                        <div class="cont">
                            <div class="tit">Get The Newsletter</div>

                            <div class="text">Subscribe to our newsletter &amp; stay updated</div>
                        </div>

                        <div class="mailchimp">
                            <script>(function() {
	window.mc4wp = window.mc4wp || {
		listeners: [],
		forms: {
			on: function(evt, cb) {
				window.mc4wp.listeners.push(
					{
						event   : evt,
						callback: cb
					}
				);
			}
		}
	}
})();
</script><!-- Mailchimp for WordPress v4.10.4 - https://wordpress.org/plugins/mailchimp-for-wp/ -->
    <script>
        window.onload = function() {
            // Restore scroll position only if it's a submission redirect (status present)
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            if (status) {
                const savedScroll = sessionStorage.getItem('scrollPosition');
                if (savedScroll) {
                    window.scrollTo(0, parseInt(savedScroll));
                    sessionStorage.removeItem('scrollPosition');
                } else {
                    const form = document.querySelector('#subscribe-form');
                    if (form) {
                        form.scrollIntoView({ behavior: 'auto' });
                    }
                }
            }
        };

        // Save scroll position before submit
        document.querySelector('.mc4wp-form').addEventListener('submit', function(e) {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    </script>

<div id="subscribe-form"> <!-- Anchor point -->
        <form class="mc4wp-form" method="post" action="frontpage.php">
            <div class="mc4wp-form-fields">
                <div class="frm">
                    <input class="input" type="email" name="EMAIL" placeholder="Enter your email address" required>
                    <button class="button" type="submit">Subscribe</button>
                </div>
            </div>
            <label style="display: none !important;">Leave this field empty if you're human: <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off"></label>
            <input type="hidden" name="_mc4wp_timestamp" value="1749030713">
            <input type="hidden" name="_mc4wp_form_id" value="24007">
            <input type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1">
            <?php if ($msg): ?>
                <div class="mc4wp-response" style="color: <?php echo $status === 'success' ? 'green' : 'red'; ?>;">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>
        </form>
    </div><!-- / Mailchimp for WordPress Plugin -->                        </div>
                    </div>
                    <style>
    .khabi {
position: absolute;
            top: -9999px;
            left: -9999px;
            opacity: 0;
            pointer-events: none; /* Prevent interaction */
        }
</style>
<div class="khabi">
 <a href='https://www.free-counters.org/'>... by Free-Counters.org</a> <script type='text/javascript' src='https://www.freevisitorcounters.com/auth.php?id=2acc9b0efc74e00fee86af1829f9ccbac030c584'></script>
<script type="text/javascript" src="https://freevisitorcounters.com/en/home/counter/1354213/t/4"></script>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const khabi = document.querySelector('.khabi');
            if (khabi) {

                khabi.style.position = 'absolute';
                khabi.style.top = '-9999px';
                khabi.style.left = '-9999px';
                khabi.style.opacity = '0';
            }
        });
    </script>
                </div>
            </div>
        </div>

    </footer>

    <script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/marck\/*","\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
<script>(function() {function maybePrefixUrlField () {
  const value = this.value.trim()
  if (value !== '' && value.indexOf('http') !== 0) {
    this.value = 'http://' + value
  }
}

const urlFields = document.querySelectorAll('.mc4wp-form input[type="url"]')
for (let j = 0; j < urlFields.length; j++) {
  urlFields[j].addEventListener('blur', maybePrefixUrlField)
}
})();</script><!-- Instagram Feed JS -->
<script type="text/javascript">
var sbiajaxurl = "https://www.purpletree.ca/wp-admin/admin-ajax.php";
jQuery( document ).ready(function($) {
window.sbi_custom_js = function(){
$(document).ready(function() {
$('a.sbi_photo').attr('rel','nofollow');
});
}
});
</script>
<script src="https://www.purpletree.ca/wp-includes/js/dist/hooks.min.js?ver=4d63a3d491d11ffd8ac6" id="wp-hooks-js"></script>
<script src="https://www.purpletree.ca/wp-includes/js/dist/i18n.min.js?ver=5e580eb46a90c2b997e6" id="wp-i18n-js"></script>
<script id="wp-i18n-js-after">
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
</script>
<script src="https://www.purpletree.ca/wp-content/plugins/contact-form-7/includes/swv/js/index.js?ver=6.0.6" id="swv-js"></script>

<script src="https://www.purpletree.ca/wp-content/plugins/contact-form-7/includes/js/index.js?ver=6.0.6" id="contact-form-7-js"></script>
<script src="https://www.purpletree.ca/wp-content/plugins/date-time-picker-for-contact-form-7/assets/js/jquery.datetimepicker.full.min.js?ver=6.8.1" id="walcf7-datepicker-js-js"></script>
<script src="https://www.purpletree.ca/wp-content/plugins/date-time-picker-for-contact-form-7/assets/js/datetimepicker.js?ver=1.0.0" id="walcf7-datepicker-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/script.js?ver=6.8.1" id="main-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/aos.js?ver=6.8.1" id="aos-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/simpleParallax.min.js?ver=6.8.1" id="parallax-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/fancybox.min.js?ver=6.8.1" id="fancybox-js"></script>
<script src="https://www.purpletree.ca/wp-includes/js/imagesloaded.min.js?ver=5.0.0" id="imagesloaded-js"></script>
<script src="https://www.purpletree.ca/wp-includes/js/masonry.min.js?ver=4.2.2" id="masonry-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/slick.min.js?ver=6.8.1" id="slick-js"></script>
<script src="https://www.purpletree.ca/wp-content/themes/marck/assets/js/app.js?ver=1.1.6" id="app-js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;ver=3.0" id="google-recaptcha-js"></script>
<script src="https://www.purpletree.ca/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=3.15.0" id="wp-polyfill-js"></script>
<script id="wpcf7-recaptcha-js-before">
var wpcf7_recaptcha = {
    "sitekey": "6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3",
    "actions": {
        "homepage": "homepage",
        "contactform": "contactform"
    }
};
</script>
<script src="https://www.purpletree.ca/wp-content/plugins/contact-form-7/modules/recaptcha/index.js?ver=6.0.6" id="wpcf7-recaptcha-js"></script>
<script defer="" src="https://www.purpletree.ca/wp-content/plugins/mailchimp-for-wp/assets/js/forms.js?ver=4.10.4" id="mc4wp-forms-api-js"></script>

<div><div class="grecaptcha-badge" data-style="bottomright" style="width: 256px; height: 60px; display: block; transition: right 0.3s; position: fixed; bottom: 14px; right: -186px; box-shadow: gray 0px 0px 5px; border-radius: 2px; overflow: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-iuo7ldh0ano1" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=2&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=aHR0cHM6Ly93d3cucHVycGxldHJlZS5jYTo0NDM.&amp;hl=en&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=h31zvi68ga9t"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-tjkol9i8mhjw" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=z0hiak5uzb1c"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-5nsos143arvk" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=7yfywrr2pzgj"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-4t5sq7xuzu0o" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=dfac734m5r8f"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-eoczt0oo9nmu" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=5lnm2i5ee4ez"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-9b7uoziuobjq" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=70j9186df6e8"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-ln6mkrs721jw" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=ofjbe3tpftsx"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-qejeek9wd4zw" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=b6owf9hu7on8"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-q3hu97ixhh1j" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=odce8lmjqruw"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div>
    <iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-vca9z6ydx4h1" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=7q5hh13yxa14"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-2smq51st5py5" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=3v0fvaqo1ipg"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-w2h2unfxlalb" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=kufafpa9zdrv"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div><div><div class="grecaptcha-badge" data-style="none" style="width: 256px; height: 60px; position: fixed; visibility: hidden;"><div class="grecaptcha-logo"><iframe title="reCAPTCHA" width="256" height="60" role="presentation" name="a-1d5yqee5kqzq" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LePobAUAAAAAL_SSk9JxLuabccyfbookpMkKK-3&amp;co=ZmlsZTo.&amp;hl=fr&amp;v=GUGrl5YkSwqiWrzO3ShIKDlu&amp;size=invisible&amp;cb=kn2c8derkrjg"></iframe></div><div class="grecaptcha-error"></div><textarea id="g-recaptcha-response-100000" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>

    </body></html>