


<?php
// ฟังก์ชันตรวจสอบการเข้าสู่ระบบ
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
?>
