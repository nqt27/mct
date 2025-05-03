
function drag(url) {
    // Sử dụng Dragula để cho phép kéo thả
    const drake = dragula([document.getElementById('column-1')]);

    // Khi việc kéo thả hoàn tất, chúng ta sẽ lấy thứ tự mới và gửi đến server
    drake.on('drop', function (el, target, source, sibling) {
        console.log(1);

        // Lấy thứ tự các phần tử trong danh sách
        const orderedItems = [];
        document.querySelectorAll('#column-1 .menu-item').forEach(item => {
            orderedItems.push(item.id.replace('menu-', '')); // Lấy id của các phần tử
        });

        // Gửi thứ tự mới lên server
        // saveOrder(orderedItems);
        console.log(orderedItems);
        $.ajax({
            url: url, // Đường dẫn đến API của bạn
            method: 'POST',
            data: {
                order: orderedItems, // Gửi mảng thứ tự mới
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token cho Laravel
            },
            success: function (response) {
                console.log("Thứ tự đã được cập nhật thành công:", response);
            },
            error: function (xhr) {
                console.log("Có lỗi xảy ra khi cập nhật thứ tự:", xhr);
            }
        });

    });
}
function generateSlug(value) {
    return value.toLowerCase()
        .normalize('NFD') // Chuẩn hóa ký tự
        .replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu tiếng Việt
        .replace(/[^a-z0-9\s-]/g, '') // Xóa ký tự không phải chữ cái và số
        .trim() // Xóa khoảng trắng ở đầu và cuối
        .replace(/\s+/g, '-'); // Thay khoảng trắng bằng dấu gạch ngang
}
function formMenu(button, url, method = 'POST', parent_id) {
    // Lấy thông tin menu từ thuộc tính data của nút
    let menuId = button.data('id');
    let menuName = button.data('name');
    let menuUrl = button.data('url');

    // Sử dụng SweetAlert2 để hiển thị form chỉnh sửa
    Swal.fire({
        title: 'Chỉnh sửa menu',
        html: `
        <form id="editMenuForm">
            <div class="form-group">
                <label style="width: 30%" for="menu-name">Tên menu</label>
                <input type="text" id="menu-name" class="swal2-input" value="${menuName || ''}">
            </div>
            <div class="form-group">
                <label  style="width: 30%" for="menu-url">URL</label>
                <input type="text" id="menu-url" class="swal2-input" value="${menuUrl || ''}">
            </div>
        </form>
    `,
        didOpen: () => {
            const nameInput = document.getElementById('menu-name');
            const urlInput = document.getElementById('menu-url');

            // Lắng nghe sự kiện nhập liệu trên trường "Tên menu"
            nameInput.addEventListener('input', () => {
                const nameValue = nameInput.value;
                urlInput.value = generateSlug(nameValue); // Tạo slug cho URL
            });
        },
        showCancelButton: true,
        confirmButtonText: 'Lưu',
        cancelButtonText: 'Hủy',
        preConfirm: () => {
            // Lấy giá trị từ các trường nhập liệu
            const updatedName = $('#menu-name').val();
            const updatedUrl = $('#menu-url').val();

            // Kiểm tra nếu các trường không để trống
            if (!updatedName || !updatedUrl) {
                Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin!');
                return false;
            }
            return {
                ten: updatedName,
                slug: updatedUrl
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let data = {
                ten: result.value.ten,
                slug: result.value.slug,
                _method: method,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token cho Laravel
            };

            // Thêm `parent_id` nếu nó tồn tại
            if (parent_id) {
                data.parent_id = parent_id;
            }
            console.log(url);
            // Gửi dữ liệu cập nhật qua AJAX
            $.ajax({
                url: menuId ? `${url}/${menuId}` : url,
                // Đường dẫn cập nhật
                method: 'POST',
                data: data,
                success: function (response) {
                    Swal.fire({
                        title: "Saved",
                        text: "Menu đã được lưu",
                        icon: "success"
                    });

                    window.location.reload();

                    // Tùy chọn: Tải lại trang hoặc cập nhật DOM để phản ánh thay đổi
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cập nhật thất bại',
                        text: 'Có lỗi xảy ra trong quá trình cập nhật.'
                    });
                    console.log("Lỗi:", xhr);
                }
            });
        }
    });
}
function addMenu(button, url, method, parent_id) {
    button.on('click', function () {
        formMenu(button, url, method, parent_id);
        console.log(url);

    });
}
function editMenu(button, url) {
    button.on('click', function () {
        formMenu($(this), url, 'PUT');
    });

}
function deleteMenu(url) {
    $('.delete-btn').on('click', function () {
        // Lấy thông tin menu từ thuộc tính data của nút
        let menuId = $(this).data('id');
        console.log(menuId);

        // Sử dụng SweetAlert2 để hiển thị form chỉnh sửa
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi dữ liệu cập nhật qua AJAX
                $.ajax({
                    url: `${url}/${menuId}`, // Đường dẫn cập nhật
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token cho Laravel
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Saved",
                            text: "Menu đã được lưu",
                            icon: "success"
                        });

                        window.location.reload();

                        // Tùy chọn: Tải lại trang hoặc cập nhật DOM để phản ánh thay đổi
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cập nhật thất bại',
                            text: 'Có lỗi xảy ra trong quá trình cập nhật.'
                        });
                        console.log("Lỗi:", xhr);
                    }
                });
            }
        });
    });
}

