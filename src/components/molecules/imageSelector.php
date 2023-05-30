<?php

$imageSelector = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props): void {
        $values->buttonId = $props['name'] .'-button';
        $values->inputId = $props['name'];
        $values->imgId = $props['name'] .'-preview';

        $values->src = '/img/news.jpg';
        $values->viewOnly = false;
        if (isset($props['src'])) {
            $values->src = $props['src'];
        }
        if (isset($props['viewOnly'])) {
            $values->viewOnly = $props['viewOnly'];
        }
    },
    propTypes: ['name' => 'string']
);

?>

<?php if ($imageSelector->values->viewOnly): ?>
    <img id="<?=$imageSelector->values->imgId?>" class="w-full" src="<?=$imageSelector->values->src?>" alt="news image">
<?php else: ?>
    <div class="w-full relative">
        <img id="<?=$imageSelector->values->imgId?>" class="w-full" src="<?=$imageSelector->values->src?>" alt="news image">
        <input id="<?=$imageSelector->values->inputId?>" class="hidden" type="file" name="<?=$imageSelector->values->inputId?>" accept="image/*">
        <div class="absolute top-0 right-0">
            <button id="<?=$imageSelector->values->buttonId?>" type="button" type="button" class="m-2 px-3 py-2 text-xl border border-gray-400 bg-gray-100 rounded-full opacity-80 hover:opacity-100" >
                <i class="fa-solid fa-upload"></i>
            </button>
        </div>
    </div>
    <script>
        document.getElementById('<?=$imageSelector->values->buttonId?>')?.addEventListener('click', (event) => {
            document.getElementById('<?=$imageSelector->values->inputId?>')?.click();
        });
        document.getElementById('<?=$imageSelector->values->inputId?>')?.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                document.getElementById('<?=$imageSelector->values->imgId?>')?.setAttribute('src', reader.result);
            };
        });
    </script>
<?php endif; ?>
