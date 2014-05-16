<?php

class ContactsController extends BaseController
{

    /**
     * Default constructor with authentication filters and csrf check
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only' => array(
                'import',
                'view',
                'groups',
                'create',
                'home')));
    }

    /**
     * Index/Home page for the user contacts
     * @return Response
     */
    public function home()
    {
        Input::get('page');
        $contacts = Contacts::where('user_id', '=', Auth::user()->id)->paginate(10);        
        $total = $contacts->getTotal();
        return View::make('contacts.view')->with('contacts', $contacts)->with('total', $total);
    }

    /**
     * Contacts Groups page to allow user to create contact
     * groups for bulk note sending 
     * @return Response
     */
    public function groups()
    {
        $contacts = Contacts::where('user_id', '=', Auth::user()->id)
        ->paginate(10);
        return View::make('contacts.groups')->with('contacts', $contacts);
    }

    /**
     * Creates a contact group
     */
    public function groupCreate()
    {

    }

    /**
     * Contact view page to list all user contacts in paginated form
     * @return Response
     */
    public function view()
    {
        return View::make('contacts.view');
    }
    
    /**
     * Save a new contact especially after sending a fonenote
     * @return Redirect response
     */
    public function save()
    {
        $number = Input::get('number');
        $name = Input::get('name');
        $user_id = Auth::user()->id;
        $contact = New Contacts();
        $contact->user_id = $user_id;
        $contact->contact_name = $name;
        $contact->contact_number = $number;
        $contact->save();
        $lastnote = Session::get('note');
        if($lastnote !== null)
        {
            $lastnote->contact_id = $contact->id;
            $lastnote->save();
            Session::remove('note');
        }
        return Redirect::to('contacts')->with('success', "Your contact has been saved successfully.");
    }

    public function upload()
    {
        $file = Input::file('file');
        $destinationPath = 'uploads/' . str_random(8);
        $filename = $file->getClientOriginalName();
        $uploadSuccess = Input::file('file')->move($destinationPath, $filename);
        $num = 0;
        $id = Auth::user()->id;
        $contacts = array();
        if ($uploadSuccess) {
            if (($handle = fopen($destinationPath . '/' . $filename, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $contacts[] = array(
                    'user_id' => $id,
                    'contact_name' => $data[0],
                    'contact_number' => $data[1]);
                    $num++;
                }
            }
            fclose($handle);
            $contacts_db = new Contacts();
            $contacts_db->insert($contacts);
            return Redirect::to('contacts')->with('success', "Upload successful. $num contacts have been imported successfully.");
        } else {
            return Redirect::to('contacts/import')->with('error',
                'Failed to import contacts. Please try again.');
        }
    }

    public function import()
    {
        session_start();
        $client = OAuth::consumer('Google');
        $auth_uri = $client->getAuthorizationUri(array('scope' => array('http://www.google.com/m8/feeds/'),
                'redirect_uri' => url('contacts/import')));
        $code = Input::get('code');
        if (!empty($code)) {
            $email = Auth::user()->email;
            $url = 'http://www.google.com/m8/feeds/contacts/default/full?max-results=50';
            $client->requestAccessToken($code);
            $xmlresponse = $client->request($url);
            if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr
                ($xmlresponse, 'Error ')) > 0))
                //At times you get Authorization error from Google.
                {
                return View::make('contacts.import')->with('error',
                    'Oops, something went wrong. Please try again.');
            }
            //$xml=  new SimpleXMLElement($xmlresponse);
            $xml = simplexml_load_string($xmlresponse);

            $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
            foreach ($xml->entry as $entry) {
                foreach ($entry->xpath('gd:phoneNumber') as $e) {
                    $num = '';
                    if($e->attributes != null){
                    // Remove any non-digit character
                    $num = (string )$e->atributes->uri;
                    $num = preg_replace('|[^0-9]|', '', $num);
                    // Format number to international standard
                    if (preg_match('|^0|', $num))
                        $num = '234' . substr($to, 1);
                    }
                    
                    $contacts[] = array('user_id'=> Auth::user()->id,'contact_name' => $entry->title, 'contact_number' => $num);
                    //$contacts[] = array('user' => $entry->title, 'contact' => $num);
                }
            }
            $contacts_db = new Contacts();
            $total = count($contacts);
            $contacts_db->insert($contacts);
            return Redirect::to('contacts')->with('success', "Upload successful. $total contacts have been imported successfully.");
        } else {
            return View::make('contacts.import')->with('google', $auth_uri);
        }
    }
}

?>