function selectMenu() {
    const selectParent = document.getElementById("select-parent");
    const selectChild = document.getElementById("select-child");
    const selectSubChild = document.getElementById("select-subchild");
    console.log(selectChild);

    function loadSubCategories(parentId, selectElement, clearElement = null) {
        if (clearElement) {
            clearElement.innerHTML = '<option value="">Chọn danh mục</option>';
        }

        if (!parentId) {
            selectElement.innerHTML = '<option value="">Chọn danh mục</option>';
        }

        fetch(`/get-subcategories/${parentId}`)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = '<option value="">Chọn danh mục</option>';

                if (data.length > 0) {
                    data.forEach(category => {
                        const option = document.createElement("option");
                        option.value = category.id;
                        option.textContent = category.ten;
                        selectElement.appendChild(option);
                    });

                    selectElement.style.display = "block"; // Hiện dropdown nếu có dữ liệu
                } else {
                    selectElement.style.display = "none"; // Ẩn nếu không có danh mục con
                }
            })
            .catch(error => console.error("Lỗi khi lấy danh mục:", error));
    }



    selectParent.addEventListener("change", function () {
        loadSubCategories(this.value, selectChild, selectSubChild);
    });

    selectChild.addEventListener("change", function () {
        loadSubCategories(this.value, selectSubChild);
    });
}

