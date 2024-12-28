<?php

namespace Database\Seeders;

use App\Models\WorkerSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkerScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $s1 = new WorkerSchedule();
        $s1->type = 1;
        $s1->start_week_day = 0;
        $s1->end_week_day = 6;
        $s1->start_time = '00:00:00';
        $s1->end_time = '23:59:59';
        $s1->minimum_time_between_calls = 1800;
        $s1->save();

        $s2 = new WorkerSchedule();
        $s2->type = 2;
        $s2->start_week_day = 0;
        $s2->end_week_day = 6;
        $s2->start_time = '00:00:00';
        $s2->end_time = '23:59:59';
        $s2->minimum_time_between_calls = 300;
        $s2->save();

        $s3 = new WorkerSchedule();
        $s3->type = 3;
        $s3->start_week_day = 0;
        $s3->end_week_day = 6;
        $s3->start_time = '00:00:00';
        $s3->end_time = '23:59:59';
        $s3->minimum_time_between_calls = 180;
        $s3->save();
    }
}
