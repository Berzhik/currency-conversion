<?php

namespace App\Repository\Currency;

use App\Models\Currency\ExchangeHistory;
use Exception;
use Illuminate\Support\Facades\DB;

class ExchangeHistoryRepository
{
    /**
     * @return string
     */
    public function mostPopularDestination()
    {
        $row = ExchangeHistory::orderBy('count_dest', 'DESC')
            ->groupBy('destination')
            ->get([
                'destination',
                DB::raw('COUNT(destination) as count_dest')
            ])
            ->first();

        if (!$row) {
            throw new Exception('Not enough information to calculate');
        }

        return $row->destination;
    }

    /**
     * @return 
     */
    public function getAllRecords()
    {
        return ExchangeHistory::all();
    }

    /**
     * @return int
     */
    public function totalRequests()
    {
        return ExchangeHistory::count();
    }

    /**
     * @param array $data
     * @return void
     */
    public function addRecord($data)
    {
        ExchangeHistory::create($data)->save();
    }
}