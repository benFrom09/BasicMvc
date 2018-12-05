<?php
namespace Ben09\Core\Mail;



class Mail
{
    public function __construct(string $from) {
        $this->header = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
            
        
    }

    public function format($subject,$message,$from,$to) {
        return '<html><head><title>' . $subject . '</title><head>
                <body>
                <div> '. $message . '</div>
                </body>
                </html>';
    }

    public function send($from,$to,$subject,$message) {
        $_message = $this->format($subject,$message,$from,$to);
        mail($to,$subject,$_message,$this->header);
    }
}