<?php

use SilverStripe\SiteConfig\SiteConfig;

class MGNotif{

    static $url = "http://mgbix.id:82/mgnotifv2/api/storeNotif";

    static $app_id = 21;

    static $wa_id = 12;

    static $email_id = 8;

    static function sendWA($content, $recipient, $subject = "Approval Baru"){
        $siteconfig = SiteConfig::current_site_config();

        $data = [
            'AppID' => 2,
            'Recipients' => $recipient,
            'SendVia' => 'Wa',
            'Subject' => $subject,
            'Message' => $content,
            'InstanceID' => 20
        ];

        return self::generatePost($data);
    }

    static function sendEmail($content, $recipient, $subject = "Test Email"){
        $siteconfig = SiteConfig::current_site_config();

        $data = [
            'AppID' => 2,
            'Recipients' => $recipient,
            'SendVia' => 'Email',
            'Subject' => $subject,
            'Message' => $content,
            'InstanceID' => 3
        ];


        return self::generatePost($data);
    }

    static function generatePost($data){
        $siteconfig = SiteConfig::current_site_config();
        $data = http_build_query($data);
        $option = stream_context_create(['http' => [
            'header' => "Content-type: application/x-www-form-urlencoded",
            'method' => 'POST',
            'content' => $data
        ],
        ]);

        $result = file_get_contents("http://mgbix.id:82/mgnotifv2/api/storeNotif", true, $option);

        return $result;
    }
}