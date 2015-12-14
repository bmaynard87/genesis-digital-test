@foreach($contacts as $contact)
    <tr>
        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
        <td>{{ $contact->email }}</td>
        <td>{{ $contact->phone }}</td>
        <td>{{ $contact->custom_field_1 }}</td>
        <td>{{ $contact->custom_field_2 }}</td>
        <td>{{ $contact->custom_field_3 }}</td>
        <td>{{ $contact->custom_field_4 }}</td>
        <td>{{ $contact->custom_field_5 }}</td>
        <td>
            <button class="btn btn-default edit-form-button" data-toggle="modal" data-target="#form_modal" onclick="editContact({{ $contact->id }})"><i class="fa fa-edit"></i></button>
            <button class="btn btn-default" onclick="deleteContact({{ $contact->id }})"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
@endforeach