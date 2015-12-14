<div id="form_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="form_modal_header">Edit Contact</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => 'contacts', 'id' => 'edit_form', 'class' => 'form']) }}
                    <div id="modal_errors" class="form-group">

                    </div>
                    <div id="form_fields">
                        <div class="form-group">
                            {{Form::label('first_name', 'First Name', ['class' => 'sr-only'])}}
                            {{Form::text('first_name', null, ['id' => 'first_name', 'class' => 'form-control edit-form-field', 'placeholder' => 'First Name'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('last_name', 'Last Name', ['class' => 'sr-only'])}}
                            {{Form::text('last_name', null, ['id' => 'last_name', 'class' => 'form-control edit-form-field', 'placeholder' => 'Last Name'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('email', 'Email', ['class' => 'sr-only'])}}
                            {{Form::email('email', null, ['id' => 'email', 'class' => 'form-control edit-form-field', 'placeholder' => 'Email'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('phone', 'Phone', ['class' => 'sr-only'])}}
                            {{Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control edit-form-field', 'placeholder' => 'Phone'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-default', 'id' => 'add_field_button']) }}
                        </div>
                        <div class="input_fields_wrap form-inline">
                        </div>
                    </div>
                    {{ Form::hidden('ac_id', null, ['id' => 'ac_id']) }}
                    {{ Form::hidden('list', '1') }}
                    <div class="form-group">
                        {{ Form::submit('Save', ['class' => 'btn btn-primary form-control']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>