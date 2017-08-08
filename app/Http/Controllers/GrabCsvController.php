<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\FormData;
use Google_Service_Sheets;
use Google_Client;

class GrabCsvController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
    
    public function expandHomeDirectory($path) {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }
    
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    public function getClient() {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        
        // Load previously authorized credentials from a file.
        $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            
            // Store the credentials to disk.
            if(!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);
        
        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
    
    public function index()
    {
        define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
        define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
        define('CLIENT_SECRET_PATH', app_path() . '/client_secret.json');
        // If modifying these scopes, delete your previously saved credentials
        // at ~/.credentials/sheets.googleapis.com-php-quickstart.json
        define('SCOPES', implode(' ', array(
                Google_Service_Sheets::SPREADSHEETS_READONLY)
        ));
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setDeveloperKey('AIzaSyAmETex6HSPwwAdu_ypl0qQyQawcZExS7E');
        $service = new Google_Service_Sheets($client);
    
        $spreadsheetId = '157JP5drsBTda98qfRn8pkgjUrSa93dUlWCYw9TTLOcU';
        $range = 'Class Data!A2:E';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        
        dd($values);exit;
        // Get the API client and construct the service object.
        $client = $this->getClient();
        dd($client);exit;
        $service = new Google_Service_Sheets($client);
        
        
        
        
        
        
        
        
        // $posts = FormData::get();
        // dd(env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION'));exit;
        $mail__poet = '157JP5drsBTda98qfRn8pkgjUrSa93dUlWCYw9TTLOcU';
        $mail__poet_sheet = 'Sheet1';
        $csv = '104x2cj6Sf0alMZj69hZTwwVlbmmeXYz3vyTT022uxAw';
        $csv_sheet = 'altoros-jenkins-for-pcf-downloads.csv';

        Sheets::setService(Google::make('sheets'));
        Sheets::spreadsheet($mail__poet);
        $values = Sheets::sheet($mail__poet_sheet);
        $d =         $values->all();
        dd($values, $d);
        // var_dump($values);
        // exit;
        // return View::make('index')->with('posts', $posts);
    }
}
