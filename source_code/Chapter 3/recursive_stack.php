<?php
function sum($start) {

echo "---\n";
debug_print_backtrace();

    if ($start < 2) {

        return 1;

    } else {

        return $start + sum($start-1);
    }
}

echo "The result is : ".sum(4);
