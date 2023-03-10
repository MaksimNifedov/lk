<?php
include $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';
if (!authorizationVerification()) {
    header("Location: /login/");
}
$infoAboutUser = getUserData();
includeTemplate('header.php'); ?>
<main class="flex-1 container mx-auto bg-white overflow-hidden px-4 sm:px-6">
    <div class="py-4 pb-8 space-y-2">
        <h1 class="text-black text-3xl font-bold mb-4">Личный кабинет</h1>

        <div class="space-y-2">
            <div class="space-y-2 pb-4 border-b">
                <p class="text-xl">Мои профиль</p>

                <div class="flex max-w-xl">
                    <div class="flex-1 border px-4 py-2 bg-gray-200 font-bold">ФИО</div>
                    <div class="flex-1 border px-4 py-2"><?= $infoAboutUser[0]['FIO'] ?></div>
                </div>
                <div class="flex max-w-xl">
                    <div class="flex-1 border px-4 py-2 bg-gray-200 font-bold">Email</div>
                    <div class="flex-1 border px-4 py-2"><?= $infoAboutUser[0]['email'] ?></div>
                </div>
                <div class="flex max-w-xl">
                    <div class="flex-1 border px-4 py-2 bg-gray-200 font-bold">Телефон</div>
                    <div class="flex-1 border px-4 py-2"><?= $infoAboutUser[0]['phone'] ?></div>
                </div>
                <div class="flex max-w-xl">
                    <div class="flex-1 border px-4 py-2 bg-gray-200 font-bold">Активность</div>
                    <div class="flex-1 border px-4 py-2"><?= $infoAboutUser[0]['active'] == 1 ? "Да" : "Нет"; ?></div>
                </div>
                <div class="flex max-w-xl">
                    <div class="flex-1 border px-4 py-2 bg-gray-200 font-bold">Подписан на рассылку</div>
                    <div class="flex-1 border px-4 py-2"><?= $infoAboutUser[0]['mailing'] == 1 ? "Да" : "Нет"; ?></div>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <p class="text-xl">Мои группы</p>

            <ul class="list-inside list-disc">
                <?php foreach ($infoAboutUser[1] as $group) { ?>
                    <li><span class="font-bold"><?= $group['name'] ?></span> - <?= $group['description'] ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</main>
<?php includeTemplate('footer.php'); ?>