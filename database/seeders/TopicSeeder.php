<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    protected array $topics = [
        [
            'name' => 'Reconnaissance',
        ],
        [
            'name' => 'Scanning & Enumeration',
        ],
        [
            'name' => 'Vulnerability Analysis',
        ],
        [
            'name' => 'Exploitation',
        ],
        [
            'name' => 'Privilege Escalation',
        ],
        [
            'name' => 'Post Exploitation',
        ],
        [
            'name' => 'Web Application Testing',
        ],
        [
            'name' => 'Network Penetration',
        ],
        [
            'name' => 'Wireless Attacks',
        ],
        [
            'name' => 'Social Engineering',
        ],
        [
            'name' => 'Password Attacks',
        ],
        [
            'name' => 'Physical Security',
        ],
        [
            'name' => 'Reporting & Documentation',
        ]
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::upsert($this->topics, 'name');
    }
}
