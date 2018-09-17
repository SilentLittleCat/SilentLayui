<?php

use Illuminate\Database\Seeder;

class AdminActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = collect(['还款功能', '续期功能', '催收功能', '一催功能', '逾期分配功能', '拉回功能']);
        foreach ($items as $item) {
            \App\Models\AdminAction::firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
