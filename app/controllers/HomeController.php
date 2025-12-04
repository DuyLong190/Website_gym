<?php
class HomeController
{
    public function indexHome()
    {
        $htmlClass = 'dark';
        $bodyClass = 'font-display bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary dark-theme';
        $additionalHeadContent = <<<HTML
            <link rel="stylesheet" href="/Gym/public/css/home.css">
            <link rel="stylesheet" href="/Gym/public/css/trangchu.css">
            <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;700&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
            <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
            <style type="text/tailwindcss">
                .material-icons-outlined {
                    font-size: 3rem;
                    line-height: 1;
                }
            </style>
        HTML;

        require_once 'app/views/share/header.php';
        require_once 'app/views/share/trangchu.php';

        require_once 'app/views/share/footer.php';

    }
}
