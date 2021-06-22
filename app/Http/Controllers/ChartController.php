<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Child;
use App\Category;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function view(Request $request) {
        return view('charts.view');
    }

    // API

    public function generate_chart(Request $request, $hash, $category_id, $start, $end) {
        $child = Child::getChildByHash($hash);

        if (!$child) {
            return response('The child data does not exist.', 404);
        }

        $entries = Category::where('id', $category_id)
            ->with(['TrackerEntries' => function($q) use ($child, $start, $end) {
                $q->where('child_id', $child->id)
                    ->whereBetween(
                        'entry_datetime',
                        [$start . ' 00:00:00',
                        $end . ' 23:59:59']
                    );
            }])
            ->first()->toArray();

        // Date Range will e converted to labels

        $chart_labels = [];

        $label_start = Carbon::parse($start . ' 00:00:00');
        $label_end = Carbon::parse($end . ' 23:59:59');
        $range = $label_start->diffInDays($label_end);

        for ($i = 0; $i <= $range; $i++) {
            $label_to_add = Carbon::parse($start . ' 00:00:00')->addDays($i);
            $chart_labels[] = $label_to_add->format('m/d/y');
        }

        $chart_data = [];

        foreach ($chart_labels as $date) {
            $amount = 0;

            foreach ($entries['tracker_entries'] as $entry) {
                // Check if there's a label for this date
                $entry_datetime = Carbon::parse($entry['entry_datetime'])->format('m/d/y');

                if ($date === $entry_datetime) {
                    $amount += $entry['value'] ?: 1;
                }
            }

            $chart_data[] = $amount;
        }

        return [
            'category' => $entries,
            'labels' => $chart_labels,
            'data' => $chart_data,
            'entry_count' => count($entries['tracker_entries']),
            'entry_total_value' => array_sum($chart_data)
        ];
            
    }
}
