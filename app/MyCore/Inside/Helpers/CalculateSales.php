<?php
namespace App\MyCore\Inside\Helpers;

/**
* @author Ly Nguyen <huuly188@gmail.com>
*/
trait CalculateSales
{
    /**
     * Calculate Total Sales
     * @author Ly Nguyen <huuly188@gmail.com>
     * @param   string $price     Price
     * @param   string $quantity  Quantity
     * @return  float            Total sale
     */
    public function totalCalculate($price, $quantity)
    {
        return ($price * $quantity);
    }

    /**
     * Calbulate average
     * @author Ly Nguyen <huuly188@gmail.com>
     * @param  float $value     Total value
     * @param  int $numOfDay Num of day
     * @return float            Average value
     */
    public function averageCalculate($value, $numOfDay)
    {
        if($numOfDay > 0) {
            return ($value / $numOfDay);
        }

        return 0;
    }

    public function totalProfit($profit, $totalMoneyInstock)
    {
        if($totalMoneyInstock > 0) {
            return 365 * $profit / $totalMoneyInstock;
        }

        return 0;
    }

}
