<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notice;
use App\Models\User;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users
        $adminUsers = User::where('role', 'admin')->get();
        
        if ($adminUsers->isEmpty()) {
            $this->command->warn('Please run AdminUserSeeder first!');
            return;
        }

        // Create sample notices
        Notice::factory(20)->create([
            'user_id' => $adminUsers->random()->id,
        ]);

        // Create some specific notices for testing
        $testNotices = [
            [
                'title' => 'Midterm Exam Schedule',
                'content' => 'The midterm examination schedule has been published. Please check the notice board for details.',
                'type' => 'exam',
                'priority' => 'high',
                'target_roles' => ['student', 'teacher'],
            ],
            [
                'title' => 'Fee Payment Deadline',
                'content' => 'The deadline for fee payment is approaching. Please complete your payments by the due date.',
                'type' => 'fee',
                'priority' => 'urgent',
                'target_roles' => ['student'],
            ],
            [
                'title' => 'Library Hours Update',
                'content' => 'The library will remain open until 10 PM during exam period.',
                'type' => 'library',
                'priority' => 'medium',
                'target_roles' => ['student', 'teacher', 'staff'],
            ],
            [
                'title' => 'Academic Calendar 2024',
                'content' => 'The academic calendar for 2024 has been published. Please check important dates.',
                'type' => 'academic',
                'priority' => 'medium',
                'target_roles' => ['student', 'teacher'],
            ],
            [
                'title' => 'Campus Maintenance',
                'content' => 'Scheduled maintenance will be conducted this weekend. Some facilities may be temporarily unavailable.',
                'type' => 'general',
                'priority' => 'low',
                'target_roles' => ['student', 'teacher', 'staff'],
            ],
        ];

        foreach ($testNotices as $noticeData) {
            Notice::create([
                'user_id' => $adminUsers->random()->id,
                'title' => $noticeData['title'],
                'content' => $noticeData['content'],
                'type' => $noticeData['type'],
                'priority' => $noticeData['priority'],
                'target_roles' => $noticeData['target_roles'],
                'publish_date' => now()->subDays(rand(1, 30)),
                'expiry_date' => now()->addDays(rand(7, 60)),
                'is_published' => true,
                'is_pinned' => $noticeData['priority'] === 'urgent',
            ]);
        }

        $this->command->info('Notices seeded successfully!');
    }
}
