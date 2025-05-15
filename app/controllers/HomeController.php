<?php
class HomeController
{
    public function index()
    {
        // Hiển thị header và footer
        require_once 'app/views/share/header.php';
        require_once 'app/views/share/footer.php';
    }
}
