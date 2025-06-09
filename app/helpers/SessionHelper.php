<?php class SessionHelper
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }
    public static function isAdmin()
    {
        return isset($_SESSION['username']) && intval($_SESSION['role_id']) === 0;
    }
}
?>
