@include('layout-header')
<section id="review-root">
    <h2>Đánh Giá Truyện Ma</h2>

    <form class="review-form" id="reviewForm">
        <label for="name">Tên của bạn:</label>
        <input type="text" id="name" required />

        <label for="title">Tiêu đề đánh giá:</label>
        <input type="text" id="title" required />

        <label for="rating">Đánh giá (1 - 5):</label>
        <select id="rating" required>
            <option value="">--Chọn--</option>
            <option value="5">5 - Rất hay</option>
            <option value="4">4 - Hay</option>
            <option value="3">3 - Tạm được</option>
            <option value="2">2 - Không hay lắm</option>
            <option value="1">1 - Tệ</option>
        </select>

        <label for="content">Nội dung:</label>
        <textarea id="content" rows="4" required></textarea>

        <button type="submit">Gửi đánh giá</button>
    </form>

    <div class="review-list" id="reviewList">
        <!-- Đánh giá sẽ hiển thị ở đây -->
    </div>
</section>

@include('layout-footer')
<script>
    const reviewForm = document.getElementById('reviewForm');
    const reviewList = document.getElementById('reviewList');

    reviewForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const title = document.getElementById('title').value;
        const rating = document.getElementById('rating').value;
        const content = document.getElementById('content').value;

        const reviewHTML = `
        <div class="review-card">
          <h4>${title} - ${name} (${rating}/5)</h4>
          <p>${content}</p>
        </div>
      `;

        reviewList.insertAdjacentHTML('afterbegin', reviewHTML);
        reviewForm.reset();
    });
</script>
