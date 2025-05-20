<?php

/**
 * Load chuỗi văn bản dựa trên ngôn ngữ
 * @param string $key - Key của chuỗi văn bản
 * @return string - Chuỗi văn bản tương ứng
 */
function trans($key)
{
    // Mặc định là tiếng Việt nếu không có ngôn ngữ trong session
    $lang = $_SESSION['language'] ?? 'vi';

    // Load file ngôn ngữ
    $languageFile = "app/languages/{$lang}.php";
    if (file_exists($languageFile)) {
        $translations = include $languageFile;
    } else {
        $translations = include 'app/languages/vi.php'; // Fallback về tiếng Việt
    }

    // Trả về chuỗi văn bản, nếu không tìm thấy thì trả về key
    return $translations[$key] ?? $key;
}