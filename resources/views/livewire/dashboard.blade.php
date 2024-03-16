<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <div class="grid grid-cols-2">
        <div class="row-span-3 border">Основное окно</div>
        <div class="min-h-32 border">Блок 1</div>
        <div class="min-h-32 border">Блок 2</div>
        <div class="min-h-32 border">Блок 3</div>
        <div class="col-span-2 min-h-5 border">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
    </div>
</div>
