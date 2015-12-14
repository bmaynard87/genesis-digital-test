@if($messages)
    <div class="alert alert-success alert-dismissible" id="m_alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <ul style="list-style: none; padding: 0; display: inline-block">
            @foreach($messages as $message)
                <li><strong>{{ $message }}</strong></li>
            @endforeach
        </ul>
    </div>
@endif