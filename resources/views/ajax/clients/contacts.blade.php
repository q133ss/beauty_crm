<ul class="list-arrow">
    @foreach($client->socials() as $key => $social)
        <li>{{$key}} : {{$social}}</li>
    @endforeach
</ul>
