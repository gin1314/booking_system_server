<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{

    const DATA = [
        ['start_time' => '8:00am', 'end_time' => '11:00am'],
        ['start_time' => '1:00pm', 'end_time' => '5:00pm'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('time_slots')->truncate();

        foreach (self::DATA as $value) {
            TimeSlot::create($value);
        }
    }
}
