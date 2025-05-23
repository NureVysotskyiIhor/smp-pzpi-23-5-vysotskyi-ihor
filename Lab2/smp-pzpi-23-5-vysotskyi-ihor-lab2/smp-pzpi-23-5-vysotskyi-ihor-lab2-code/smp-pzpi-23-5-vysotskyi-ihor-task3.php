<?php
// Масив товарів
$products = [
    1 => ["name" => "Молоко пастеризоване", "price" => 12],
    2 => ["name" => "Хліб чорний", "price" => 9],
    3 => ["name" => "Сир білий", "price" => 21],
    4 => ["name" => "Сметана 20%", "price" => 25],
    5 => ["name" => "Кефір 1%", "price" => 19],
    6 => ["name" => "Вода газована", "price" => 18],
    7 => ["name" => "Печиво 'Весна'", "price" => 14]
];

// Кошик
$cart = [];

// Функція для відображення меню
function showMenu() {
    echo "################################\n";
    echo "# ПРОДОВОЛЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
    echo "################################\n";
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
    echo "Введіть команду: ";
}

function mb_strlen_custom($string, $encoding = 'UTF-8') {
    // Считает количество символов в строке, а не байтов
    return preg_match_all('/./u', $string, $matches);
}

function getMaxNameLength(array $products): int {
    $maxLength = 0;
    foreach ($products as $product) {
        if (isset($product['name'])) {
            $length = mb_strlen_custom($product['name']);
            if ($length > $maxLength) {
                $maxLength = $length;
            }
        }
    }
    return $maxLength;
}
function echoSpaces($strToQuit, $maxLength, $baseLength = 22){

    if($baseLength - $maxLength < 0){
        $baseLength = $maxLength;
        return $baseLength - mb_strlen_custom($strToQuit);
    }else{
        return $baseLength - mb_strlen_custom($strToQuit);
    }
    
}
function selectProducts(&$cart, $products) {
    $maxNameLength = getMaxNameLength($products);
    do {
        //$spaces = str_repeat(" ", echoSpaces($products, ));
        echo "№  НАЗВА" .str_repeat(" ", echoSpaces("НАЗВА",$maxNameLength))."ЦІНА\n";
        foreach ($products as $key => $product) {
            $name = $product['name'];
            //printf("%-2d %-22s", $key, $name);
            echo $key. "  " . $name .str_repeat(" ", echoSpaces($name,$maxNameLength)). $product['price']."\n" ;
        }
        echo "-----------\n";
        echo "0  ПОВЕРНУТИСЯ\n";
        echo "Виберіть товар: ";
        $productNumber = (int) trim(fgets(STDIN));

        if ($productNumber == 0) {
            break;
        } elseif (isset($products[$productNumber])) {
            echo "Вибрано: {$products[$productNumber]['name']}\n";
            echo "Введіть кількість, штук: ";
            $quantity = (int) trim(fgets(STDIN));

            if ($quantity > 0 && $quantity < 100) {
                if (isset($cart[$productNumber])) {
                    $cart[$productNumber]['quantity'] += $quantity;
                } else {
                    $cart[$productNumber] = [
                        'name' => $products[$productNumber]['name'],
                        'price' => $products[$productNumber]['price'],
                        'quantity' => $quantity
                    ];
                }
                echo "У КОШИКУ:\n";
                echo "НАЗВА" .str_repeat(" ", echoSpaces("НАЗВА",$maxNameLength))."КІЛЬКІСТЬ\n";
                foreach ($cart as $item) {
                    echo $item['name'] .str_repeat(" ", echoSpaces($item['name'],$maxNameLength)). $item['quantity']."\n" ;
                }
            } elseif ($quantity == 0) {
                unset($cart[$productNumber]);
                echo "ВИДАЛЯЮ З КОШИКА\n";
                if (empty($cart)) {
                    echo "КОШИК ПОРОЖНІЙ\n";
                }
            } else {
                echo "ПОМИЛКА! Кількість повинна бути більше 0 і менше 100.\n";
            }
        } else {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
        }
    } while (true);
}

// Функція для отримання підсумкового рахунку
function getTotal($cart) {
    $maxNameLength = getMaxNameLength($cart);
    echo "№  НАЗВА" .str_repeat(" ", echoSpaces("НАЗВА",$maxNameLength))."ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
    //echo "№  НАЗВА                  ЦІНА  КІЛЬКІСТЬ  ВАРТІСТЬ\n";
    $total = 0;
    foreach ($cart as $key => $item) {
        $cost = $item['price'] * $item['quantity'];
        $total += $cost;       
        echo $key. "  " . $item['name'];
        echo str_repeat(" ", echoSpaces($item['name'],$maxNameLength));
        echo $item['price'];
        echo str_repeat(" ", echoSpaces($item['price'],0, 6));
        echo $item['quantity'];
        echo str_repeat(" ", echoSpaces($item['quantity'],0, 11));
        echo $cost."\n" ;
    }
    echo "РАЗОМ ДО CПЛАТИ: $total\n";
}

// Функція для налаштування профілю
function setProfile() {
    do {
        echo "Ваше імʼя: ";
        $name = trim(fgets(STDIN));
    } while (empty($name) || !preg_match("/[a-zA-Zа-яА-Я]/", $name));

    do {
        echo "Ваш вік: ";
        $age = (int) trim(fgets(STDIN));
    } while ($age < 7 || $age > 150);

    echo "Ваш профіль:\nІмʼя: $name\nВік: $age\n";
}

// Основний цикл програми
do {
    showMenu();
    // Читання введеного значення
    $input = trim(fgets(STDIN));

    // Перевірка, чи введено число
    if (is_numeric($input)) {
        $command = (int) $input;
    } else {
        // Якщо введено не число
        $command = -1; // Призначаємо недопустиме значення
    }

    switch ($command) {
        case 1:
            selectProducts($cart, $products);
            break;
        case 2:
            getTotal($cart);
            break;
        case 3:
            setProfile();
            break;
        case 0:
            echo "Вихід з програми...\n";
            break;
        default:
            echo "ПОМИЛКА! Введіть правильну команду\n";
            break;
    }
} while ($command != 0);
?>