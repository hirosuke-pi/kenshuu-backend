<?php

PageController::sessionStart();
[$head, $header, $footer, $end] = ViewComponent::importTemplates(['head', 'header', 'footer', 'end']);

$error = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $message = PageController::getRedirectData();
        if (!isset($message) || !isset($message['message'])) {
            PageController::redirect('/index.php');
        }

        $values->message = $message['message'];
    },
);
$headProps = ['title' => 'Flash News'];

?>

<?=$head->view($headProps)?>
    <body>
        <?=$header->view()?>
        <main class="flex justify-center flex-col items-center">
            <h2 class="text-2xl">エラー: <?=$error->values->message ?></h2>
            <a href="/" class="mt-5 bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded ">
                <i class="fa-solid fa-arrow-left"></i> ホームへ戻る
            </a>
        </main>
        <?=$footer->view()?>
    </body>
<?=$end->view()?>
