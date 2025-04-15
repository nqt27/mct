@include('layout-header')
<div class="container" style="margin-bottom: 30px;">
    <section class="snake-audio-content">
        <div class="content-left-item audio-flex-content">
            <div class="slider-container">
                <div class="app-container">
                    <div id="volume">
                        <button id="muteBtn"><i class="fas fa-volume-up"></i></button>
                        <div id="volume-bar">
                            <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="1">
                            <div id="volumeIndicator" class="volume-indicator"></div>
                        </div>
                    </div>
                    <img id="albumArt" src="" alt="{{$audio->ten}}">
                    <div id="fade"></div>
                    <div id="uiWrap">
                        <div class="audio-info">
                            <div class="track-info">
                                <div id="trackTitle"></div>
                                <div id="bandName"></div>
                                <button id="likeBtn"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="seek-bar">
                                <input type="range" id="seekSlider" min="0" step="1" value="0">
                                <div id="bufferingIndicator" class="buffering-indicator"></div>
                                <div id="seekIndicator" class="seek-indicator"></div>
                                <div id="currentTime">0:00</div>
                                <div id="trackTime">0:00</div>
                            </div>
                        </div>
                        <div class="audio-controls">
                            <div class="playSkip">
                                <button id="loopBtn"><i class="fas fa-redo"></i></button>
                                <button id="prevBtn"><i class="fas fa-step-backward"></i></button>
                                <button id="playPauseBtn" data-id="{{ $audio->id }}"><i class="fas fa-play"></i></button>
                                <button id="nextBtn"><i class="fas fa-step-forward"></i></button>
                                <button id="shuffleBtn"><i class="fas fa-random"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="audio-info">
                <div class="audio-info-header">
                    <h6>Linh dị</h6>
                    <h1>{{$audio->ten}}</h1>
                    <h6>Tác giả: Duy Võ</h6>
                </div>
                <div class="audio-info-content">
                    <p><i class="fa-solid fa-eye"></i>Lượt nghe: {{ $audio->luot_nghe }}</p>
                    <p><i class="fa-solid fa-eye"></i>Giọng đọc: Nguyễn Huy</p>
                    <h3>Tóm tắt</h3>
                    <p>Nghe truyện ma Lộ Diện Kẻ Sát Nhân kể về hành trình lần tìm chân tướng tên tà sư và gã ác tâm hại mạng người của chàng thanh niên trẻ được mệnh danh là thợ săn tiền thưởng. Mời quý vị theo dõi qua lời kể của Nguyễn Huy - Đất Đồng Radio.
                        <br>
                        Tác giả: Duy Võ
                        <br>
                        -----
                        <br>
                        Theo dõi facebook tác giả:
                        <br>
                        ➥ https://www.facebook.com/profile.php?...
                        <br>
                        ➥ Facebook Nguyễn Huy
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="snake-content">
        <div class="content-left-item">
            <div class="content-left-item-header">
                <h2 class="block-title">

                    <span class="block-title-inner">Mới nhất</span>
                    <a title="Mới nhất" href="#">
                        <div class="text_container">
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                        </div>
                    </a>
                </h2>
            </div>
            <!-- <div id="bokeh-background"></div> -->
            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">
                        @foreach($new_audio->chunk(4) as $index => $group)
                        <div class="slide-group {{ $loop->first ? 'active' : '' }}">
                            @foreach($group as $p)
                            <div class="card" data-tilt>
                                <a href="#">
                                    <img src="{{asset('uploads/images/'. $p->image)}}" title="{{$p->ten}}" alt="{{$p->ten}}">
                                    <h3>{{$p->ten}}</h3>
                                    <p><i class="fa-solid fa-eye"></i>Lượt xem: 30</p>
                                    <p><i class="fa-solid fa-calendar-days"></i>Phát hành: 1-1-2025</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="nav-btn prev-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="slider-dots"></div>
            </div>

        </div>
        <div class="content-left-item">
            <div class="content-left-item-header">
                <h2 class="block-title">

                    <span class="block-title-inner">Nghe nhiều nhất</span>
                    <a title="Nghe nhiều nhất" href="#">
                        <div class="text_container">
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                            <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                        </div>
                    </a>
                </h2>
            </div>
            <!-- <div id="bokeh-background"></div> -->
            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider">
                        @foreach($new_audio->chunk(4) as $index => $group)
                        <div class="slide-group {{ $loop->first ? 'active' : '' }}">
                            @foreach($group as $p)
                            <div class="card" data-tilt>
                                <a href="{{ route('detail', $p->slug) }}">
                                    <img src="{{asset('uploads/images/'. $p->image)}}" title="{{$p->ten}}" alt="{{$p->ten}}">
                                    <h3>{{$p->ten}}</h3>
                                    <p><i class="fa-solid fa-eye"></i>Lượt xem: 30</p>
                                    <p><i class="fa-solid fa-calendar-days"></i>Phát hành: 1-1-2025</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="nav-btn prev-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <div class="slider-dots"></div>
            </div>

        </div>

    </section>
