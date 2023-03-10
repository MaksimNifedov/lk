<?php
include $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';
if (authorizationVerification()) {
    header("Location: /");
}
$fillingError = false;
$passwordMismatch = false;
$shortPassword = false;
$registration = false;
if (!empty($_POST)) {
    foreach ($_POST as $val) {
        if (empty($val)) {
            $fillingError = true;
            break;
        }
    }
    if ($_POST['password'] != $_POST['password_confirmation']) {
        $passwordMismatch = true;
    }
    if (strlen($_POST['password']) < 6) {
        $shortPassword = true;
    }
    if (!$fillingError && !$shortPassword  && !$passwordMismatch) {
        $registration = true;
    }
}
if ($registration) {
    userRegistration($_POST['name'], $_POST['email'], $_POST['password']);
}
includeTemplate('header.php'); ?>
<main class="flex-1 container mx-auto bg-white overflow-hidden px-4 sm:px-6">
    <div class="py-4 pb-8">
        <h1 class="text-black text-3xl font-bold mb-4">Регистрация</h1>
        <?php
        if ($fillingError) {
            includeTemplate('messages/error_message.php', ['message' => 'Нужно заполнить все поля!']);
        }
        if ($shortPassword && !$fillingError) {
            includeTemplate('messages/error_message.php', ['message' => 'Пароль слишком короткий!']);
        }
        if ($passwordMismatch && !$shortPassword && !$fillingError) {
            includeTemplate('messages/error_message.php', ['message' => 'Пароли не совпадают!']);
        }
        if ($registration) {
            includeTemplate('messages/success_message.php', ['message' => 'Вы успешно зарегистрированы']);
        }
        ?>

        <form action="/register/" method="post">
            <div class="mt-8 max-w-md">
                <div class="grid grid-cols-1 gap-6">
                    <div class="block">
                        <label for="fieldName" class="text-gray-700 font-bold">ФИО</label>
                        <input id="fieldName" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Иванов Иван Иваныч">
                    </div>
                    <div class="block">
                        <label for="fieldEmail" class="text-gray-700 font-bold">Email</label>
                        <input id="fieldEmail" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com">
                    </div>
                    <div class="block">
                        <label for="fieldPassword" class="text-gray-700 font-bold">Пароль</label>
                        <input id="fieldPassword" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="******">
                    </div>
                    <div class="block">
                        <label for="fieldPasswordConfirmation" class="text-gray-700 font-bold">Подтверждение пароля</label>
                        <input id="fieldPasswordConfirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="******">
                    </div>
                    <div class="block">
                        <button type="submit" class="inline-block bg-orange hover:bg-opacity-70 focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Регистрация
                        </button>
                        <a href="/login/" class="inline-block hover:underline focus:outline-none font-bold py-2 px-4 rounded">
                            У меня уже есть аккаунт
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<?php includeTemplate('footer.php'); ?>