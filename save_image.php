<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu ảnh từ POST request
    $data = json_decode(file_get_contents("php://input"));
    
    if (isset($data->image)) {
        // Dữ liệu ảnh ở dạng base64
        $image = $data->image;
        
        // Xóa phần đầu 'data:image/png;base64,'
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        
        // Chuyển base64 thành dữ liệu nhị phân
        $imageData = base64_decode($image);
        
        // Đặt tên file và đường dẫn lưu ảnh
        $fileName = 'webcam_image_' . time() . '.png';
        $filePath = 'uploads/' . $fileName;
        
        // Lưu ảnh vào thư mục uploads
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true); // Tạo thư mục nếu chưa có
        }
        
        // Ghi dữ liệu ảnh vào file
        if (file_put_contents($filePath, $imageData)) {
            echo 'Ảnh đã được lưu thành công: ' . $filePath;
        } else {
            echo 'Không thể lưu ảnh.';
        }
    } else {
        echo 'Không có dữ liệu ảnh.';
    }
} else {
    echo 'Phương thức không hợp lệ.';
}
?>
