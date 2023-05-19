<?php

if (!function_exists('arr_expand')) {
    function arr_expand(&$data): void
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $e = explode('.', $k);
                $a = array_shift($e);

                if (1 === count($e)) {
                    $data[$a][$e[0]] = $v;
                } elseif (count($e) > 1) {
                    $data[$a][implode('.', $e)] = $v;
                }
            }

            foreach ($data as $k => $v) {
                arr_expand($data[$k]);

                if (str_contains($k, '.')) {
                    unset($data[$k]);
                }
            }
        }
    }
}
