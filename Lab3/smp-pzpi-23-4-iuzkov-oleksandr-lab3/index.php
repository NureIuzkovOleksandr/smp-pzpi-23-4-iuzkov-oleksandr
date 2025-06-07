<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page = trim($path, '/') ?: 'home';
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
        if (is_file($pageFile)) {
            require_once $pageFile;
        } else {
            require_once "pages/page_404.php";
        }
        ?>
    </main>

    <?php require_once "components/footer.php"; ?>
</body>

</html>
