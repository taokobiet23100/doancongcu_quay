<?php include '../views/shares/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG BÁN ĐÀN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%; /* Đảm bảo chiều cao tối thiểu cho body */
            margin: 0;    /* Xóa khoảng cách mặc định */
        }

        body {
            display: flex;
            flex-direction: column; /* Sắp xếp các phần tử theo chiều dọc */
        }

        .container {
            flex: 1; /* Cho phép container lấp đầy không gian còn lại */
        }

        footer {
            background-color: #f1f1f1; /* Màu nền cho footer */
            padding: 20px 0; /* Khoảng cách trên và dưới cho footer */
            text-align: center; /* Căn giữa nội dung */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <h5>Lọc theo giá</h5>
            <form asp-action="Index" asp-controller="Category">
                <p>
                    <input type="text" id="amount" readonly="" style="border:0; color:#f6931f; font-weight:bold; width:300px;">
                </p>
                <div id="slider-range"></div>
                <button type="submit" name="locgia" data-current_url="@currenUrl" class="btn btn-danger btn-locgia">Lọc Giá</button>
            </form>
        </div>
        <div class="col-md-2 offset-md-5">
            <h5>Sắp xếp theo</h5>
            <select class="form-control" id="sort_by">
                <option>-------</option>
                <option value="@currenUrl?sort_by=price_increase">Giá Tăng Dần</option>
                <option value="@currenUrl?sort_by=price_decrease">Giá Giảm Dần</option>
                <option value="@currenUrl?sort_by=price_newest">Mới Nhất</option>
                <option value="@currenUrl?sort_by=price_oldest">Cũ Nhất</option>
            </select>
        </div>
    </div>
</div>

<?php include '../app/views/shares/footer.php'; ?>
</body>
</html>