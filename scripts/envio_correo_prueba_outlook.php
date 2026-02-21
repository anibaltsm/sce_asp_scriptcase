<?php
/**
 * Script de prueba: envío de correo por SMTP Outlook/Office 365
 * Servidor: smtp.office365.com, puerto 587, STARTTLS
 * Destino: anibal.sanchez@inecol.mx
 * Uso: php envio_correo_prueba_outlook.php
 */

if (php_sapi_name() !== 'cli') {
    set_time_limit(60);
    header('Content-Type: text/html; charset=utf-8');
}

// Credenciales Outlook / Office 365 (inecol.mx)
$mail_smtp_server   = 'smtp.office365.com';
$mail_smtp_user    = 'sce.posgrado@inecol.mx';
$mail_smtp_pass    = '5C3.P0sgr4d0';
$mail_from         = 'sce.posgrado@inecol.mx';
$mail_port         = 587;   // STARTTLS

$mail_to           = 'anibal.sanchez@inecol.mx';
$asunto            = 'Prueba SMTP Outlook (inecol) - ' . date('Y-m-d H:i:s');
$cuerpo_texto      = "Hola,\n\nCorreo de prueba enviado desde el script PHP con la cuenta Outlook sce.posgrado@inecol.mx (smtp.office365.com:587 STARTTLS).\n\nSi recibes esto, la configuración SMTP de Outlook funciona.\n\nFecha: " . date('Y-m-d H:i:s') . "\n\nSaludos.";
$cuerpo_html       = '<html><body style="font-family: sans-serif;">'
    . '<p>Hola,</p>'
    . '<p>Correo de <strong>prueba</strong> enviado desde el script PHP con la cuenta Outlook <code>sce.posgrado@inecol.mx</code> (smtp.office365.com:587 STARTTLS).</p>'
    . '<p>Si recibes esto, la configuración SMTP de Outlook funciona.</p>'
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

/**
 * Envío SMTP con STARTTLS (puerto 587, típico de Office 365/Outlook).
 */
function enviar_smtp_starttls($host, $port, $user, $pass, $from, $to, $raw_message) {
    $errno = 0;
    $errstr = '';
    $fp = @stream_socket_client(
        "tcp://$host:$port",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT
    );
    if (!$fp) {
        return [false, "Conexión fallida: $errstr ($errno)"];
    }
    stream_set_timeout($fp, 15);

    $readLine = function () use ($fp) {
        $line = @fgets($fp, 8192);
        return $line === false ? '' : $line;
    };

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

    $r = $send("STARTTLS");
    if (strpos($r, '220') !== 0 && strpos($r, '250') !== 0) {
        fclose($fp);
        return [false, "STARTTLS rechazado: $r"];
    }

    $crypto = defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')
        ? STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT
        : STREAM_CRYPTO_METHOD_TLS_CLIENT;
    if (!@stream_socket_enable_crypto($fp, true, $crypto)) {
        fclose($fp);
        return [false, "No se pudo activar TLS"];
    }

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

list($ok, $msg) = enviar_smtp_starttls(
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

echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Prueba SMTP Outlook</title></head><body>';
echo '<h1>Prueba de envío SMTP Outlook (Office 365)</h1>';
if ($ok) {
    echo '<p style="color:green;">Correo enviado correctamente a <strong>' . htmlspecialchars($mail_to) . '</strong>.</p>';
    echo '<p>Revisa tu bandeja (y spam) en unos segundos.</p>';
} else {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($msg) . '</p>';
}
echo '<p><small>Servidor: ' . htmlspecialchars($mail_smtp_server) . ':' . $mail_port . ' (STARTTLS)</small></p>';
echo '</body></html>';
