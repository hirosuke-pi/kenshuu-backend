<?php

class Badge extends Component {
    public string $title = '';

    public function init(Badge $props) {
        $this->title = $props->title;
    }
}

$badge = new Badge($_PROPS);

?>

<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
    <i class="fa-solid fa-tag"></i> <?=h($badge->title)?>
</span>
