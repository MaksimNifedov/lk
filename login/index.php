<?php
include $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';
if (authorizationVerification()) {
    header("Location: /");
}
$check = [0];
if (!empty($_POST)) {
    $check = checkAutorizationViaDB($_POST['email'], $_POST['password']);
    if ($check[0] == "Успешно") {
        $_SESSION['isAuthorized'] = true;
        $_SESSION['id'] = $check[1];
        $_SESSION['email'] = $_POST['email'];
        setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 30, '/');
    }
}
includeTemplate('header.php'); ?>
<main class="flex-1 container mx-auto bg-white overflow-hidden px-4 sm:px-6">
    <div class="py-4 pb-8">
        <h1 class="text-black text-3xl font-bold mb-4">Авторизация</h1>
        <?php
        switch ($check[0]) {
            case "Успешно":
                includeTemplate('messages/success_message.php', ['message' => 'Вы успешно авторизовались']);
                break;
            case "Неверно":
                includeTemplate('messages/error_message.php', ['message' => 'Неверный email или пароль']);
                break;
            case "Неактивен":
                includeTemplate('messages/error_message.php', ['message' => 'Доступ запрещен']);
                break;
            default:
        }
        ?>
        <form action="/login/" method="POST">
            <div class="mt-8 max-w-md">
                <div class="grid grid-cols-1 gap-6">
                    <div class="block">
                        <label for="fieldEmail" class="text-gray-700 font-bold">Email</label>
                        <input id="fieldEmail" name="email" value="<?= isset($_COOKIE['email']) ?  $_COOKIE['email'] : '' ?>" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com">
                    </div>
                    <div class="block">
                        <label for="fieldPassword" class="text-gray-700 font-bold">Пароль</label>
                        <input id="fieldPassword" name="password" value="<?= empty($_POST['password']) ? '' : $_POST['password'] ?>" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="******">
                    </div>
                    <div class="block">
                        <button type="submit" class="inline-block bg-orange hover:bg-opacity-70 focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Войти
                        </button>
                        <a href='/register.html' class="inline-block hover:underline focus:outline-none font-bold py-2 px-4 rounded">
                            У меня нет аккаунта
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<?php includeTemplate('footer.php'); ?>