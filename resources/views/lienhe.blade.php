@include('layout-header')
<section id="contact-root">
    <h2>Liên Hệ Với Chúng Tôi</h2>
    <form class="contact-form" id="contactForm">
        <label for="contactName">Họ tên:</label>
        <input type="text" id="contactName" required />

        <label for="contactEmail">Email:</label>
        <input type="email" id="contactEmail" required />

        <label for="contactMessage">Nội dung:</label>
        <textarea id="contactMessage" rows="5" required></textarea>

        <button type="submit">Gửi Liên Hệ</button>
    </form>

    <div class="contact-info">
        Hoặc gửi email về <strong>ghoststory@example.com</strong><br />
        Trụ sở: Làng Hoang 13, Rừng Đen, Việt Nam
    </div>
</section>
@include('layout-footer')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.');
        this.reset();
    });
</script>
