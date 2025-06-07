<?php

$items = [
    1 => ['title' => 'Молоко пастеризоване', 'cost' => 12],
    2 => ['title' => 'Хліб чорний', 'cost' => 9],
    3 => ['title' => 'Сир білий', 'cost' => 21],
    4 => ['title' => 'Сметана 20%', 'cost' => 25],
    5 => ['title' => 'Кефір 1%', 'cost' => 19],
    6 => ['title' => 'Вода газована', 'cost' => 18],
    7 => ['title' => 'Печиво "Весна"', 'cost' => 14],
];

$basket = [];

$user = [
    'username' => '',
    'years' => 0
];

echo "\n################################\n";
echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
echo "################################\n";

while (true) {
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
    echo "Введіть команду: ";
    $cmd = trim(fgets(STDIN));

    switch ($cmd) {
        case '1':
            selectGoods($items, $basket);
            break;
        case '2':
            displayInvoice($items, $basket);
            break;
        case '3':
            configureUser($user);
            break;
        case '0':
            exit("Дякуємо за покупки! До побачення.\n");
        default:
            echo "ПОМИЛКА! Введіть правильну команду\n";
    }
}

function renderTable($labels, $data) {
    $columns = array_map(fn($label) => mb_strlen($label, 'UTF-8'), $labels);

    foreach ($data as $line) {
        foreach ($line as $j => $value) {
            $columns[$j] = max($columns[$j], mb_strlen((string)$value, 'UTF-8'));
        }
    }

    foreach ($labels as $j => $label) {
        echo utf8_pad($label, $columns[$j]) . '  ';
    }
    echo "\n";

    foreach ($data as $line) {
        foreach ($line as $j => $value) {
            echo utf8_pad((string)$value, $columns[$j]) . '  ';
        }
        echo "\n";
    }
}

function utf8_pad($txt, $len, $pad = ' ', $enc = 'UTF-8') {
    $remain = $len - mb_strlen($txt, $enc);
    return $remain > 0 ? $txt . str_repeat($pad, $remain) : $txt;
}

function selectGoods($items, &$basket) {
    while (true) {
        $labels = ['№', 'НАЗВА', 'ЦІНА'];
        $data = [];
        foreach ($items as $key => $val) {
            $data[] = [$key, $val['title'], $val['cost']];
        }
        renderTable($labels, $data);
        echo "   -----------\n0  ПОВЕРНУТИСЯ\n";
        echo "Виберіть товар: ";
        $sel = trim(fgets(STDIN));

        if ($sel === '0') break;

        if (!array_key_exists($sel, $items)) {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
            continue;
        }

        $itemName = $items[$sel]['title'];
        echo "Вибрано: $itemName\n";
        echo "Введіть кількість, штук: ";
        $count = trim(fgets(STDIN));

        if (!is_numeric($count) || $count < 0 || $count > 99) {
            echo "ПОМИЛКА! Введена некоректна кількість\n";
            continue;
        }

        if ($count == 0) {
            unset($basket[$sel]);
            echo "ВИДАЛЯЮ ТОВАР З КОШИКА\n";
        } else {
            $basket[$sel] = ($basket[$sel] ?? 0) + $count;
        }

        if (empty($basket)) {
            echo "КОШИК ПОРОЖНІЙ\n";
        } else {
            echo "У КОШИКУ:\n";
            $labels = ['НАЗВА', 'КІЛЬКІСТЬ'];
            $data = [];

            foreach ($basket as $key => $qty) {
                $data[] = [$items[$key]['title'], $qty];
            }
            renderTable($labels, $data);
        }

        echo "\n";
    }
}

function displayInvoice($items, $basket) {
    if (empty($basket)) {
        echo "КОШИК ПОРОЖНІЙ\n";
        echo "РАЗОМ ДО СПЛАТИ: 0\n";
        return;
    }

    $labels = ['№', 'НАЗВА', 'ЦІНА', 'КІЛЬКІСТЬ', 'ВАРТІСТЬ'];
    $data = [];
    $n = 1;
    $sum = 0;

    foreach ($basket as $key => $qty) {
        $title = $items[$key]['title'];
        $price = $items[$key]['cost'];
        $value = $price * $qty;
        $data[] = [$n++, $title, $price, $qty, $value];
        $sum += $value;
    }

    renderTable($labels, $data);

    echo "РАЗОМ ДО СПЛАТИ: $sum\n";
    echo "\n";
}

function configureUser(&$user) {
    while (true) {
        echo "Ваше імʼя: ";
        $username = trim(fgets(STDIN));

        if (!preg_match('/^[а-яА-ЯёЁіІїЇєЄa-zA-Z\'\- ]+$/u', $username)) {
            echo "ПОМИЛКА! Імʼя може містити лише літери, апостроф «'», дефіс «-», пробіл\n\n";
            continue;
        }

        break;
    }

    while (true) {
        echo "Ваш вік: ";
        $years = trim(fgets(STDIN));
        if (!is_numeric($years) || $years < 7 || $years > 150) {
            echo "ПОМИЛКА! Користувач повинен мати вік від 7 та до 150 років.\n\n";
            continue;
        }
        break;
    }

    echo "\n";
    $user['username'] = $username;
    $user['years'] = (int)$years;
    echo "Ваше ім'я: {$user['username']}\nВаш вік: {$user['years']}\n";
    echo "\n";
}
