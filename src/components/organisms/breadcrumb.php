<?php
class Breadcrumb extends Component {
    public array $paths = [];

    public function init(array $props) {
        $this->paths = $props['paths'];
    }
}

$breadcrumb = new Breadcrumb($_PROPS);
$paths = $breadcrumb->paths;

?>

<div class="flex items-center text-gray-700">
    <a class="ml-1 mr-3 hover:underline " href="/" class="hover:underline">
        <i class="fa-solid fa-house"></i> ホーム
    </a>
    <?php foreach($paths as $path): ?>
        <i class="fa-solid fa-greater-than"></i>
        <a class="mx-3 hover:underline" href="<?=h($path['link'])?>" class="text-gray-700 hover:underline">
            <i class="fa-regular fa-file-lines"></i> <?=h($path['name'])?>
        </a>
    <?php endforeach; ?>
</div>
