<?php
/**
 * Script de prueba: envío de correo por SMTP (Gmail)
 * Destino: anibal.sanchez@inecol.mx
 * Uso: php envio_correo_prueba_smtp.php
 *      o abrir en navegador (ajustar ruta si es necesario)
 *
 * Credenciales usadas: sce.posgrado@gmail.com / smtp.gmail.com:465 SSL
 */

// Evitar timeout en navegador
if (php_sapi_name() !== 'cli') {
    set_time_limit(60);
    header('Content-Type: text/html; charset=utf-8');
}

$mail_smtp_server   = 'smtp.gmail.com';
$mail_smtp_user     = 'sce.posgrado@gmail.com';
$mail_smtp_pass     = 'fqczuzvfomytleda';
$mail_from          = 'sce.posgrado@gmail.com';
$mail_port          = 465;
$mail_use_ssl       = true;   // S = SSL

$mail_to            = 'anibal.sanchez@inecol.mx';
$asunto             = 'Prueba de envío SMTP - ' . date('Y-m-d H:i:s');
$cuerpo_texto        = "Hola,\n\nEste es un correo de prueba enviado desde el script PHP con las credenciales SMTP de Gmail (sce.posgrado@gmail.com).\n\nSi recibes esto, la configuración SMTP funciona correctamente.\n\nFecha: " . date('Y-m-d H:i:s') . "\n\nSaludos.";
$cuerpo_html        = '<html><body style="font-family: sans-serif;">'
    . '<p>Hola,</p>'
    . '<p>Este es un <strong>correo de prueba</strong> enviado desde el script PHP con las credenciales SMTP de Gmail (<code>sce.posgrado@gmail.com</code>).</p>'
    . '<p>Si recibes esto, la configuración SMTP funciona correctamente.</p>'
    . '<p>Fecha: ' . date('Y-m-d H:i:s') . '</p>'
    . '<p>Saludos.</p></body></html>';

$boundary = '----=_Part_' . md5(uniqid());

$raw = "From: $mail_from\r\n"
    . "To: $mail_to\r\n"
    . "Subject: =?UTF-8?B?" . base64_encode($asunto) . "?=\r\n"
    . "MIME-Version: 1.0\r\n"
    . "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n\r\n"
    . "--$boundary\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n\r\n"
    . $cuerpo_texto . "\r\n\r\n"
    . "--$boundary\r\n"
    . "Content-Type: text/html; charset=UTF-8\r\n\r\n"
    . $cuerpo_html . "\r\n\r\n"
    . "--$boundary--\r\n";

function enviar_smtp_ssl($host, $port, $user, $pass, $from, $to, $raw_message) {
    $errno = 0;
    $errstr = '';
    $ctx = stream_context_create([
        'ssl' => [
            'verify_peer'       => true,
            'verify_peer_name'  => true,
        ]
    ]);
    $fp = @stream_socket_client(
        "ssl://$host:$port",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $ctx
    );
    if (!$fp) {
        return [false, "Conexión fallida: $errstr ($errno)"];
    }
    stream_set_timeout($fp, 15);

    // Leer una línea del servidor
    $readLine = function () use ($fp) {
        $line = @fgets($fp, 8192);
        return $line === false ? '' : $line;
    };

    // Leer respuesta SMTP completa (puede ser multi-línea: 250-... 250-... 250 ...)
    $readResponse = function () use ($fp, $readLine) {
        $last = '';
        do {
            $line = $readLine();
            if ($line !== '') {
                $last = $line;
            }
        } while ($line !== '' && isset($line[3]) && $line[3] === '-');
        return $last;
    };

    $resp = $readResponse();
    if (strpos($resp, '220') !== 0) {
        fclose($fp);
        return [false, "SMTP greeting: $resp"];
    }

    $send = function ($cmd) use ($fp, $readResponse) {
        fwrite($fp, $cmd . "\r\n");
        return $readResponse();
    };

    $send("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
    $send("AUTH LOGIN");
    $send(base64_encode($user));
    $r = $send(base64_encode($pass));
    if (strpos($r, '235') !== 0) {
        fclose($fp);
        return [false, "AUTH fallido: $r"];
    }

    $send("MAIL FROM:<$from>");
    $r = $send("RCPT TO:<$to>");
    if (strpos($r, '250') !== 0 && strpos($r, '251') !== 0) {
        fclose($fp);
        return [false, "RCPT TO: $r"];
    }

    $send("DATA");
    fwrite($fp, $raw_message . "\r\n.\r\n");
    $r = $readResponse();
    if (strpos($r, '250') !== 0) {
        fclose($fp);
        return [false, "DATA: $r"];
    }

    $send("QUIT");
    fclose($fp);
    return [true, 'OK'];
}

list($ok, $msg) = enviar_smtp_ssl(
    $mail_smtp_server,
    $mail_port,
    $mail_smtp_user,
    $mail_smtp_pass,
    $mail_from,
    $mail_to,
    $raw
);

if (php_sapi_name() === 'cli') {
    echo $ok ? "Correo enviado correctamente a $mail_to\n" : "Error: $msg\n";
    exit($ok ? 0 : 1);
}

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Prueba SMTP</title></head><body>';
echo '<h1>Prueba de envío de correo SMTP</h1>';
if ($ok) {
    echo '<p style="color:green;">Correo enviado correctamente a <strong>' . htmlspecialchars($mail_to) . '</strong>.</p>';
    echo '<p>Revisa tu bandeja (y carpeta de spam) en unos segundos.</p>';
} else {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($msg) . '</p>';
}
echo '<p><small>Servidor: ' . htmlspecialchars($mail_smtp_server) . ':' . $mail_port . ' (SSL)</small></p>';
echo '</body></html>';
