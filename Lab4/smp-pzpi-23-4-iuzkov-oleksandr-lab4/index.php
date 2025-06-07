<?php
session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page = trim($path, '/') ?: 'home';

$pagesAllowedWithoutAuth = ['login', 'home', 'about_us'];
$pageFile = "pages/$page.php";
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Продуктовий магазин Весна</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
    <?php require_once "components/header.php"; ?>

    <main>
        <?php
        if (!file_exists($pageFile)) {
            require_once "pages/page_404.php";
        } else {
            if (!isset($_SESSION['username']) && !in_array($page, $pagesAllowedWithoutAuth)) {
                require_once "pages/no_access.php";
            } else {
                require_once $pageFile;
            }
        }
        ?>
    </main>

    <?php require_once "components/footer.php"; ?>
</body>

</html>
