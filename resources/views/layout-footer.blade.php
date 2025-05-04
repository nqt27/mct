</div>
<footer class="mct-footer">
    <div class="mct-footer__top-row">
        <img src="{{ asset('uploads/images/' . $logo->filename) }}" alt="Logo" class="mct-footer__logo" />

        <div class="mct-footer__contact">
            <h4>CONTACT <strong>Machuteam MEDIA</strong></h4>
            <input type="email" placeholder="Email của bạn" />
            <button>Đăng Ký</button>
        </div>
    </div>

    <div class="mct-footer__container">
        <div class="mct-footer__column">
            <h3>Hệ Thống Machuteam MEDIA</h3>
            {!! $settings->content !!}
        </div>

        <div class="mct-footer__column">
            <h4>Tương Tác Nhanh</h4>
            <ul>
                <li><a href="#">PODCAST</a></li>
                <li><a href="#">DỊCH VỤ</a></li>
                <li><a href="#">REVIEW</a></li>
                <li><a href="#">BLOG</a></li>
            </ul>
        </div>

        <div class="mct-footer__column">
            <h4>DỊCH VỤ SẢN XUẤT</h4>
            <ul>
                <li><a href="#">Sản Xuất Web Drama</a></li>
                <li><a href="#">Sản Xuất Viral Clip</a></li>
                <li><a href="#">Video Quảng Cáo</a></li>
                <li><a href="#">Sản Xuất MV</a></li>
            </ul>
        </div>

        <div class="mct-footer__column">
            <h4>REVIEW</h4>
            <ul>
                <li><a href="#">Quay Chụp</a></li>
                <li><a href="#">Xây Dựng Nội Dung</a></li>
                <li><a href="#">Video Doanh Nghiệp</a></li>
                <li><a href="#">Sản Phẩm Yêu Thích</a></li>
                <li><a href="#">Hậu Trường</a></li>
            </ul>
        </div>

    </div>


    <div class="mct-footer__map">
        <div class="mct-footer__map-responsive">
            {!! $web_config->google_maps_iframe !!}
        </div>
    </div>

</footer>


<div class="splash-footer">&copy; 2024 Snake Team</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('#form-submit').addEventListener('click', async (e) => {
        e.preventDefault();




        // Get form data
        const formData = {
            email: document.querySelector('[name="email"]').value,
            name: document.querySelector('[name="name"]').value,
            content: document.querySelector('[name="content"]').value,
            phone: document.querySelector('[name="phone"]').value,
        };



        // Validate required fields
        const requiredFields = ['email', 'name', 'content', 'phone'];
        const emptyFields = requiredFields.filter(field => !formData[field]?.trim());
        console.log(emptyFields);

        if (emptyFields.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Thông tin chưa đầy đủ',
                text: 'Vui lòng điền đầy đủ thông tin!'
            });
            return;
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(formData.email)) {
            Swal.fire({
                icon: 'error',
                title: 'Email không hợp lệ',
                text: 'Vui lòng nhập đúng định dạng email!'
            });
            return;
        }

        // Validate phone (Vietnam format)
        const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
        if (!phoneRegex.test(formData.phone)) {
            Swal.fire({
                icon: 'error',
                title: 'Số điện thoại không hợp lệ',
                text: 'Vui lòng nhập đúng số điện thoại!'
            });
            return;
        }



        try { // Show loading screen
            document.getElementById("fullscreenLoader").style.display = "flex";
            const res = await fetch('/send-contact-mail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const result = await res.json();
            if (result.success) {}
        } catch (error) {
            console.error('Error:', error);

        } finally {
            document.getElementById("fullscreenLoader").style.display = "none";
        }
    });
</script>
