<?php

class Contact extends Eloquent
{

	private $errors;

	protected $fillable = ['first_name', 'last_name', 'email', 'phone'];

	private $rules = [
		'first_name' => 'required|min:2|alpha_dash',
		'last_name' => 'required|min:2|alpha_dash',
		'email' => 'required|email',
		'phone' => 'required|min:10'
	];

	public function user()
	{
		return $this->belongsTo('User');
	}


	public function validate($data)
	{
		$validator = Validator::make($data, $this->rules);

		if($validator->fails()) {
			$this->errors = $validator->errors;

			return false;
		}

		return true;
	}

	public function errors()
	{
		return $this->errors;
	}

}