function table(menuData, target) {
    var table = $('#table1').DataTable({
        order: [
            [1, 'asc']
        ],
        columnDefs: [{
            orderable: false,
            targets: target
        } // Chỉ định các cột không sắp xếp, theo chỉ mục (bắt đầu từ 0)
        ]
    });

    // Hàm lọc tùy chỉnh
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var k = "";
            var l = $("#select-child").val() ? $("#select-child").val() : $("#select-parent").val();// Giá trị option đã chọn
            var cleanStr = menuData.replace(/&quot;/g, '"'); // Thay thế &quot; bằng dấu ngoặc kép "
            var array = JSON.parse(cleanStr);
            // console.log(array);


            var columnElement = table.row(dataIndex).node(); // Lấy dòng HTML của hàng hiện tại
            var s = $(columnElement).find('td.hidden-menu span').text().trim(); // Lấy giá trị từ <span> bị ẩn
            // var s = data[5]; // '5' là chỉ số của cột "Danh mục" trong bảng
            // console.log(s);
            var matchedSubmenus = [];

            array.forEach(menu => {
                if (l == menu.id) {
                    // Kiểm tra tất cả các submenu
                    menu.submenu.forEach(submenu => {
                        if (submenu.id == s) {
                            matchedSubmenus.push(submenu.id); // Lưu các submenu khớp
                        }
                    });
                }
            });
            // Nếu không chọn gì (giá trị rỗng), hiển thị tất cả
            if ((matchedSubmenus.length > 0 || l == s) || "All" == $('#select-parent').val()) {
                return true;
            }
            return false;
        }
    );

    // Sự kiện thay đổi khi chọn option trong select
    $('#select-parent').on('change', function () {
        table.draw(); // Cập nhật DataTable để áp dụng bộ lọc
    });
    $('.select2').on('change', function () {
        table.draw(); // Cập nhật DataTable để áp dụng bộ lọc
    });
}
function statusAudio(url) {
    // Lắng nghe sự kiện thay đổi của tất cả checkbox
    $('.status-checkbox').on('change', function () {
        var audioDiv = $(this).closest('.audio-status'); // Tìm div chứa checkbox của sản phẩm
        var audioId = audioDiv.data('audio-id'); // Lấy ID sản phẩm từ data attribute của div


        if (!audioId) {
            console.log(audioId);
            return; // Nếu không có audioId, không gửi yêu cầu AJAX
        }
        // Lấy trạng thái các checkbox trong div này
        var display = audioDiv.find('input[name="display"]').prop('checked') ? 1 : 0;
        var nghenhieu = audioDiv.find('input[name="nghenhieu"]').prop('checked') ? 1 : 0;
        var moi = audioDiv.find('input[name="moi"]').prop('checked') ? 1 : 0;
        console.log(display);
        // Gửi yêu cầu AJAX để cập nhật các trạng thái
        $.ajax({
            url: url + audioId, // Đường dẫn route cho update
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                display: display, // Trạng thái display
                nghenhieu: nghenhieu, // Trạng thái discount
                moi: moi, // Trạng thái moi
                _method: 'PUT'
            },
            success: function (response) {
                console.log('Cập nhật trạng thái thành công cho sản phẩm ID: ' + audioId);
                // Tùy chọn: Cập nhật DOM hoặc thông báo thành công
            },
            error: function (xhr) {
                console.log("Lỗi khi cập nhật trạng thái:", xhr);
            }
        });
    });
}
function deleteItem(url) {
    $('.delete-btn').on('click', function () {
        // Lấy thông tin menu từ thuộc tính data của nút
        let audioId = $(this).data('id');
        var row = $(this).closest('tr'); // Lấy dòng chứa nút xóa

        // Sử dụng SweetAlert2 để hiển thị form chỉnh sửa
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi dữ liệu cập nhật qua AJAX
                $.ajax({
                    url: url + audioId, // Đường dẫn cập nhật
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token cho Laravel
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Đã xóa",
                            text: "Đã xóa sản phẩm",
                            icon: "success"
                        });

                        row.remove();

                        // Tùy chọn: Tải lại trang hoặc cập nhật DOM để phản ánh thay đổi
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Có lỗi xảy ra trong quá trình xóa.'
                        });
                        console.log("Lỗi:", xhr);
                    }
                });
            }
        });
    });
}
function deleteAll(url) {
    $('#select-all').on('click', function () {
        $('.select-item').prop('checked', this.checked);
    });
    $('#delete-all').on('click', function () {
        var selectedIds = [];
        $('.select-item:checked').each(function () {
            selectedIds.push($(this).val());
        });
        if (selectedIds.length > 0) {
            Swal.fire({
                title: 'Bạn có chắc muốn xóa tất cả sản phẩm?',
                text: "Hành động này không thể khôi phục!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi yêu cầu AJAX
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            // Xóa các hàng đã chọn khỏi giao diện
                            $('.select-item:checked').closest('tr').remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã xóa tất cả!',
                                text: "Dữ liệu không thể khôi phục!",
                                timer: 3000,
                            })
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra. Vui lòng thử lại.'
                            });
                        }
                    });
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Chưa có mục nào được chọn',
                text: 'Chọn một mục để xóa'
            });
        }
    });
}
function checkSEO() {

    let results = [];
    let focusKeyword = document.getElementById("keyword_focus").value;
    //Keyword Focus
    let checkFocusKeyword = (!focusKeyword) ?
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Đặt từ khóa chính cho nội dung.
                </div>
            </div>` :
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Đã thêm từ khóa chính.
                </div>
            </div>`;
    //Keyword Focus nằm trong Title SEO
    let titleSeo = document.getElementById("seo_title").value;
    let checkFocusKeywordTitle = (titleSeo && focusKeyword && (titleSeo.toLowerCase().includes(focusKeyword.toLowerCase()))) ?

        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Tiêu đề SEO bao gồm từ khóa chính.
                </div>
            </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Thêm Từ khóa chính vào tiêu đề SEO.
                </div>
        </div>`;
    //Vị trí Keyword Focus
    let position = titleSeo.toLowerCase().indexOf(focusKeyword.toLowerCase());
    let checkPosition = (titleSeo && focusKeyword && position >= 0 && position <= 20) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Sử dụng từ khóa chính gần đầu tiêu đề SEO.
                </div>
        </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Sử dụng từ khóa chính gần đầu tiêu đề SEO.
                </div>
        </div>`;
    //Ký tự tiêu đề
    if (titleSeo.length < 10) {
        checkTitleLength =
            `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Tiêu đề quá ngắn. Tiêu đề nên từ 10 đến 70 ký tự
                </div>
        </div>`;
    } else if (titleSeo.length > 70) {
        checkTitleLength =
            `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Tiêu đề quá dài. Tiêu đề nên từ 10 đến 70 ký tự
                </div>
        </div>`;
    } else {
        checkTitleLength =
            `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Tiêu đề đã có độ dài tối ưu.
                </div>
        </div>`;
    }

    //Keyword Focus nằm trong Mô tả SEO
    let desSeo = document.getElementById("seo_description").value;
    let checkFocusKeywordDes = (desSeo && focusKeyword && (desSeo.toLowerCase().includes(focusKeyword.toLowerCase()))) ?

        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Mô tả SEO bao gồm từ khóa chính.
                </div>
            </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Thêm Từ khóa chính vào mô tả SEO.
                </div>
        </div>`;
    //Ký tự tiêu đề
    if (desSeo.length < 10) {
        checkDesLength =
            `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Mô tả quá ngắn. Mô tả nên từ 10 đến 160 ký tự
                </div>
        </div>`;
    } else if (desSeo.length > 160) {
        checkDesLength =
            `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Mô tả quá dài. Mô tả nên từ 10 đến 160 ký tự
                </div>
        </div>`;
    } else {
        checkDesLength =
            `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert"></button>Mô tả đã có độ dài tối ưu.
                </div>
        </div>`;
    }
    let url = document.getElementById("audio-url").innerText;
    let checkKeywordInUrl = (url.includes(focusKeyword)) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
        <div class="icon"><span class="mdi mdi-check"></span></div>
        <div class="message">Từ khóa chính đã có trong URL.</div>
    </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
        <div class="message">Từ khóa chính chưa có trong URL.</div>
    </div>`;
    let urlLength = url.length;
    let checkUrlLength = (urlLength >= 20) ?
        checkUrlLength = `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
        <div class="icon"><span class="mdi mdi-check"></span></div>
        <div class="message">Url có ${urlLength} ký tự. Tuyệt vời!</div>
    </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
        <div class="message">Url có ${urlLength} ký tự(ngắn).</div>
    </div>`;
    let content = document.getElementById("editor1").value; // Lấy nội dung
    let checkKeywordInContent = (content.toLowerCase().includes(focusKeyword.toLowerCase())) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
            <div class="icon"><span class="mdi mdi-check"></span></div>
            <div class="message">Từ khóa chính đã được sử dụng trong nội dung.</div>
        </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
            <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
            <div class="message">Từ khóa chính chưa được sử dụng trong nội dung.</div>
        </div>`;
    let contentLength = content.split(' ').length; // Số từ trong nội dung
    let checkContentLength = (contentLength >= 600 && contentLength <= 2500) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">Nội dung có ${contentLength} từ. Tuyệt vời!</div>
            </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">Nội dung chỉ có ${contentLength} từ. Hãy viết từ 600-2500 từ.</div>
            </div>`;
    let headings = document.querySelectorAll("h2, h3, h4");
    let keywordInHeadings = Array.from(headings).some(heading => heading.innerText.toLowerCase().includes(focusKeyword.toLowerCase()));
    let checkKeywordInHeadings = (keywordInHeadings) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">Từ khóa chính đã xuất hiện trong tiêu đề phụ.</div>
                </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                    <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                    <div class="message">Từ khóa chính chưa xuất hiện trong tiêu đề phụ.</div>
                </div>`;
    let images = document.querySelectorAll("img");
    let keywordInAlt = Array.from(images).some(img => img.alt.toLowerCase().includes(focusKeyword.toLowerCase()));
    let checkKeywordInAlt = (keywordInAlt) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                        <div class="icon"><span class="mdi mdi-check"></span></div>
                        <div class="message">Từ khóa chính đã được sử dụng trong thuộc tính alt của hình ảnh.</div>
                    </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message">Từ khóa chính chưa được sử dụng trong thuộc tính alt của hình ảnh.</div>
                    </div>`;
    let keywordDensity = (content.match(new RegExp(focusKeyword, "gi")) || []).length / contentLength * 100;
    let checkKeywordDensity = (keywordDensity >= 1 && keywordDensity <= 2) ?
        `<div class="alert alert-success alert-icon alert-dismissible check-seo" role="alert">
                            <div class="icon"><span class="mdi mdi-check"></span></div>
                            <div class="message">Mật độ từ khóa là ${keywordDensity.toFixed(2)}%. Tuyệt vời!</div>
                        </div>` :
        `<div class="alert alert-danger alert-icon alert-dismissible check-seo" role="alert">
                            <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                            <div class="message">Mật độ từ khóa là ${keywordDensity.toFixed(2)}%. Nhắm đến khoảng 1-2%.</div>
                        </div>`;




    results.push(`
    ${checkFocusKeyword}
    ${checkFocusKeywordTitle}
    ${checkPosition}
    ${checkTitleLength}
    ${checkFocusKeywordDes}
    ${checkDesLength}
    ${checkKeywordInUrl}
    ${checkUrlLength}
    ${checkKeywordInContent}
    ${checkContentLength}
    ${checkKeywordInHeadings}
    ${checkKeywordInAlt}
    ${checkKeywordDensity}
    `);
    // Hiển thị kết quả bằng SweetAlert2
    Swal.fire({
        title: 'Kết quả kiểm tra SEO',
        html: results.join('<br>'),
        icon: 'info',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'custom-swal-width' // Áp dụng lớp CSS tùy chỉnh
        },
    });
}
function urlaudio() {
    const baseUrl = window.location.origin + "/";
    document.getElementById("url-simple").innerText = baseUrl + document.getElementById("audio-url").value;
    document.getElementById("name").addEventListener("input", function () {
        const audioUrlInput = document.getElementById("audio-url");
        const baseUrl = window.location.origin + "/";

        // Tự động tạo slug từ giá trị của 'name'
        audioUrlInput.value = generateSlug(this.value);
        document.getElementById("url-simple").innerText = baseUrl + audioUrlInput.value;
    });

    // Sự kiện riêng cho 'audio-url' để người dùng chỉnh sửa slug
    document.getElementById("audio-url").addEventListener("input", function (event) {
        const baseUrl = window.location.origin + "/";

        // Xử lý giá trị slug
        let value = generateSlug(event.target.value);

        // Cập nhật giá trị và URL hiển thị
        event.target.value = value;
        document.getElementById("url-simple").innerText = baseUrl + value;
    });

}