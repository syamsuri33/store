<?php
class Helper {
    public static function formatRupiah($number) {
        return number_format($number, 0, ',', '.');
    }
}
?>