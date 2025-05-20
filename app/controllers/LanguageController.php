<?php
require_once 'app/helpers/language_helper.php';

class LanguageController {
    public function index() {
        include_once 'app/views/language/index.php';
    }

    public function change() {
        $lang = $_GET['lang'] ?? 'vi';
        set_language($lang);
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/webdr/Product/home';
        header("Location: $referrer");
        exit;
    }
}
?>