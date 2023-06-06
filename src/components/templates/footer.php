<?php

class Footer {
    /**
     * フッターをレンダリング
     *
     * @return void
     */
    public static function render(): void {
        ?>
            <hr class="ml-3 mr-3 mt-5">
            <footer class="m-5 flex justify-center">
                <p>Flash News - hirosuke-pi</p>
            </footer>
        <?php
    }
}
