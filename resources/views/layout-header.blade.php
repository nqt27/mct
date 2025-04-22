<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon với PNG -->
    <link rel="icon" href="{{ asset('uploads/images/' . $logo->filename) }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/blogTMa.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/detailTMa.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/blogdetail.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/lienhe.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/dvsx.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/allTMa.css') }}" type="text/css">
    <title>Sun Group | Bất động sản</title>
</head>

<body>


    <header class="snake-top-view">
        <article class="logo">
            <a href="/">

                <img src="{{ asset('uploads/images/' . $logo->filename) }}" alt="logo">
            </a>

            <div class="v-toggle-menu"><i class="fa fa-bars" aria-hidden="true"></i></div>
        </article>
        <article class="snake-navigation">
            <nav class="main-menu">
                <ul class="snake-menu">
                    <li class="active  menu-item" par="1"><a href="#"><i
                                class="fa-solid fa-house-chimney"></i></a></li>
                    <li class="menu-item drop" par="3">
                        <a href="#">Podcast <p style="font-size: x-small;">Truyện ma bẻ lái</p></a>
                        <span class="menu-arrow menu-arrow-1" par="1"></span>
                        <ul class="sub-menu sub-menu-1" par="1">
                            @foreach ($menu as $m)
                                <li class="menu-item2 drop" par="4"><a
                                        href="{{ $m->url }}">{{ $m->ten }}</a>
                                    <ul class="sub-menu2 sub-menu-1">
                                        @foreach ($m->submenu as $sm)
                                            <li class="menu-item" par="4"><a
                                                    href="{{ $m->url }}">{{ $sm->ten }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="menu-item" par="2"><a href="{{ route('dvsx.index') }}">Dịch vụ sản xuất</a></li>
                    <li class="menu-item" par="14"><a href="{{ route('review.index') }}">Review</a></li>
                    <li class="menu-item" par="17"><a href="{{ route('blogTMa.index') }}">Blog</a></li>
                    <li class="menu-item" par="14"><a href="{{ route('lienhe.index') }}">Liên hệ</a></li>
                </ul>
            </nav>
        </article>
        <article class="snake-search">
            <input type="text" id="box" placeholder="Tìm kiếm ..." class="search__box">
            <i class="fas fa-search search__icon" id="icon" onclick="toggleShow()"></i>
        </article>
        <!-- Modal hiển thị kết quả -->
        <div id="modal" class="story-modal hidden">
            <div class="story-modal__content">
                <span class="story-modal__close" onclick="closeModal()">&times;</span>
                <div id="results" class="story-modal__results"></div>
                <div id="view-all" class="story-modal__view-all hidden">
                    <a href="{{ route('allTMa.index') }}">Xem tất cả</a>
                </div>
            </div>
        </div>

    </header>


    <script>
        // function toggleShow() {
        //     var el = document.getElementById("box");
        //     el.classList.toggle("show");
        // }

        // Search functionality
        const searchBox = document.getElementById('box');
        const modal = document.getElementById('modal');
        const resultsDiv = document.getElementById('results');
        const viewAllDiv = document.getElementById('view-all');

        // Collect data from allTMa page
        function collectStoriesData() {
            const stories = [];
            const cards = document.querySelectorAll('.library-card');

            cards.forEach(card => {
                const title = card.querySelector('h3')?.textContent || '';
                const meta = card.querySelector('.library-card__meta')?.textContent || '';
                const image = card.querySelector('img')?.src || '';
                const link = card.getAttribute('href') || '#';

                // Extract views and date from meta text
                const viewsMatch = meta.match(/👁 (\d+)/);
                const dateMatch = meta.match(/📅 ([\d-]+)/);

                stories.push({
                    title,
                    views: viewsMatch ? viewsMatch[1] : '0',
                    date: dateMatch ? dateMatch[1] : '',
                    image,
                    link
                });
            });

            return stories;
        }

        // Initialize stories data
        let stories = [];
        document.addEventListener('DOMContentLoaded', () => {
            stories = collectStoriesData();
        });

        searchBox.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            if (searchTerm.length > 0) {
                modal.classList.remove('hidden');
                const filteredStories = stories.filter(story =>
                    story.title.toLowerCase().includes(searchTerm)
                );

                if (filteredStories.length > 0) {
                    resultsDiv.innerHTML = filteredStories.map(story => `
                        <a href="${story.link}" class="search-result-item">
                            <img src="${story.image}" alt="${story.title}">
                            <div class="search-result-info">
                                <h4>${story.title}</h4>
                                <div class="search-result-meta">👁 ${story.views} | 📅 ${story.date}</div>
                            </div>
                        </a>
                    `).join('');
                    viewAllDiv.classList.add('hidden');
                } else {
                    resultsDiv.innerHTML = '<p>Không tìm thấy kết quả</p>';
                    viewAllDiv.classList.remove('hidden');
                }
            } else {
                modal.classList.add('hidden');
            }
        });

        function closeModal() {
            modal.classList.add('hidden');
            searchBox.value = '';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
