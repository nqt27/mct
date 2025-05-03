function wrapnav() {
    $(document).ready(function () {
        $(".v-toggle-menu").on("click", function () {
            // Toggle class "active" cho menu
            $(".snake-menu").toggleClass("show");

            // Toggle class "active" cho nút
            $(this).toggleClass("active");
        });

        $(".header__nav-close").on("click", function () {
            // Ẩn menu khi nhấn nút close
            $(".snake-menu").removeClass("show");

            // Gỡ class "active" trên nút toggle nếu có
            $(".v-toggle-menu").removeClass("active");
        });

        const animatedEls = document.querySelectorAll(".animation-content");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        // Khi phần tử vào viewport, thêm class "fadeIn" để áp dụng hiệu ứng xuất hiện
                        entry.target.classList.add("animated", "fadeIn");
                        entry.target.classList.remove("fadeOut"); // Đảm bảo rằng không có hiệu ứng fadeOut
                    } else {
                        // Khi phần tử ra khỏi viewport, thêm class "fadeOut" để áp dụng hiệu ứng biến mất
                        entry.target.classList.add("animated", "fadeOut");
                        entry.target.classList.remove("fadeIn"); // Đảm bảo rằng không có hiệu ứng fadeIn
                    }
                });
            },
            {
                threshold: 0.5,
            }
        ); // 50% của phần tử phải hiện lên mới kích hoạt hiệu ứng

        animatedEls.forEach((el) => observer.observe(el));

        $(".menu-item.drop").hover(
            function () {
                $(this).children(".sub-menu").stop(true, true).fadeIn(500); // Hiển thị chậm hơn (500ms)
            },
            function () {
                $(this).children(".sub-menu").stop(true, true).fadeOut(100); // Ẩn chậm hơn (500ms)
            }
        );
        $(".menu-item2.drop").hover(
            function () {
                $(this).children(".sub-menu2").stop(true, true).fadeIn(500); // Hiển thị chậm hơn (500ms)
            },
            function () {
                $(this).children(".sub-menu2").stop(true, true).fadeOut(100); // Ẩn chậm hơn (500ms)
            }
        );
        $(".menu-item3.drop").hover(
            function () {
                $(this).children(".sub-menu3").stop(true, true).fadeIn(500); // Hiển thị chậm hơn (500ms)
            },
            function () {
                $(this).children(".sub-menu3").stop(true, true).fadeOut(100); // Ẩn chậm hơn (500ms)
            }
        );
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                // Khi người dùng cuộn trang xuống hơn 50px
                $(".snake-top-view").addClass("fixed-menu");
                // $('.main-menu').addClass('container');
                $(".snake-top-view").addClass("wrap-nav");
            } else {
                $(".snake-top-view").removeClass("fixed-menu");
                // $('.main-menu').removeClass('container');
                $(".snake-top-view").removeClass("wrap-nav");
            }
        });
    });
}
function slideAudio() {
    $(document).ready(function () {
        $(".slider-container").each(function () {
            const $container = $(this);
            const $slider = $container.find(".slider");
            const $slideGroups = $slider.find(".slide-group");
            const $dotsContainer = $container.find(".slider-dots");
            const $nextBtn = $container.find(".next-btn");
            const $prevBtn = $container.find(".prev-btn");

            let currentSlide = 0;
            const totalSlides = $slideGroups.length;

            // Xóa hết các dot cũ trước khi thêm mới
            $dotsContainer.empty();

            // Tạo dots cho mỗi slide
            for (let i = 0; i < totalSlides; i++) {
                $dotsContainer.append(
                    `<div class="dot ${i === 0 ? "active" : ""}"></div>`
                );
            }

            // Function to move to a specific slide
            function goToSlide(index) {
                $slider.css("transform", `translateX(-${index * 100}%)`);
                $dotsContainer
                    .find(".dot")
                    .removeClass("active")
                    .eq(index)
                    .addClass("active");
                currentSlide = index;
            }

            // Function to navigate between slides (next/prev)
            function navigate(direction) {
                currentSlide =
                    (currentSlide + direction + totalSlides) % totalSlides;
                goToSlide(currentSlide);
            }

            // Event bindings
            $nextBtn.click(() => navigate(1));
            $prevBtn.click(() => navigate(-1));

            // Click on dot to navigate to the respective slide
            $dotsContainer.on("click", ".dot", function () {
                const index = $(this).index();
                goToSlide(index);
            });

            // Hover effect for cards
            $container.find(".card").each(function () {
                const $card = $(this);

                $card.on("mousemove", function (e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * 15;
                    const rotateY = ((centerX - x) / centerX) * 15;

                    this.style.setProperty("--card-rotate-x", `${rotateX}deg`);
                    this.style.setProperty("--card-rotate-y", `${rotateY}deg`);
                });

                $card.on("mouseleave", function () {
                    this.style.setProperty("--card-rotate-x", "0deg");
                    this.style.setProperty("--card-rotate-y", "0deg");
                });
            });

            // Touch swipe handling
            let touchStartX = 0;
            let touchEndX = 0;

            $slider.on("touchstart", function (e) {
                touchStartX = e.originalEvent.touches[0].clientX;
            });

            $slider.on("touchend", function (e) {
                touchEndX = e.originalEvent.changedTouches[0].clientX;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > 50) {
                    navigate(diff > 0 ? 1 : -1);
                }
            });
        });

        // Bokeh background (for the entire page)
        const $bokehBackground = $("#bokeh-background");
        const numBokeh = 25;
        const colors = [
            { start: "rgba(255, 69, 0, .6)", end: "rgba(255, 69, 0, 0.25)" },
            { start: "rgba(255, 0, 0, .6)", end: "rgba(255, 0, 0, 0.25)" },
            { start: "rgba(255, 165, 0, .6)", end: "rgba(255, 165, 0, 0.25)" },
            {
                start: "rgba(255, 20, 147, .6)",
                end: "rgba(255, 20, 147, 0.25)",
            },
            {
                start: "rgba(238, 130, 238, .6)",
                end: "rgba(238, 130, 238, 0.25)",
            },
            { start: "rgba(148, 0, 211, .6)", end: "rgba(148, 0, 211, 0.25)" },
        ];

        for (let i = 0; i < numBokeh; i++) {
            const $bokeh = $("<div>").addClass("bokeh");
            const size = Math.random() * 120 + 50;
            const left = Math.random() * 100;
            const top = Math.random() * 100;
            const color = colors[Math.floor(Math.random() * colors.length)];
            const background = `radial-gradient(circle, ${color.start} 0%, ${color.end} 100%)`;
            const animationDelay = `${Math.random() * 2}s`;
            const animationDuration = `${Math.random() * 10 + 10}s`;

            $bokeh.css({
                width: `${size}px`,
                height: `${size}px`,
                left: `${left}%`,
                top: `${top}%`,
                background: background,
                animationDelay: animationDelay,
                animationDuration: animationDuration,
            });

            $bokehBackground.append($bokeh);
        }
    });
}
