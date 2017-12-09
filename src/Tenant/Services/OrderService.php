<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/8
 * Time: 上午11:21
 */

namespace Larasaas\Services;


class OrderService
{
    /**
     * 計算折扣
     * @param int $qty
     * @return float
     */
    public function getDiscount($qty)
    {
        if ($qty == 1) {
            return 1.0;
        } elseif ($qty == 2) {
            return 0.9;
        } elseif ($qty == 3) {
            return 0.8;
        } else {
            return 0.7;
        }
    }

    /**
     * 計算最後價錢
     * @param integer $qty
     * @param float $discount
     * @return float
     */
    public function getTotal($qty, $discount)
    {
        return 500 * $qty * $discount;
    }
}