<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\FormData;
use Google_Client;
use Google_Service_Sheets;
use HubSpot;

class GrabCsvController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
    
    public function expandHomeDirectory($path)
    {
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
    public function getClient()
    {
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
            if (!file_exists(dirname($credentialsPath))) {
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
    
    public function index($id = '')
    {
        if(!$id){
            return;
        }
        // $response = HubSpot::forms()->getById('454a0ba9-449a-4e10-aeda-e8116b02e4b2');
        // dd($response);exit;
        define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
        define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
        define('CLIENT_SECRET_PATH', app_path() . '/client_secret.json');
        // If modifying these scopes, delete your previously saved credentials
        // at ~/.credentials/sheets.googleapis.com-php-quickstart.json
        define('SCOPES', implode(' ', array(
            Google_Service_Sheets::SPREADSHEETS_READONLY,
        )));
        $client  = $this->getClient();
        $service = new Google_Service_Sheets($client);
        
        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '104x2cj6Sf0alMZj69hZTwwVlbmmeXYz3vyTT022uxAw';
        $range         = 'A2:M23';
        // $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        // $values = $response->getValues();
        
        // $response = $service->spreadsheets->get($spreadsheetId);
        // $response_sheets = $response->getSheets();
        // foreach ($response_sheets as $response_sheet){
        //     $response_data[] = $response_sheet->getData();
        // }
        $response = $service->spreadsheets_values->get($id, 'A2:Z');
        // dd($id, $response->values);exit;
        // $response =
        $portal_id               = '2950617';
        // $form_guid               = '454a0ba9-449a-4e10-aeda-e8116b02e4b2';
        $google_doc_to_form_guid = [
            '104x2cj6Sf0alMZj69hZTwwVlbmmeXYz3vyTT022uxAw' => '454a0ba9-449a-4e10-aeda-e8116b02e4b2', // Jenkins for PCF
            '14anTELce-L5WIOfh28lsy5DnnXhoM4LPJGtLNHFpVs8' => 'ae50b393-62e3-43b4-b78d-fa99f10fb77b', // AWS S3 for PCF
            '1M2AWLrjF_c2CvMMqn5z1JkrhByQly0BGywfePqa9STw' => '009d03a1-d5c6-45e1-9e06-1e750f2ffc5d', // Cassandra for PCF
            '1STHWs6T8Ba_yO02NYsrPHsXiG2gTtCYe1ORoW3q3gk4' => 'f3d3658f-ea0a-4799-810d-c905d953752d', // Log Search for PCF
            '1HrQFE2es9pOZLbL6zZZ6TkwBh02NtCCzarCdWPcAddo' => '8bf64175-a8b9-4a32-a0ef-a06b2ead168a', // Elasticsearch for PCF
            '1zFwbOtYrY-ZHonNJh6egsR_AHIEUKvdmxNUW545QlMg' => '9aefc59b-9041-4304-8a65-05aa2c13a55d', // Heartbeat for PCF
        ];
        
        foreach ($response->values as $form_data) {
            if(strtolower($form_data[9]) !== 'software'){
                continue;
            }
            $form        = [
                'email'        => $form_data[0],
                'firstname'    => $form_data[1],
                'lastname'     => $form_data[2],
                'organization' => $form_data[3],
                'product_file' => $form_data[7],
                'file_type'    => $form_data[9],
                'release'      => $form_data[10],
            ];
            $hubspot_req = HubSpot::forms()->submit($portal_id, $google_doc_to_form_guid[$id], $form);
            // echo"<pre>";
            // var_dump($hubspot_req->response->statusCode);
            // dd($hubspot_req, gettype($hubspot_req), $hubspot_req);
            // dd($hubspot_req->response);
            // exit;
            
            $form_data = FormData::create([
                'email'         => $form_data[0],
                'first_name'    => $form_data[1],
                'last_name'     => $form_data[2],
                'organization'  => $form_data[3],
                'product_file'  => $form_data[7],
                'file_type'     => $form_data[9],
                'release'       => $form_data[10],
                'google_doc_id' => $google_doc_to_form_guid[$id],
            ]);
        }
        echo "<pre>";
        var_dump($response->values);
        exit;
        
        
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $service = new Google_Service_Sheets($client);
        
        $spreadsheetId = '157JP5drsBTda98qfRn8pkgjUrSa93dUlWCYw9TTLOcU';
        $range         = 'A2:M23';
        $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values        = $response->getValues();
        
        dd($values);
        exit;
        // Get the API client and construct the service object.
        $client = $this->getClient();
        dd($client);
        exit;
        $service = new Google_Service_Sheets($client);
        
        
        // $posts = FormData::get();
        // dd(env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION'));exit;
        $mail__poet       = '157JP5drsBTda98qfRn8pkgjUrSa93dUlWCYw9TTLOcU';
        $mail__poet_sheet = 'Sheet1';
        $csv              = '104x2cj6Sf0alMZj69hZTwwVlbmmeXYz3vyTT022uxAw';
        $csv_sheet        = 'altoros-jenkins-for-pcf-downloads.csv';
        
        Sheets::setService(Google::make('sheets'));
        Sheets::spreadsheet($mail__poet);
        $values = Sheets::sheet($mail__poet_sheet);
        $d      = $values->all();
        dd($values, $d);
        // var_dump($values);
        // exit;
        // return View::make('index')->with('posts', $posts);
    }
}