</div>
@include('layout-footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    document.getElementById('playPauseBtn').addEventListener('click', function() {
        let audioId = this.getAttribute('data-id'); // Lấy ID audio

        fetch(`/audio/play/${audioId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('luot-nghe').innerText = data.luot_nghe; // Cập nhật lượt nghe trên giao diện
                }
            });
    });
</script>
<script>
    const audio = new Audio();
    let isPlaying = false;

    const playPauseBtn = document.getElementById("playPauseBtn");
    playPauseBtn.addEventListener("click", togglePlayPause);

    // Load tracks using JavaScript
    const tracks = [{
        src: "https://raw.githubusercontent.com/muhammederdem/mini-player/master/mp3/1.mp3",
        albumArt: "{{ asset('uploads/images/' . $audio->image) }}",
        trackTitle: "{{$audio->ten}}",
        duration: "3:09" // Format: "minutes:seconds"
    }];

    let currentTrackIndex = 0;

    function loadTrack(trackIndex) {
        const track = tracks[trackIndex];
        audio.src = track.src;
        document.getElementById("albumArt").src = track.albumArt;
        document.getElementById("trackTitle").textContent = track.trackTitle;
        document.getElementById("bandName").textContent = track.bandName;
        document.getElementById("trackTime").textContent = track.duration;
    }

    loadTrack(currentTrackIndex);

    // Event listener for updating time and buffering indicator
    audio.addEventListener("timeupdate", () => {
        const currentTime = formatTime(audio.currentTime);
        document.getElementById("currentTime").textContent = currentTime;
        document.getElementById("seekSlider").value = audio.currentTime;

        if (audio.buffered.length > 0) {
            const buffered = audio.buffered.end(0);
            const bufferPercent = (buffered / audio.duration) * 100;
            document.getElementById("bufferingIndicator").style.width = `${bufferPercent}%`;
        }

        // Update the seek indicator width based on the current time percentage
        const currentPercent = (audio.currentTime / audio.duration) * 100;
        document.getElementById("seekIndicator").style.width = `${currentPercent}%`;
    });

    function formatTime(timeInSeconds) {
        const minutes = Math.floor(timeInSeconds / 60);
        const seconds = Math.floor(timeInSeconds % 60);
        return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    }

    // Event listener for seek slider
    const seekSlider = document.getElementById("seekSlider");
    seekSlider.addEventListener("input", handleSeek);

    function handleSeek() {
        const seekTime = parseFloat(seekSlider.value);
        audio.currentTime = seekTime;
    }

    // Event listener for updating the total duration when metadata is loaded
    audio.addEventListener("loadedmetadata", () => {
        seekSlider.max = audio.duration;
        const totalDuration = formatTime(audio.duration);
        document.getElementById("trackTime").textContent = totalDuration;
    });

    // Function to toggle play and pause
    function togglePlayPause() {
        if (isPlaying) {
            audio.pause();
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        } else {
            audio.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }
        isPlaying = !isPlaying;
    }

    // Event listeners for play and pause
    audio.addEventListener("pause", () => {
        isPlaying = false;
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    });

    audio.addEventListener("play", () => {
        isPlaying = true;
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    });

    // Event listener for track ending
    audio.addEventListener("ended", playNextOrLoop);

    function playNextOrLoop() {
        if (isLooping) {
            // If looping is enabled, replay the current track
            audio.currentTime = 0;
            audio.play();
        } else {
            if (isShuffled) {
                playNextTrackInShuffle();
            } else {
                playNextSequentialTrack();
            }
        }
    }

    // Functions to play next track (either in shuffle or sequential)
    function playNextTrackInShuffle() {
        currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
        loadTrack(currentTrackIndex);
        audio.play();
    }

    function playNextSequentialTrack() {
        if (currentTrackIndex === tracks.length - 1) {
            currentTrackIndex = 0;
        } else {
            currentTrackIndex++;
        }
        loadTrack(currentTrackIndex);
        audio.play();
    }

    // Event listeners for next and previous buttons
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");

    nextBtn.addEventListener("click", playNextTrack);
    prevBtn.addEventListener("click", playPreviousTrack);

    function playNextTrack() {
        currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
        loadTrack(currentTrackIndex);
        audio.play();
        isPlaying = true;
    }

    function playPreviousTrack() {
        currentTrackIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
        loadTrack(currentTrackIndex);
        audio.play();
        isPlaying = true;
    }

    // Event listeners for loop and shuffle buttons
    const shuffleBtn = document.getElementById("shuffleBtn");
    const loopBtn = document.getElementById("loopBtn");

    let isShuffled = false;
    let isLooping = false;

    shuffleBtn.addEventListener("click", toggleShuffle);
    loopBtn.addEventListener("click", toggleLoop);

    function toggleShuffle() {
        isShuffled = !isShuffled;
        shuffleBtn.classList.toggle("active", isShuffled);

        if (isShuffled) {
            shuffleTracks();
        }
    }

    function shuffleTracks() {
        // Fisher-Yates shuffle algorithm
        for (let i = tracks.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [tracks[i], tracks[j]] = [tracks[j], tracks[i]];
        }
    }

    function toggleLoop() {
        isLooping = !isLooping;
        loopBtn.classList.toggle("active", isLooping);
        audio.loop = isLooping;
    }

    // Volume control functionality
    const muteBtn = document.getElementById("muteBtn");
    const volumeSlider = document.getElementById("volumeSlider");
    const volumeIndicator = document.getElementById("volumeIndicator");
    const volumeBar = document.getElementById("volume-bar"); // Assuming #volume-bar exists

    let isMuted = false;
    let savedVolume = 1; // Store the volume before muting

    muteBtn.addEventListener("click", toggleMute);
    volumeSlider.addEventListener("input", setVolume);

    function toggleMute() {
        isMuted = !isMuted;
        if (isMuted) {
            savedVolume = audio.volume;
            audio.volume = 0;
            muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            volumeBar.classList.add("muted"); // Add muted class
        } else {
            audio.volume = savedVolume;
            muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            volumeBar.classList.remove("muted"); // Remove muted class
        }
        volumeSlider.value = isMuted ? 0 : savedVolume;
        muteBtn.classList.toggle("active", isMuted);

        // Update volume indicator width
        updateVolumeIndicator();
    }

    function setVolume() {
        if (!isMuted) {
            audio.volume = volumeSlider.value;
            savedVolume = volumeSlider.value;
        }

        // Update volume indicator width
        updateVolumeIndicator();
    }

    // Function to update the volume indicator width
    function updateVolumeIndicator() {
        const volumePercentage = audio.volume * 100;
        volumeIndicator.style.width = `${volumePercentage}%`;
    }

    // Initialize the volume indicator width on load
    updateVolumeIndicator();

    // Like button functionality
    const likeBtn = document.getElementById("likeBtn");
    let isLiked = false;

    likeBtn.addEventListener("click", function() {
        if (isLiked) {
            likeBtn.classList.remove("liked");
            likeBtn.innerHTML = '<i class="far fa-heart"></i>';
        } else {
            likeBtn.classList.add("liked");
            likeBtn.innerHTML = '<i class="fas fa-heart"></i>';
        }
        isLiked = !isLiked;
    });
</script>
<script>
    wrapnav();
    slideAudio();
</script>
</body>

</html>