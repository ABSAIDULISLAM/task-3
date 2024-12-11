@if ($errors->any())
    <div class="">
        <ul>
            @foreach ($errors->all() as $error)
                @php
                    toastr()->error($error);
                @endphp
            @endforeach
        </ul>
    </div>
@endif
