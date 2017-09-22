<?php

namespace App;

use App\Api\GoogleClient;
use Google_Service_Drive;
use Illuminate\Database\Eloquent\Model;

class GoogleDoc extends Model
{
    public static $RANGE = 'A2:Z';
    
    public static $PUSH_TO_HS = ['PUSHED' => 1, 'NOT_PUSHED' => 0];
    
    public function __construct()
    {
        $this->doc_range = GoogleDoc::$RANGE;
    }
    
    public function form_data()
    {
        return $this->hasMany(FormData::class);
    }
    
    public function exclusions()
    {
        return $this->hasMany(Exclusions::class, 'exc_google_doc_id');
    }
    
    public function hubspot_form()
    {
        return $this->belongsTo(HubspotForm::class);
    }
    
    static function checkRule($index, $rule, $data)
    {
        $result = false;
        switch ($rule['type']) {
            case '=':
                $result = ($data[$index] == $rule['value']);
                break;
            case '!=':
                $result = ($data[$index] != $rule['value']);
                break;
            case '>':
                $result = ($data[$index] > $rule['value']);
                break;
            case '<':
                $result = ($data[$index] < $rule['value']);
                break;
        }
        
        return $result;
    }
    
    public function grab()
    {
        if (!$this->doc_id) {
            exit;
        }
        $client  = GoogleClient::get_instance();
        $service = new Google_Service_Drive($client->client);
        
        $optParams          = array(
            'q' => "'$this->doc_id' in parents and trashed=false and mimeType='text/csv'",
        );
        $deny_organizations = ['altoros', 'avarteq', 'ecs'];
        $count              = 0;
        $files              = $service->files->listFiles($optParams);
        foreach ($files as $file) {
            $response        = $service->files->get($file->id, array('alt' => 'media'));
            $content         = $response->getBody()->getContents();
            $lines           = explode(PHP_EOL, $content);
            $form_data_array = [];
            foreach ($lines as $line) {
                $form_data_array[] = str_getcsv($line);
            }
            $names = [];
            foreach ($form_data_array[0] as $key => $field_name) {
                $names[str_replace(' ', '_', strtolower(trim($field_name)))] = $key;
            }
            if (empty($form_data_array[$this->doc_range][0])) {
                return $count;
            }
            $form_data_array  = array_slice($form_data_array, $this->doc_range);
            $exclusions_rules = [];
            $fillable         = (new FormData)->getFillable();
            foreach ($this->exclusions()->get() as $exclusion) {
                $exclusions_rules[$names[$exclusion->google_doc_field]][] = [
                    'value' => $exclusion->value,
                    'type'  => $exclusion->exclusions_type()->first()->type,
                ];
            }
            foreach ($form_data_array as $key => $form_data) {
                
                if (!$form_data[0]) {
                    $this->doc_range += $key;
                    $this->save();
                    continue;
                }
                // $continue = false;
                if ((strtolower($form_data[9]) !== 'software') || (in_array(strtolower($form_data[3]),
                        $deny_organizations))
                ) {
                    continue;
                }
                $mas[] = $form_data;
                // if ($exclusions_rules) {
                //     foreach ($exclusions_rules as $index => $rules) {
                //         if ($continue) {
                //             break;
                //         }
                //         foreach ($rules as $rule) {
                //             $continue = GoogleDoc::checkRule($index, $rule, $form_data);
                //             $mas222[] = $continue;
                //             // dd($rule, $continue, $index, $form_data);
                //             if ($continue) {
                //                 break;
                //             }
                //         }
                //     }
                // }
                // if (!$continue) {
                //     $mas[] = $form_data;
                // }
                
                if ((strtolower($form_data[9]) !== 'software') || (in_array(strtolower($form_data[3]),
                        $deny_organizations))
                ) {
                    continue;
                }
                // $form = [
                //     'email'         => $form_data[0],
                //     'firstname'     => $form_data[1],
                //     'lastname'      => $form_data[2],
                //     'organization'  => $form_data[3],
                //     'product_file'  => $form_data[7],
                //     'file_type'     => $form_data[9],
                //     'release'       => $form_data[10],
                //     'download_date' => $form_data[11],
                //     'hs_persona'    => 'persona_8',
                // ];
                // $hubspot_req = HubSpot::forms()->submit($this->hubspot_form()->first()->portal_id,
                //     $this->hubspot_form()->first()->form_guid, $form);
                
                FormData::create([
                    'email'         => $form_data[0],
                    'first_name'    => $form_data[1],
                    'last_name'     => $form_data[2],
                    'organization'  => $form_data[3],
                    'product_file'  => $form_data[7],
                    'file_type'     => $form_data[9],
                    'release'       => $form_data[10],
                    'download_date' => $form_data[11],
                    'google_doc_id' => $this->id,
                    // 'hs_status_code' => $hubspot_req->getStatusCode(),
                ]);
                $count++;
            }
        }
        
        return $count;
    }
}
