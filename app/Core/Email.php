<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    public static function send($to, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do Servidor baseadas no .env
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USER'];
            $mail->Password   = $_ENV['MAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];
            $mail->CharSet    = 'UTF-8';

            // Destinatários
            $mail->setFrom($_ENV['MAIL_USER'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($to);

            // Conteúdo
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }

    public static function getResetTemplate($nome, $codigo) {
        return "
        <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #eee; border-radius: 15px; padding: 20px;'>
            <div style='text-align: center; border-bottom: 1px solid #fce4ec; padding-bottom: 20px;'>
                <h2 style='color: #e64a85;'>DC Balões</h2>
            </div>
            <div style='padding: 20px;'>
                <p>Olá, <strong>{$nome}</strong>,</p>
                <p>Recebemos uma solicitação para redefinir a senha da sua conta administrativa.</p>
                <p style='text-align: center; margin: 30px 0;'>
                    <span style='background: #f8f9fa; border: 2px dashed #e64a85; padding: 15px 30px; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #333;'>
                        {$codigo}
                    </span>
                </p>
                <p style='font-size: 14px; color: #666;'>Este código é válido por 24 horas. Se você não solicitou esta alteração, ignore este e-mail por segurança.</p>
            </div>
            <div style='text-align: center; font-size: 12px; color: #999; margin-top: 20px;'>
                &copy; " . date('Y') . " DC Balões - Sistema de Gestão
            </div>
        </div>
        ";
    }
}