<?php 
    class ValiDate{
        public static function validatePhoneNumber($phoneNumber) {
            $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
            
            // Kiểm tra độ dài của số điện thoại phải từ 10 đến 11 ký tự
            if (strlen($phoneNumber) < 10 || strlen($phoneNumber) > 11) {
                return false;
            }
            
            // Kiểm tra số điện thoại phải bắt đầu bằng số 0
            if ($phoneNumber[0] !== '0') {
                return false;
            }
            
            // Kiểm tra số điện thoại phải có định dạng đúng
            if (!preg_match('/^(0[0-9]{9,10})$/', $phoneNumber)) {
                return false;
              }
            
            // Nếu chuỗi số điện thoại đầu vào hợp lệ, trả về true
            return true;
        }

        public static function validateUsername($username) {
            // Loại bỏ khoảng trắng ở đầu và cuối chuỗi tên người dùng
            $username = trim($username);
          
            // Kiểm tra độ dài của chuỗi tên người dùng từ 2 đến 100 ký tự
            if (mb_strlen($username) < 2 || mb_strlen($username) > 100) {
              return false;
            }
          
            // Kiểm tra chuỗi tên người dùng không chứa ký tự đặc biệt
            if (!preg_match('/^[a-zA-Z0-9_\- áàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵÁÀẢÃẠÂẤẦẨẪẬĂẮẰẲẴẶÉÈẺẼẸÊẾỀỂỄỆÍÌỈĨỊÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÚÙỦŨỤƯỨỪỬỮỰÝỲỶỸỴ]+$/', $username)) {
              return false;
            }
          
            // Nếu chuỗi tên người dùng đầu vào hợp lệ, trả về true
            return true;
          }
          
        // Hàm để validate mật khẩu
        public static function validateMatKhau($matKhau) {
            // Kiểm tra độ dài mật khẩu
            if (strlen($matKhau) < 8) {
                return false;
            }

            // Kiểm tra sự tồn tại của chữ cái viết hoa
            if (!preg_match("/[A-Z]/", $matKhau)) {
                return false;
            }

            // Kiểm tra sự tồn tại của chữ cái viết thường
            if (!preg_match("/[a-z]/", $matKhau)) {
                return false;
            }

            // Kiểm tra sự tồn tại của số
            if (!preg_match("/[0-9]/", $matKhau)) {
                return false;
            }

            // Mật khẩu hợp lệ
            return true;
        }
        public static function validateEmail($email) {
            // Kiểm tra tính hợp lệ của địa chỉ email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              return true;
            } else {
              return false;
            }
          }
          
    }

?>