<?php

namespace R0aringthunder\RampApi\Utils;

use R0aringthunder\RampApi\Ramp;

class UsersUtil
{
    protected $userData;
    private $utilized = false;

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    public function __call($name, $arguments)
    {
        // When a method is called, switch to using utilities
        $this->utilized = true;
        $userUtils = new UsersUtil($this->userData);

        // Forward the method call to UserUtils instance
        if (method_exists($userUtils, $name)) {
            return call_user_func_array([$userUtils, $name], $arguments);
        }

        throw new \Exception("Method {$name} does not exist in UserUtils.");
    }

    public function __destruct()
    {
        // If no methods were called, it means the user is interested in the raw data
        if (!$this->utilized) {
            // You could directly output data, but consider better patterns for your use case
            echo json_encode($this->userData);
        }
    }

    public function totalSpendThisMonth() {
        // Implementation
        return $this->userData; // Just a placeholder
    }

    private function getUserOwnedCards() {
        return $this->ramp->cards->list(['user_id' => $this->userData['id']])['data'] ?? [];
    }

    public function getAllUserData() {
        $cards = $this->getUserOwnedCards();
        $transactions = $this->ramp->transactions->list(['user_id' => $this->userData['id']])['data'] ?? [];
        $reimbursements = $this->ramp->reimbursements->list(['user_id' => $this->userData['id']])['data'] ?? [];
        $memos = $this->ramp->memos->list(['user_id' => $this->userData['id']])['data'] ?? [];
        $limits = $this->ramp->limits->listLimits(['user_id' => $this->userData['id']])['data'] ?? [];
        return [
            'cards' => $cards,
            'transactions' => $transactions,
            'reimbursements' => $reimbursements,
            'memos' => $memos,
            'limits' => $limits
        ];
    }

    /**
     * Calculates the total spend of the user.
     *
     * @return float The total spend amount.
     */
    public function totalSpendEver(): float {
        $userOwnedCards = $this->getUserOwnedCards();
        $totalClearedAmount = 0;
    
        foreach ($userOwnedCards as $index => $card) {
            $cardId = $card['id'];
            $transactions = (new Ramp)->transactions->list(['card_id' => $cardId])['data'] ?? [];
            
            foreach ($transactions as $transaction) {
                $totalClearedAmount += $transaction['amount'];
            }
        }

        return $totalClearedAmount;
    }    

    /**
     * Calculates the total spend of the user between two dates.
     *
     * @param string $startDate The start date in ISO 8601 format.
     * @param string $endDate The end date in ISO 8601 format.
     * @return float The total spend amount between the given dates.
     */
    public function totalSpendBetween(string $startDate, string $endDate): float {
        $userOwnedCards = $this->getUserOwnedCards();
        $totalAmountBetweenDates = 0;
        
        foreach ($userOwnedCards as $card) {
            $transactions = $this->ramp->transactions->list([
                'user_id' => $this->userData['id'],
                'from_date' => $startDate,
                'to_date' => $endDate,
            ])['data'] ?? [];
            
            foreach ($transactions as $transaction) {
                if ($transaction['card_id'] === $card['id']) {
                    $totalAmountBetweenDates += $transaction['amount'];
                }
            }
        }
    
        return $totalAmountBetweenDates;
    }    

    /**
     * Calculates the total or average spend of the user for a specific period, rounding the average to 2 decimal places.
     * 
     * @param int|null $year Optional. The year of the transactions to include. Defaults to the current year if null.
     * @param int|null $month Optional. The month of the transactions to include. If null, calculates for the entire year.
     * @param int|null $day Optional. The day of the transactions to include. If null, calculates for the entire month.
     * @param bool $calculateAverage Optional. Whether to calculate the average spend instead of the total. Defaults to false.
     * @return float The total or average spend amount for the specified period, with average rounded to 2 decimal places.
     */
    public function totalSpendForPeriod(int $year = null, int $month = null, int $day = null, bool $calculateAverage = false): float {
        $totalAmountForPeriod = 0;
        $transactionCount = 0;
    
        $userOwnedCards = $this->getUserOwnedCards();
        foreach ($userOwnedCards as $card) {
            $queryParams = ['user_id' => $this->userData['id']];
            
            // Default to the current year if not specified
            $currentYear = date('Y');
            $year = $year ?? $currentYear;
    
            // Adjust query based on provided year, month, day
            if ($month === null) {
                $queryParams['from_date'] = "{$year}-01-01T00:00:00+00:00";
                $queryParams['to_date'] = "{$year}-12-31T23:59:59+00:00";
            } else {
                $monthPadded = str_pad($month, 2, '0', STR_PAD_LEFT);
                if ($day === null) {
                    $queryParams['from_date'] = "{$year}-{$monthPadded}-01T00:00:00+00:00";
                    $queryParams['to_date'] = date("{$year}-{$monthPadded}-tT23:59:59+00:00"); 
                } else {
                    $dayPadded = str_pad($day, 2, '0', STR_PAD_LEFT);
                    $queryParams['from_date'] = "{$year}-{$monthPadded}-{$dayPadded}T00:00:00+00:00";
                    $queryParams['to_date'] = "{$year}-{$monthPadded}-{$dayPadded}T23:59:59+00:00";
                }
            }
    
            $transactions = $this->ramp->transactions->list($queryParams)['data'] ?? [];
            foreach ($transactions as $transaction) {
                if ($transaction['card_id'] === $card['id']) {
                    $totalAmountForPeriod += $transaction['amount'];
                    $transactionCount++;
                }
            }
        }
    
        if ($calculateAverage && $transactionCount > 0) {
            return round($totalAmountForPeriod / $transactionCount, 2);
        }
        
        return $totalAmountForPeriod;
    }
}
