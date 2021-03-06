<?php
declare(strict_types=1);


/*
 * This class helps us find the cost of electricity based on the number of units, company and region
 * */
class Calculator
{
    public $usage = 0;
    public $costRates = [];
    public $subsidy = 0.0;

    public $cost = 0;
    public $savings = 0;

    public function __construct(int $usage, array $costRates, float $subsidy)
    {
        $this->usage = $usage;
        $this->costRates = $costRates;
        $this->subsidy = $subsidy;

    }

    /*
     * This gets the cost of our savings
     *
     * @return float
     * */

    public function getSavings():float{
        return $this->savings;
    }

    /*
     * This gets the cost of our electricity
     *
     * @return float
     * */
    public function getTotalCost():float
    {
        switch ($this->usage) {
            // for the first 50 units
            case $this->usage < 50:
                $this->cost = ($this->costRates[0] * $this->usage);
                break;
            // for the next 100 units
            case $this->usage < 100:
                $this->cost = ($this->costRates[0] * $this->usage);
            // for greater than next 250 units
            case $this->usage > 250:
                $this->cost = ($this->costRates[0] * $this->usage);
        }
        $this->savings = $this->cost * $this->subsidy;
        return $this->cost - $this->savings;
    }


}