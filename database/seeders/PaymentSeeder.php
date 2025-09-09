<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $user1 = User::where('email', 'john@example.com')->first();
        $user2 = User::where('email', 'jane@example.com')->first();
        
        // Get courses
        $course1 = Course::find(1);
        $course2 = Course::find(2);
        
        if ($user1 && $course1) {
            // Create registration first
            $registration1 = Registration::create([
                'student_id' => $user1->id,
                'course_id' => $course1->id,
                'semester' => '2025-Ganjil',
                'status' => 'registered'
            ]);
            
            // Create payment for user1
            Payment::create([
                'student_id' => $user1->id,
                'registration_id' => $registration1->id,
                'amount' => 2500000,
                'status' => 'unpaid'
            ]);
        }
        
        if ($user2 && $course2) {
            // Create registration first
            $registration2 = Registration::create([
                'student_id' => $user2->id,
                'course_id' => $course2->id,
                'semester' => '2025-Ganjil',
                'status' => 'registered'
            ]);
            
            // Create payment for user2
            Payment::create([
                'student_id' => $user2->id,
                'registration_id' => $registration2->id,
                'amount' => 3000000,
                'status' => 'unpaid'
            ]);
        }
        
        // Create additional payments for testing
        if ($user1) {
            Payment::create([
                'student_id' => $user1->id,
                'registration_id' => null,
                'amount' => 500000,
                'status' => 'unpaid'
            ]);
        }
    }
}
