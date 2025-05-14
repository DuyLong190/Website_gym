<?php
class HomeController
{
    public function index()
    {
        // Chỉ hiển thị header và footer
        require_once __DIR__ . '/../views/share/header.php';
        require_once __DIR__ . '/../views/share/footer.php';
    }
}
