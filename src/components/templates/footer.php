<?php

class Footer {
    /**
     * フッターをレンダリング
     *
     * @return void
     */
    public static function render(): void {
            echo '<hr class="ml-3 mr-3 mt-5">';
            echo '<footer class="m-5 flex justify-center">';
            echo '<p>Flash News - hirosuke-pi</p>';
            echo '</footer>';
    }
}
