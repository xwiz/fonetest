<?php

class Contacts extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
   'name'=>'required|alpha|min:3',
   'number'=>'required|alpha|max:11|min:11',
   );
}
