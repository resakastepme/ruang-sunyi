<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tampilkan nama penerima
    |--------------------------------------------------------------------------
    |
    | Saat true, nama penerima ("Raya") ditampilkan apa adanya pada catatan
    | khusus (/special-note). Saat false atau tidak diset di .env, nama
    | disamarkan menjadi titik-titik.
    |
    */

    'show_name' => env('SHOW_NAME', false),

];
