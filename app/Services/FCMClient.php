<?php


namespace App\Services;


use Google_Client;
use Illuminate\Support\Facades\Log;

class FCMClient
{
    public static function send($device_token, $notification, $data = [], $image = null)
    {
        $accessToken = (setting('fire_base_server_key')) ? setting('fire_base_server_key') : self::getAccessToken();
        $data = is_array($data) ? $data : [];  // Ensure $data is an array
        $dataResult = [];
        foreach ($data ?? [] as $key => $val) {
            $dataResult[$key] = (string) $val;
        }
        $to = $device_token->token;
        // dd($to);
        Log::info(json_encode(['data' => $data, 'dataResult' => $dataResult], JSON_UNESCAPED_UNICODE));
        $arr_data = [
            'message' => [
                "token" => $to,
                "notification" => [
                    "title" => 'رساله جديده',
                    'body' => $data,
                    'image' => $image,
                ],
                "data" => $dataResult,
                "android" => [
                    "priority" => "high",
                    'notification' => [
                        'sound' => 'notification.wav',
                    ]
                ],
                "apns" => [
                    "headers" => [
                        "apns-priority" => "5"
                    ],
                    'payload' => [
                        'aps' => [
                            'mutable-content' => 1,
                            'sound' => 'notification.wav'
                        ]
                    ]
                ],
            ]
        ];

        $dataString = json_encode($arr_data);
        Log::info($dataString);
        // Log::info($dataString);
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer $accessToken",

        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/son-7f11f/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $result = curl_exec($ch);
        $decodedResult = json_decode($result, true);
        // dd($data);
        if (isset($decodedResult['error'])) {
            if ($decodedResult['error']['code'] == 401 && $decodedResult['error']['status'] == "UNAUTHENTICATED") {
                $accessToken = self::getAccessToken();
                return self::send($device_token, $notification, $data, $image);
            }
        }
        Log::info($result);
        return $decodedResult;
    }

    private static function getAccessToken(): string
    {
        $data = [
            "type" => "service_account",
            "project_id" => "e-learning-31857",
            "private_key_id" => "4fa25bb0bfca8e838c309ebd3f2c66dbc2b2214d",
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDqGAK8vmyaSroK\nZPYPOIsoNCLAlge6tMrEHw/f2SpQX5UIDrMIiQmak1jhJ4LTlY1cMjlGYzKoZTyc\nH85agds5KJLrCu0HeRRxPp2sxmYQhNigDbpWjXf0Nl+wG55AyjOeGsAeFA4Fm8ZR\ndvOr/lHlx6T553AsRTVEOl3J5OSEF0Nn5wFtle4QWg2/HsHWXUaNINTIkFf3fYfN\nXtKN3S/gnEHvp5YaMnlkURYT84FjzbFKYsBAwbwDkaKTm83YGdfkRTm+fA3xXF+u\nCj2CV9Ukonan+t1wwTGunlWHEwNYARPCSQ3JO3RY8d3QyfoROWrrMts6dZ/RykBf\nH5FcEtp9AgMBAAECggEABATIN9G0M7oq002R+T40eDiTMQMLfDWyMbVLFtQuf/6V\nNr1Et/pK2PxpSo3vBIYj8ZxP+GZw12enOcl7bFTEgXZ7EOkwCPBzQVGTgmAEsUAM\nTEOtyAcHjqU1vuRJV5AcgOGM0zLKy7BH+6WcMf7lw3STTRtD8u13zNexGFlDO+D2\nPTallDGBbgEKAZgIjjK+58wCPDvr0+M51KicYlbpZaL3vcNILhTVsEhKaUl/G6AP\njc3Ef2AFBFbuGt1Om6fzbl00rSAT5i64liI+uAfH5JM/J6biLVkXRQZPb2KrNbbW\nLNnCtv5cNowsrbzg8S/CbesyRbhkdeeac0oky6yv4QKBgQD3gZZZrnEYhrrGi/vY\nLO+Mw1+NOhUo2cbWo8oeViPbExRgs2NtLNdfnkMd2ILD42RoRZ8x7rawenwydKuE\ne6WKYLE05jHlsciQji4ZSeMnrMAW1tQlXlvWGUQOGLsOtAFZfJmAPLFeidGJwV1m\neJA7a68CL41l3OJnOaWuNtm17QKBgQDyIJdvbyCxsppZ5JOwvXcIBSFX4mAwq80F\nzS4SvWLDWCZ8zgiW8R+JiOIbkIulgDXaSSHBIJC3r6XTT31qxPKA1Ybgm1UGXeTu\naXFcWCIACJGTzPtUgKCa/gkvn+yErzxDMW7VyMF17wYcEpSVNO+M9fAU1wGrexd0\nHCh0+cAk0QKBgQDIblijJ3DOu8xlHNdFqJ4VD+JBK9gWzMUI7HqxNnCy6DCIXr0V\nnEqNVExlzv+WQn79MeRJO1cWcxpAgdqj3r2f4c2fWQrvR5lz9q++KueZKXwlArOp\nz0/vgWZrQ/u3XG37Wbu07XF1bYYSWFSatueWNw3yZy/KXaW6kiRpgGGtwQKBgE3Y\n2reSRDG92dCTJEUL9YxXkevetcyQQB/gYzLVPz7NRbqUx8A4EEq4/vGb3Lo+aZIg\nN0EPxle4mplBEnLUlZ+Eh5QJfSHJ6IQa1L66+1uFZcDeg+QcYwbSLIPqaDIU4Uw9\nRYRowoK3cgBunOUIGwj4PdOFeVz3+4dyUjOh5PwxAoGABpl5zdBuhftfhPqeE2B9\nr7dRsMJKOXnwsc3O5jfLiUc8JweufEWwNXoVwWYV0nyhszs4Aj6pRa+UESq/9GTc\n6GNgyHIliYxfcyE4LhvZVkf/CzhPBNe5bZemBHoHpWudBx4t2wjEQjQIr19FoJPf\nm0q0Xa50TVI6qcFo35aV8LQ=\n-----END PRIVATE KEY-----\n",
            "client_email" => "firebase-adminsdk-fbsvc@e-learning-31857.iam.gserviceaccount.com",
            "client_id" => "109203452552108972569",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40e-learning-31857.iam.gserviceaccount.com",
            "universe_domain" => "googleapis.com"
        ];

        $client = new Google_Client();
        $client->setAuthConfig($data);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithAssertion();
        }

        $accessToken = $client->getAccessToken();
        setting([
            'fire_base_server_key' => $accessToken['access_token']
        ])->save();
        return $accessToken['access_token'];
    }
}
