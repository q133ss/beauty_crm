<ul class="list-arrow">
    @if($contacts->telegram)
        <li>Telegram:{{$contacts->telegram}}</li>
    @endif
    <li>Телефон: {{$contacts->phone}}</li>
    @if($contacts->socials())
        @foreach($contacts->socials() as $key => $social)
            <li>{{$key}} : {{$social}}</li>
        @endforeach
    @endif
</ul>
