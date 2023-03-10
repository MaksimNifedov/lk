<?

function cutString($line, $length = 14, $appends = '...'): string
{
    if (strlen($line) > 14) {
        return substr($line, 0, $length) . $appends;
    } else {
        return $line;
    }
}

function arraySort(array $array, $key = 'sort', $sort = SORT_ASC): array
{
    usort($array, function ($a, $b) use ($key, $sort) {
        return $sort == SORT_ASC ? $a[$key] <=> $b[$key] : $b[$key] <=> $a[$key];
    });
    return $array;
}


function getMenu(): array
{
    $array = [
        [
            'title' => 'Главная',
            'path' => '/',
            'sort' => 0,
        ],
        [
            'title' => 'Лучшая  машина',
            'path' => '/bestCar/',
            'sort' => 1,
        ],
        [
            'title' => 'Характеристики машин',
            'path' => '/characteristicsCars/',
            'sort' => 2,
        ],
        [
            'title' => 'Сравнение машин',
            'path' => '/comparisonCars/',
            'sort' => 3,
        ],
    ];
    if (authorizationVerification()) {
        array_push(
            $array,
            [
                'title' => 'Каталог',
                'path' => '/catalog/',
                'sort' => 4,
            ]
        );
    }
    return $array;
}

function getCars(): array
{
    $cars = [
        [
            'name' => 'Seed',
            'image' => '/assets/pictures/car_ceed.png',
            'price' => $price = 1394900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Cerato',
            'image' => '/assets/pictures/car_cerato.png',
            'price' => $price = 1221900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'K5',
            'image' => '/assets/pictures/car_K5-half.png',
            'price' => $price = 1577900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'K900',
            'image' => '/assets/pictures/car_k900.png',
            'price' => $price = 4064900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Mohave',
            'image' => '/assets/pictures/car_mohave_new.png',
            'price' => $price = 3549900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Stinger',
            'image' => '/assets/pictures/car_new_stinger.png',
            'price' => $price = 2409900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Rio',
            'image' => '/assets/pictures/car_rio-x.png',
            'price' => $price = 969900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Rio',
            'image' => '/assets/pictures/car_rio_new.png',
            'price' => $price = 849900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Seltos',
            'image' => '/assets/pictures/car_seltos.png',
            'price' => $price = 1224900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Sorento',
            'image' => '/assets/pictures/car_sorento_new.png',
            'price' => $price = 2219900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Soul',
            'image' => '/assets/pictures/car_soul.png',
            'price' => $price = 1094900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'Sportage',
            'image' => '/assets/pictures/car_sportage.png',
            'price' => $price = 1644900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
        [
            'name' => 'XSeed',
            'image' => '/assets/pictures/car_xceed.png',
            'price' => $price = 1714900,
            'oldPrice' => rand(0, 3) > 2 ? $price + rand(1, 10000) : null,
        ],
    ];

    shuffle($cars);

    $carsCount = count($cars);

    return array_splice($cars, 0, rand(min(5, $carsCount), $carsCount));
}

function authorizationVerification()
{
    if ( isset($_SESSION['isAuthorized'])) {
        return true;
    } else {
        return false;
    }
}

function connectToDataBase($host = "localhost", $userName = "root", $password = "", $dbName = "lk")
{
    static $connection;
    if (null === $connection) {
        $connection = new mysqli($host, $userName, $password, $dbName);
    }
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}

function checkAutorizationViaDB($enteredLogin, $enteredPass): array
{
    $enteredLogin = mysqli_real_escape_string(connectToDataBase(), $enteredLogin);
    $enteredPass = mysqli_real_escape_string(connectToDataBase(), $enteredPass);
    $sql = "SELECT password, active, id FROM users where email='{$enteredLogin}' LIMIT 1;";
    $checkTest = mysqli_query(connectToDataBase(), $sql);
    $checkTest = mysqli_fetch_all($checkTest);
    if ($checkTest && password_verify($enteredPass, $checkTest[0][0]) && $checkTest[0][1] == 1) {
        return ["Успешно", $checkTest[0][2]];
    } elseif ($checkTest && password_verify($enteredPass, $checkTest[0][0]) && $checkTest[0][1] != 1) {
        return ["Неактивен"];
    } else {
        return ["Неверно"];
    }
}

function getUserData(): array
{
    $infoGroup = [];
    $id =  $_SESSION['id'];
    $sql = "SELECT FIO, email, phone,active, mailing FROM users where id = '{$id}'  LIMIT 1 ;";
    $infoUser = mysqli_query(connectToDataBase(), $sql);
    $infoUser =  mysqli_fetch_assoc($infoUser);
    $sql1 = "SELECT `groups`.`id`, `groups`.`name`, `groups`.`description` FROM `groups`
    RIGHT OUTER JOIN `group_user` ON `groups`.`id` = `group_user`.`group_id`
    LEFT OUTER JOIN `users` on `users`.`id` = `group_user`.`user_id` WHERE `users`.`id` =' {$id}' ;";
    $userGroups = mysqli_query(connectToDataBase(), $sql1);

    while ($userGroup = mysqli_fetch_assoc($userGroups)) {
        array_push($infoGroup, $userGroup);
    }
    return [$infoUser, $infoGroup];
}

function userRegistration($FIO, $email, $password)
{
    $FIO = mysqli_real_escape_string(connectToDataBase(), $FIO);
    $email = mysqli_real_escape_string(connectToDataBase(), $email);
    $password = mysqli_real_escape_string(connectToDataBase(), $password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (`active`, `FIO`, `email`, `password`) VALUES ('1', '{$FIO}', '{$email}', '{$password}') ;";
    mysqli_query(connectToDataBase(), $sql);
}
