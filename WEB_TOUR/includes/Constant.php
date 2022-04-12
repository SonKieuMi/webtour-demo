<?php
class Constant {
    const ROW_PER_PAE = 10;
    public function __construct()
    {
    }
    public static function getNumOfRowPerPage()
    {
        return self::ROW_PER_PAE;
    }
}
?>