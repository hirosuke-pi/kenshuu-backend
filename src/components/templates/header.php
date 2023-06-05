<?php

class Header {
    public static function render(): void {
        ?>
            <header class="flex justify-center mt-10 mb-3">
                <h1 class="text-6xl text-gray-800 font-bold"><i class="fa-solid fa-bolt-lightning"></i> Flash News</h1>
            </header>
            <hr class="ml-3 mr-3 mb-5"/>
        <?php
    }
}
