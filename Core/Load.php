<?php

// Load view, js, css, and other files
class Load
{
    public static function view(string $view, array $data = [])
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }
        require_once 'Public/Views/' . $view . '.php';
    }

    public static function template(string $template, array $data = [])
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }
        require_once 'Public/Views/Templates/' . $template . '.php';
    }

    public static function js(array $js)
    {
        if (is_array($js)) {
            foreach ($js as $file) {
                if (file_exists('Public/js/' . $file . '.js')) {
                    echo '<script src="' . URL . 'Public/js/' . $file . '.js"></script>';
                } else {
                    echo "JS file " . $file . " not found";
                }
            }
        }
    }

    public static function css(array $css)
    {
        if (is_array($css)) {
            foreach ($css as $file) {
                if (file_exists('Public/css/' . $file . '.css')) {
                    echo '<link rel="stylesheet" href="' . URL . 'Public/css/' . $file . '.css">';
                } else {
                    echo "CSS file " . $file . " not found";
                }
            }
        }
    }
}
