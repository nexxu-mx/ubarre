<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye PHPMailer (ajusta la ruta según tu proyecto)
require 'vendor/autoload.php';

/**
 * Sustituto de mail() usando PHPMailer con SMTP
 *
 * @param string $to       Dirección del destinatario
 * @param string $subject  Asunto del correo
 * @param string $message  Contenido (HTML o texto plano)
 * @param string $headers  Cabeceras (From, Reply-To, CC, etc.)
 * @return bool
 */
function smail($to, $subject, $message, $headers = '')
{
    $mail = new PHPMailer(true);
    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';   // Servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'notificaciones@satya-studio.com'; // Usuario SMTP
        $mail->Password   = 'Satya2025*';          // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;


        // Parsear cabeceras (para ser compatible con mail())
        $fromSet = false;
        if (!empty($headers)) {
            $lines = explode("\n", $headers);
            foreach ($lines as $line) {
                $line = trim($line);
                if (stripos($line, 'From:') === 0) {
                    $from = trim(substr($line, 5));
                    $mail->setFrom($from);
                    $fromSet = true;
                } elseif (stripos($line, 'Reply-To:') === 0) {
                    $reply = trim(substr($line, 9));
                    $mail->addReplyTo($reply);
                } elseif (stripos($line, 'Cc:') === 0) {
                    $ccs = explode(',', substr($line, 3));
                    foreach ($ccs as $cc) {
                        $mail->addCC(trim($cc));
                    }
                } elseif (stripos($line, 'Bcc:') === 0) {
                    $bccs = explode(',', substr($line, 4));
                    foreach ($bccs as $bcc) {
                        $mail->addBCC(trim($bcc));
                    }
                }
            }
        }

        // Si no se especificó From, asignar uno por defecto
        if (!$fromSet) {
            $mail->setFrom('notificaciones@satya-studio.com', 'Satya');
        }

        // Destinatario
        $mail->addAddress($to);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        return $mail->send();
    } catch (Exception $e) {
        error_log("Error enviando correo: {$mail->ErrorInfo}");
        return false;
    }
}
