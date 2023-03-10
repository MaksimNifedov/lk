<ul class="list-inside bullet-list-item flex flex-wrap justify-between -mx-5 -my-2">
    <?php foreach ($menu as $item) {
        ?>
        <li class="px-5 py-2"><a class="<?= (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ==  $item['path']) ? "text-orange" : "text-gray-600"; ?>" href=<?= $item['path'] ?>><?= $item['title'] ?></a></li>
    <?php } ?>
</ul>