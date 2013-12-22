<?php

class Notes extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
   'voice-note'=>'required|alpha|min:3',
   );
}
