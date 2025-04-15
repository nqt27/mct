<article class="col-xl-4 col-sm-12 content-right sidebar">

    <div class="block-title">
        <span class="block-title-inner">Nhận thông tin báo giá</span>
    </div>



    <div class="block-content animation-content">

        <div class="wrap-v-form">
            <div class="v-form-content clearfix">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form class="v-form" method="POST" action="{{ route('submit.form') }}">
                    @csrf
                    <div class="v-form-item v-form-item-name v-form-item-text">
                        <div class="v-form-item-title">Họ và tên <span class="v-form-require"> * </span></div>
                        <div class="v-form-item-content">
                            <input type="text" required class="v-form-field-type-text form-text" placeholder="Họ và tên" name="name">
                        </div>
                    </div>
                    <div class="v-form-item v-form-item-phone v-form-item-text">
                        <div class="v-form-item-title">Số điện thoại <span class="v-form-require"> * </span></div>
                        <div class="v-form-item-content">
                            <input type="text" required class="v-form-field-type-text form-text" placeholder="Số điện thoại" name="phone">
                        </div>
                    </div>
                    <div class="v-form-item v-form-item-email v-form-item-text">
                        <div class="v-form-item-title">Email <span class="v-form-require"> * </span></div>
                        <div class="v-form-item-content">
                            <input type="email" required class="v-form-field-type-text form-text" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="v-form-item v-form-item-submit">
                        <div class="v-form-item-title"></div>
                        <div class="v-form-item-content">
                            <input type="submit" class="form-submit" value="Gửi">
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</article>