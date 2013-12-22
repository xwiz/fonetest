<?php

class NotesController extends BaseController
{

    /**
     * Default constructor with authentication and csrf filters 
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('create','sent')));
    }

    /**
     * Display the Notes home.
     *
     * @return Response
     */
    public function home()
    {
        return $this->sent();
    }

    /**
     * Creates a quick fonenote with input text and number
     *
     * @return Response
     */
    public function quickNote()
    {
        $note = new Notes();
        $id = Auth::user()->id;
        $number = Input::get('contact');
        $nid = Contacts::whereRaw("user_id = $id and contact_number = $number")->first()->id;
        $note->contact_id = $nid;
        $voice_text = Input::get('voice-text');
        if ($voice_text && $number) {
            require ('lib/fonenode.php');
            $fonenode = new fonenode('2f46146d', 'ovU0lIiwNcyC0zJW');

            $to = preg_replace('|[^0-9]|', '', $number);
            if (preg_match('|^0|', $number))
                $number = '234' . substr($number, 1);
            
            $json = $fonenode->quick_call($number, $voice_text);            
            $note->user_id = $id;
            $note->content = $voice_text;
            $note->content_type = 'text';
            $note->resource_id = $json['fired'][0]['id'];
            $note->save();
            return Redirect::to('notes/sent')->with('success',
                'Your voice note has been sent. Check your sent notes for delivery details.');
        }
        else {
            $user_contacts = Contacts::where('user_id', '=', Auth::user()->id)->get();
            return View::make('notes.create')->with('contacts', $user_contacts)->withInput();
        }
    }
    /**
     * Creates a fonenote with specified text or recorded audio url
     *
     * @return Response
     */
    public function create()
    {
        $voice_text = Input::get('voice-text');
        $audio = Input::get('voice-url');
        $number = Input::get('number');
        $note = new Notes();
        $id = Auth::user()->id;
        if($audio != "")
        {
            //if is audio set voice_text to url of audio instead
            $voice_text = url($audio);
        }
        if(Input::get('user-type') == "contact")
        {
            //retrieve contact number if usertype contact
            $number = Input::get('contact');
            $nid = Contacts::whereRaw("user_id = $id and contact_number = $number")->first()->id;
            $note->contact_id = $nid; 
        }
        else{
            $note->contact_id = 0;
        }
        if ($voice_text && $number) {
            require ('lib/fonenode.php');
            $fonenode = new fonenode('2f46146d', 'ovU0lIiwNcyC0zJW');

            $to = preg_replace('|[^0-9]|', '', $number);
            // Format number to international standard
            if (preg_match('|^0|', $number))
                $number = '234' . substr($number, 1);
            
            
            // Now lets call user using fonenode's quick call API
            // http://fonenode.com/docs#calls-quick
            $json = $fonenode->quick_call($number, $voice_text);            
            //$status = $fonenode->getStatusCode();
            //Save the sent note!
            $note->user_id = $id;
            $note->content = $voice_text;
            if($audio != ""){
                $note->conent_type = 'audio';
            }
            else
            {
                $note->content_type = 'text';
            }
            $note->resource_id = $json['fired'][0]['id'];
            $note->save();
            Session::set('note_id', $note->id);
            if (Input::get('user-type') == "number") {
                return View::make('contacts.save')->with('data', array('success' =>
                        'Your voice note has been sent. Check your sent notes for delivery details.',
                        'number' => $number));
            }

            return Redirect::to('notes/sent')->with('success',
                'Your voice note has been sent. Check your sent notes for delivery details.');
        } else {
            $user_contacts = Contacts::where('user_id', '=', Auth::user()->id)->get();
            return View::make('notes.create')->with('contacts', $user_contacts);
        }
    }
    
    /**
     * Handle audio blob uploads.
     * Need to use flash to convert wav to mp3 in future
     * @return json response to indicate uploaded file url 
     */
    public function upload()
    {
        //need to look more into laravel to get this right. Temporary solution at /audio/receive.php
    }
    
    /**
     * Show sent notes
     * @return Response
     */
    public function sent()
    {
        $notes = Notes::where('notes.user_id', '=', Auth::user()->id)
        ->join('contacts', 'contact_id', '=', 'contacts.id')
        ->paginate(15);
        
        require ('lib/fonenode.php');
        $fonenode = new fonenode('2f46146d', 'ovU0lIiwNcyC0zJW');
        $calls = $fonenode->list_calls();
        $calls = $calls['data'];
        $contacts = Contacts::where('user_id', '=', Auth::user()->id)->get();
        return View::make('notes.sent')->with('data',
        array('notes' => $notes, 'contacts' => $contacts, 'calls' => $calls));
    }
    
    /**
     * Display the note create form with the specified notes draft id
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //get draft details
        return View::make('notes.create')->with('draft', $draft);
    }

    /**
     * Edit a apsecifed note draft
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return View::make('notes.edit');
    }
}
