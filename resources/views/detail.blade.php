@include('layout-header')
<div class="container" style="margin-bottom: 30px;">
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Xem Phim</a> /
        <a href="#"> Phim Lẻ</a> /
        <span> Quá Nhanh Quá Nguy Hiểm 7</span>
    </div>
</div>
<div class="ct-container">

    <section class="ct-detail">
        <div class="ct-cover">
            <section class="snake-audio-content">
                <div class="slider-container">
                    <div class="app-container">
                        <div id="volume">
                            <button id="muteBtn"><i class="fas fa-volume-up"></i></button>
                            <div id="volume-bar">
                                <input type="range" id="volumeSlider" min="0" max="1" step="0.01"
                                    value="1">
                                <div id="volumeIndicator" class="volume-indicator"></div>
                            </div>
                        </div>
                        <img id="albumArt" src="" alt="{{ $audio->ten }}">
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
                                    <button id="playPauseBtn" data-id="{{ $audio->id }}"><i
                                            class="fas fa-play"></i></button>
                                    <button id="nextBtn"><i class="fas fa-step-forward"></i></button>
                                    <button id="shuffleBtn"><i class="fas fa-random"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </div>
        <div class="ct-info">
            <h1>{{ $audio->ten }}</h1>
            <div class="ct-meta">{{ $audio->tacgia }} | Ngày đăng: {{ $audio->created_at }} | Lượt xem:
                {{ $audio->luot_nghe }}</div>
            <p>{!! $audio->tomtat !!}</p>
            <button class="ct-btn">Nghe Tập 1</button>
        </div>
    </section>
    <section class="ct-episode-list">
        <h2 id="audioData" data-chapters="{{ json_encode($audio->chapters) }}">Danh Sách Tập</h2>
        @foreach ($audio->chapters as $chapter)
            <div class="ct-episode">
                <span>Tập 1: {{ $chapter->title }}</span>
                <button class="ct-btn" data-src="{{ $chapter->chapter_number }}">Nghe</button>
            </div>
        @endforeach

    </section>

    <section class="ct-related">
        <h2>Truyện Liên Quan</h2>

        <div class="ct-related-grid">
            <div class="container" style="margin-bottom: 30px;">
                <section class="snake-content">
                    <div class="slider-container">
                        <div class="slider">
                            <div class="slide-group active">
                                <div class="card" data-tilt>
                                    <a href="{{ route('detailTMa.index') }}">
                                        <img src="https://datdongradio.com/upload/images/TRUYEN-NGAN/2025/T4/lac-vao-ban-quy-nghe-truyen-ma-audio-nguyen-huy.jpg"
                                            title="Audio 1" alt="Audio 1">
                                        <h3>Audio 1</h3>
                                        <p><i class="fa-solid fa-eye"></i>Lượt xem: 30</p>
                                        <p><i class="fa-solid fa-calendar-days"></i>Phát hành: 1-1-2025</p>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="ct-more">
            <a title="Mới nhất" href="{{ route('allTMa.index') }}">
                <div class="text_container">
                    <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                    <p>XEM THÊM <i class="fa-solid fa-angles-right"></i></p>
                </div>
            </a>
        </div>
    </section>
</div>
@include('layout-footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
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
                    document.getElementById('luot-nghe').innerText = data
                        .luot_nghe; // Cập nhật lượt nghe trên giao diện
                }
            });
    });
</script>

<script>
    const audio = new Audio();
    let isPlaying = false;

    const playPauseBtn = document.getElementById("playPauseBtn");
    playPauseBtn.addEventListener("click", togglePlayPause);
    const audioDataElement = document.getElementById("audioData");
    const chapters = JSON.parse(audioDataElement.getAttribute("data-chapters"));

    let tracks = [];


    if (Array.isArray(chapters) && chapters.length > 0) {
        tracks = chapters.map(chapter => {

            return {
                src: "{{ asset('uploads/audio') }}/" + chapter.audio_path,
                // cái đường dẫn audio đã có sẵn
                albumArt: "{{ asset('uploads/images/' . $audio->image) }}",
                trackTitle: "{{ $audio->ten }}",
                bandName: "Band 1",
            };
        });
    } else {
        tracks = [{
                src: "{{ asset('uploads/audio/' . $audio->audio_path) }}",
                albumArt: "{{ asset('uploads/images/' . $audio->image) }}",
                trackTitle: "{{ $audio->ten }}", // Format: "minutes:seconds"
                bandName: "Band 1",
            }

        ];
    }
    console.log(tracks);

    // Load tracks using JavaScript


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
    const episodeButtons = document.querySelectorAll(".ct-btn");
    episodeButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const chapterNumber = parseInt(this.getAttribute("data-src")); // lấy số chương
            currentTrackIndex = chapterNumber -
                1; // Nếu chapter_number là 1-based thì trừ 1 cho đúng mảng JS
            console.log(currentTrackIndex);

            loadTrack(currentTrackIndex);
            audio.play(); // chơi nhạc
        });
    });

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


{{-- <script>
    wrapnav();
    slideAudio();
</script> --}}
</body>

</html>
