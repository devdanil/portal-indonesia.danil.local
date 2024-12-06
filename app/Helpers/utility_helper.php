<?php

function statusPelkauUsaaha($payload)
{

    $status = "-";

    switch ($payload) {
        case '1':
            $status = '<span class="badge badge-success">Aktif</span>';
            break;
        case '2':
            $status = '<span class="badge badge-secondary">Tidak Aktif</span>';
            break;
    }

    return $status;
}
