<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars($_POST['name'] ?? '');
    $email   = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $body    = htmlspecialchars($_POST['message'] ?? '');

    if ($name && $email && $subject && $body) {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.correousado.com'; // Cambia esto
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tu_email@correo.com'; // Cambia esto
            $mail->Password   = 'app_password'; // Cambia esto
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinatario y contenido
            $mail->setFrom($email, $name);
            $mail->addAddress('corre_de_llegada@corrreo.com'); // Cambia esto
            $mail->Subject = $subject;
            $mail->Body    = "De: $name <$email>\n\n$body";

            $mail->send();
            $message = '<div class="success">¡Mensaje enviado correctamente!</div>';
        } catch (Exception $e) {
            $message = '<div class="error">Error al enviar: ' . $mail->ErrorInfo . '</div>';
        }
    } else {
        $message = '<div class="error">Completa todos los campos.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #18181b;
            color: #e5e7eb;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .contact-form {
            background: #27272a;
            padding: 2rem 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 24px #000a;
            width: 100%;
            max-width: 400px;
        }
        .contact-form h2 {
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: #fff;
            text-align: center;
        }
        .contact-form label {
            display: block;
            margin-bottom: .5rem;
            font-size: .95rem;
            color: #a1a1aa;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: .75rem;
            margin-bottom: 1.2rem;
            border: none;
            border-radius: .5rem;
            background: #3f3f46;
            color: #fff;
            font-size: 1rem;
            transition: background .2s;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            background: #52525b;
            outline: none;
        }
        .contact-form button {
            width: 100%;
            padding: .8rem;
            background: linear-gradient(90deg, #6366f1, #3b82f6);
            color: #fff;
            border: none;
            border-radius: .5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }
        .contact-form button:hover {
            background: linear-gradient(90deg, #3b82f6, #6366f1);
        }
        .success, .error {
            padding: .8rem;
            border-radius: .5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .success { background: #22c55e33; color: #22c55e; }
        .error { background: #ef444433; color: #ef4444; }
    </style>
</head>
<body>
    <form class="contact-form" method="post" autocomplete="off">
        <h2>Contacto</h2>
        <?= $message ?>
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" required maxlength="60">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required maxlength="80">

        <label for="subject">Asunto</label>
        <input type="text" id="subject" name="subject" required maxlength="100">

        <label for="message">Mensaje</label>
        <textarea id="message" name="message" rows="5" required maxlength="1000"></textarea>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>