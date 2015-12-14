@extends('layouts.master')

@section('content')
    <div id="content">
        <h2>Contacts</h2>
        @if(count($user->contacts) < 1)
            <p>You don't have any contacts saved. <a href="#" id="first_contact_button" class="btn btn-default" data-toggle="modal" onclick="newContact()" data-target="#form_modal">Click</a> to add one!</p>
        @else
            <div id="messages">

            </div>
            <form action="{{ url('contacts/search') }}" class="search-form" id="search_form">
                <div class="input-group stylish-input-group">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
            <br>
            <button class="btn btn-default edit-form-button" onclick="newContact()" data-toggle="modal" data-target="#form_modal"><i class="fa fa-user-plus"> Add Contact</i></button>
            <table id="contacts_table" class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Extra Field 1</th>
                        <th>Extra Field 2</th>
                        <th>Extra Field 3</th>
                        <th>Extra Field 4</th>
                        <th>Extra Field 5</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @include('contacts.table', ['contacts' => $user->contacts])
                </tbody>
            </table>
        @endif
    </div>
    @include('common.modal')
@stop