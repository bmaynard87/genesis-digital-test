<?php

use jyggen\Curl;

class ContactsController extends \BaseController {

	public function index()
	{
		$user = Auth::user();
		$user->load('contacts');

		return View::make('contacts.index', [
			'user' => $user
		]);
	}

	public function store()
	{
		$contact = new Contact;

		$validation = $this->validateContact(Input::all());

		if($validation->fails()) {
			return (String) View::make('common.modal_errors', ['errors' => $validation->errors()]);
		}

		Curl::post($this->getAcUrl('contact_add'), [
			'first_name'      => Input::get('first_name'),
			'last_name'       => Input::get('last_name'),
			'email'           => Input::get('email'),
			'p[1]'            => 1
		]);

		$response = Curl::get($this->getAcUrl('contact_view_email', ['email' => Input::get('email')]));
		$content = unserialize($response[0]->getContent());

		$contact = new Contact;

		$contact->first_name = Input::get('first_name');
		$contact->last_name = Input::get('last_name');
		$contact->email = Input::get('email');
		$contact->phone = Input::get('phone');
		$contact->ac_id = $content['id'];

		$custom_fields = array();

		//make sure custom fields are next to each other
		foreach(Input::except('_token') as $key => $val) {
			if(strpos($key, 'custom_field_') !== false && ! empty($val)) {
				$custom_fields []= $val;
			}
		}

		$contact->custom_field_1 = isset($custom_fields[0]) ? $custom_fields[0] : '';
		$contact->custom_field_2 = isset($custom_fields[1]) ? $custom_fields[1] : '';
		$contact->custom_field_3 = isset($custom_fields[2]) ? $custom_fields[2] : '';
		$contact->custom_field_4 = isset($custom_fields[3]) ? $custom_fields[3] : '';
		$contact->custom_field_5 = isset($custom_fields[4]) ? $custom_fields[4] : '';

		$contact->user()->associate(Auth::user());

		$contact->save();

		return (String) View::make('common.messages', ['messages' => ["Contact added!"]]);

	}

	public function update($id)
	{
		if($id != Auth::id()) {
			return;
		}

		$validation = $this->validateContact(Input::all());

		if($validation->fails()) {
			return (String) View::make('common.modal_errors', ['errors' => $validation->errors()]);
		}

		$contact = Contact::find($id);

		$contact->first_name = Input::get('first_name');
		$contact->last_name = Input::get('last_name');
		$contact->email = Input::get('email');
		$contact->phone = Input::get('phone');
		$contact->ac_id = Input::get('ac_id');

		$custom_fields = array();

		//make sure custom fields are next to each other
		foreach(Input::except('_token') as $key => $val) {
			if(strpos($key, 'custom_field_') !== false && $val) {
				$custom_fields []= $val;
			}
		}

		$contact->custom_field_1 = isset($custom_fields[0]) ? $custom_fields[0] : '';
		$contact->custom_field_2 = isset($custom_fields[1]) ? $custom_fields[1] : '';
		$contact->custom_field_3 = isset($custom_fields[2]) ? $custom_fields[2] : '';
		$contact->custom_field_4 = isset($custom_fields[3]) ? $custom_fields[3] : '';
		$contact->custom_field_5 = isset($custom_fields[4]) ? $custom_fields[4] : '';

		Curl::post($this->getAcUrl('contact_edit'), [
			'id'              => Input::get('ac_id'),
			'first_name'      => Input::get('first_name'),
			'last_name'       => Input::get('last_name'),
			'email'           => Input::get('email'),
			'p[1]'            => 1
		]);

		$contact->save();

		return (String) View::make('common.messages', ['messages' => ["Contact updated!"]]);
	}

	public function destroy($id)
	{
		if($id != Auth::id()) {
			return;
		}

		$contact = Contact::find($id);

		$name = ucwords("{$contact->first_name} {$contact->last_name}");

		$contact->delete();

		Curl::get($this->getAcUrl('contact_delete', ['id' => $contact->ac_id]));

		return (String) View::make('common.messages', ['messages' => "$name has been deleted."]);
	}

	function getAcUrl($action, $extra_params = array()) {
		$url = "https://brandonmaynard.api-us1.com/admin/api.php?api_key=666e406c4321e06c0fe94bb1ff233ccd023de9610a99241dd688f2b0f1ab2c8a16af1a6a&api_action=$action&api_output=serialize";

		if($extra_params) {
			foreach($extra_params as $key => $val) {
				$url .= "&$key=$val";
			}
		}

		return $url;
	}

	public function search()
	{
		$contacts = Contact::where(function($query) {
			$search = Input::get('search');

			$query->where('last_name', 'like', "%$search%");
			$query->orWhere('email', 'like', "%$search%");
			$query->orWhere('phone', 'like', "%$search%");
		})->where('user_id', '=', Auth::id())->get();

		if(count($contacts) > 0) {
			return (String) View::make('contacts.table', ['contacts' => $contacts]);
		}
	}

	public function fieldData($id)
	{
		$contact = Contact::find($id);

		return Response::json([
			'first_name' => $contact->first_name,
			'last_name' => $contact->last_name,
			'email' => $contact->email,
			'phone' => $contact->phone,
			'ac_id' => $contact->ac_id,
			'custom_field_1' => $contact->custom_field_1,
			'custom_field_2' => $contact->custom_field_2,
			'custom_field_3' => $contact->custom_field_3,
			'custom_field_4' => $contact->custom_field_4,
			'custom_field_5' => $contact->custom_field_5,
		]);
	}

	public function table() {
		$user = Auth::user();

		return (String) View::make('contacts.table', ['contacts' => $user->contacts]);
	}

	private function validateContact($input)
	{
		$validation = Validator::make($input, [
			'first_name' => 'required|min:2|alpha_dash',
			'last_name' => 'required|min:2|alpha_dash',
			'email' => 'required|email',
			'phone' => 'required|min:10',
		]);

		return $validation;
	}

}
