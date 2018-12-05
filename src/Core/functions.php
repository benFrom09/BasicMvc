<?php



function d(...$vars) {
    echo '<pre><div class="container"><h3>debug: <hr></h3><p class="card" style="padding:20px;background:#222;color:red;">';
    var_dump($vars);
    echo '</p></div></pre>';
}