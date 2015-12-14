@if($errors->any())
    <br>
    <div class="alert alert-warning alert-dismissible" style="display: inline-block;">
        <ul style="list-style: none;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif