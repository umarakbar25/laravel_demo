<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scores = collect([
            ['score' => 76, 'team' => 'A'],
            ['score' => 62, 'team' => 'B'],
            ['score' => 82, 'team' => 'C'],
            ['score' => 86, 'team' => 'D'],
            ['score' => 91, 'team' => 'E'],
            ['score' => 67, 'team' => 'F'],
            ['score' => 67, 'team' => 'G'],
            ['score' => 82, 'team' => 'H'],
        ]);

        $ranked = $this->rankWiseScore($scores);
        echo json_encode($ranked);
    }

    public function mvs()
    {
        $employees = collect([
            [
                'name' => 'John',
                'email' => 'john3@example.com',
                'sales' => [
                    ['customer' => 'The Blue Rabbit Company', 'order_total' => 7444],
                    ['customer' => 'Black Melon', 'order_total' => 1445],
                    ['customer' => 'Foggy Toaster', 'order_total' => 700],
                ],
            ],
            [
                'name' => 'Jane',
                'email' => 'jane8@example.com',
                'sales' => [
                    ['customer' => 'The Grey Apple Company', 'order_total' => 203],
                    ['customer' => 'Yellow Cake', 'order_total' => 8730],
                    ['customer' => 'The Piping Bull Company', 'order_total' => 3337],
                    ['customer' => 'The Cloudy Dog Company', 'order_total' => 5310],
                ],
            ],
            [
                'name' => 'Dave',
                'email' => 'dave1@example.com',
                'sales' => [
                    ['customer' => 'The Acute Toaster Company', 'order_total' => 1091],
                    ['customer' => 'Green Mobile', 'order_total' => 2370],
                ],
            ],
        ])->pluck('sales')
            ->flatten(1)
            ->groupBy('customer')
            ->map(function ($groupedSales, $customer) {
                return $groupedSales->sum('order_total');
            })
            ->sort()
            ->reverse()
            ->keys()
            ->first();

        echo json_encode($employees);
    }



    private function rankWiseScore($scores)
    {
        return collect($scores)
            ->sortByDesc('score')
            ->zip(range(1, $scores->count()))
            ->map(function ($scoreAndRank) {
                list($score, $rank) = $scoreAndRank;
                return array_merge($score, [
                    'Rank' => $rank
                ]);
            })
            ->groupBy('score')
            ->map(function ($equalScores) {
                $lowestRank = $equalScores->pluck('Rank')->min();
                return $equalScores->map(function ($rankedScore) use ($lowestRank) {
                    return array_merge($rankedScore, [
                        'Rank' => $lowestRank,
                    ]);
                });
            })
            ->collapse()
            ->sortBy('Rank');
    }
}
