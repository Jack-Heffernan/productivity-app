@if (!$is_active)
    <div class="container">
        <div class="main-wrapper">
            <b> Instance not active. Transfer your playback using your Spotify app </b>
        </div>
    </div>
@else
    <div class="container">
        <div class="main-wrapper">
            <img src="{{ $current_track['album']['images'][0]['url'] }}" class="now-playing__cover" alt="" />
            <div class="now-playing__side">
                <div class="now-playing__name">{{ $current_track['name'] }}</div>
                <div class="now-playing__artist">{{ $current_track['artists'][0]['name'] }}</div>
                <form action="{{ route('webplayback.previous') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-spotify">&lt;&lt;</button>
                </form>
                <form action="{{ route('webplayback.toggle') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-spotify">{{ $is_paused ? "PLAY" : "PAUSE" }}</button>
                </form>
                <form action="{{ route('webplayback.next') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-spotify">&gt;&gt;</button>
                </form>
            </div>
        </div>
    </div>
@endif
