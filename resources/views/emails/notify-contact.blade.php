<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #004d99;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            background: #ff9800;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-info {
            margin-bottom: 30px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th,
        .products-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .products-table th {
            background: #004d99;
            color: white;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            padding: 15px 0;
            color: #004d99;
        }

        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #004d99;
        }

        .action-required {
            background: #dc3545;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Thông Báo Liên Hệ Mới</h1>
            <p>Thời gian: {{ now()->format('H:i:s d/m/Y') }}</p>
        </div>



        <div class="customer-info">
            <h2>Thông Tin Khách Hàng:</h2>
            <p><strong>Họ và tên:</strong> {{ $data['name'] }} </p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
            <p><strong>Nội dung:</strong> {{ $data['content'] }}</p>

        </div>



        <div class="action-required">
            Vui lòng kiểm tra và xử lý trong hệ thống quản trị!
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('admin') }}" style="background: #004d99; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px;">
                Truy cập Trang Quản Trị
            </a>
        </div>
    </div>
</body>

</html>