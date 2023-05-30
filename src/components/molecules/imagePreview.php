<?php

$imagePreview = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $values->buttonId = $props['name'] .'-button';
        $values->inputId = $props['name'];
        $values->imgId = $props['name'] .'-preview';

        $values->src = '/img/news.jpg';
        if (isset($props['src'])) {
            $values->src = $props['src'];
        }
    },
    propTypes: ['name' => 'string']
)

?>

<div class="w-full relative">
    <img id="<?=$imagePreview->values->imgId?>" class="w-full" src="<?=$imagePreview->values->src?>" alt="news image">
    <input id="<?=$imagePreview->values->inputId?>" class="hidden" type="file" name="<?=$imagePreview->values->inputId?>">
    <div class="absolute top-0 right-0">
        <button id="<?=$imagePreview->values->buttonId?>" type="button" type="button" class="m-2 px-3 py-2 text-xl border border-gray-400 bg-gray-100 rounded-full opacity-80 hover:opacity-100" >
            <i class="fa-solid fa-upload"></i>
        </button>
    </div>
</div>
<script>
    document.getElementById('<?=$imagePreview->values->buttonId?>')?.addEventListener('click', (event) => {
        document.getElementById('<?=$imagePreview->values->inputId?>')?.click();
        console.log('aaaaaa')
    });
    document.getElementById('<?=$imagePreview->values->inputId?>')?.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            document.getElementById('<?=$imagePreview->values->imgId?>')?.setAttribute('src', reader.result);
        };
    });
</script>
