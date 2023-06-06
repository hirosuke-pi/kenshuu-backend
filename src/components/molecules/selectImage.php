<?php

class SelectImage {
    /**
     * 画像選択コンポーネントをレンダリング
     *
     * @param string $name inputタグのname属性
     * @param ?string $src 画像ソース
     * @param bool $visibleSelectButton 画像選択ボタンを表示するかどうか
     * @return void
     */
    public static function render(string $name, ?string $src = null, bool $visibleSelectButton = true): void {
        $buttonId = $name .'-button';
        $inputId = $name;
        $imgId = $name .'-preview';

        if (is_null($src)) {
            $src = '/img/news.jpg';
        }

        ?>
            <?php if ($visibleSelectButton): ?>
                <div class="w-full relative">
                    <img id="<?=$imgId?>" class="w-full" src="<?=$src?>" alt="news image">
                    <input id="<?=$inputId?>" class="hidden" type="file" name="<?=$inputId?>" accept="image/*">
                    <div class="absolute top-0 right-0">
                        <button id="<?=$buttonId?>" type="button" type="button" class="m-2 px-3 py-2 text-xl border border-gray-400 bg-gray-100 rounded-full opacity-80 hover:opacity-100" >
                            <i class="fa-solid fa-upload"></i>
                        </button>
                    </div>
                </div>
                <script>
                    document.getElementById('<?=$buttonId?>')?.addEventListener('click', (event) => {
                        document.getElementById('<?=$inputId?>')?.click();
                    });
                    document.getElementById('<?=$inputId?>')?.addEventListener('change', (event) => {
                        const file = event.target.files[0];
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => {
                            document.getElementById('<?=$imgId?>')?.setAttribute('src', reader.result);
                        };
                    });
                </script>
            <?php else: ?>
                <img id="<?=$imgId?>" class="w-full" src="<?=$src?>" alt="news image">
            <?php endif; ?>
        <?php
    }
}
