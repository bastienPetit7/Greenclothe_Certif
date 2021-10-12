<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = 'cc097213b7ced0fec18e081c0fed3d73'; 

    private $api_key_secret = '40cfc0ae4cf7056a88af0fdabfac5c80'; 

    public function send($to_email, $to_name, $subject, $content )
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "greenclothefamily@gmail.com",
                        'Name' => "Greenclothe"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3219977,
                    'TemplateLanguage' => true,
                    'Subject' => $subject, 
                    'Variables' => [
                        'content' => $content
                       
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success(); 
    }

}