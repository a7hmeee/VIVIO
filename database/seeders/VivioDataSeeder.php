<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class VivioDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User
        User::updateOrCreate(
            ['email' => 'admin@vivio.studio'],
            [
                'name' => 'VIVIO Admin',
                'password' => '$2y$12$CsRVy1iGJ6gDJlOl5AHBTuUXyXiQSWnuTvHJKtWMYxvgYb3Zvl57.',
                'is_admin' => true,
                'email_verified_at' => '2026-08-28 14:01:48',
            ]
        );

        // 2. Categories
        $categories = [
            ['id' => 1, 'name' => 'أنظمة حكومية', 'slug' => 'government', 'description' => null],
            ['id' => 2, 'name' => 'تعليم', 'slug' => 'education', 'description' => null],
            ['id' => 3, 'name' => 'أنظمة مخزون', 'slug' => 'inventory', 'description' => null],
            ['id' => 4, 'name' => 'خدمات ميدانية', 'slug' => 'field-service', 'description' => null],
            ['id' => 5, 'name' => 'حجز مواعيد', 'slug' => 'booking', 'description' => null],
            ['id' => 6, 'name' => 'إدارة مدارس', 'slug' => 'school', 'description' => null],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Team Members
        $teamMembers = [
            [
                'id' => 1,
                'name' => 'أحمد',
                'role' => 'Full-Stack Developer',
                'specialty' => 'تطوير الأنظمة والبرمجيات',
                'description' => 'أ responsibly قمنا بالعمل والتطوير من الفكرة إلى النظام الكامل.',
                'skills' => ["Laravel", "Livewire", "React", "AI", "System Architecture"],
                'photo' => null,
                'email' => null,
                'linkedin' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'id' => 2,
                'name' => 'أحمد',
                'role' => 'Digital Marketer',
                'specialty' => 'التسويق الرقمي والاستراتيجيات',
                'description' => 'نبني الاستراتيجيات وأوصل خدماتنا للعملاء الم TARGETين.',
                'skills' => ["Digital Marketing", "SEO", "Content Strategy", "Analytics"],
                'photo' => null,
                'email' => null,
                'linkedin' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($teamMembers as $tm) {
            TeamMember::updateOrCreate(['name' => $tm['name'], 'role' => $tm['role']], $tm);
        }

        // 4. Projects
        $projects = [
            [
                'id' => 1,
                'category_id' => 1,
                'title' => 'نظام إدارة خدمات البلدية',
                'slug' => 'municipality-services',
                'short_description' => 'منصة متكاملة لإدارة الطلبات والتقنيات والأنظمة البلدية بكفاءة عالية.',
                'client' => 'بلدية',
                'featured_image' => 'projects/images/01M178P6MMWWRGGSQ9XZ252C4E.png',
                'video' => null,
                'problem' => 'كانت الطلبات ت arrive عبر قنوات متعددة بدون ت SYSTEM م統一.',
                'solution' => 'بنينا نظاماً متكاملاً لإدارة الطلبات مع لوحة تحكم ذكية.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'تقليل 75% في وقت الاستجابة وزيادة رضا المواطنين.',
                'technologies' => ["Laravel", "Livewire", "React", "MySQL", "Tailwind", "PDF"],
                'year' => 2024,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => '2026-06-28 14:01:48',
                'sort_order' => 1,
                'desktop_image' => 'projects/images/01M178P6N047ZTKCX8QFX3Y0KX.png',
                'mobile_image' => 'projects/images/01M178P6N9B565G4KHYH6W6VQ3.jpeg',
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'title' => 'منصة أكاديمية للقدس التعليمية',
                'slug' => 'education-platform',
                'short_description' => 'منصة تعليمية متكاملة تعتمد على الدورات، الاختبارات، والشهادات الرقمية.',
                'client' => 'جهة تعليمية',
                'featured_image' => null,
                'video' => null,
                'problem' => 'احتياج لمنصة تعليمية متكاملة تدعم التعلم عن بعد.',
                'solution' => 'منصة تعليمية بأدوات تفاعلية ولوحات تحكم.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'زيادة التفاعل بنسبة 60% وتحسين نتائج التعلم.',
                'technologies' => ["Laravel", "React", "WebRTC", "Video Streaming", "AWS"],
                'year' => 2024,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2026-05-28 14:01:48',
                'sort_order' => 2,
                'desktop_image' => null,
                'mobile_image' => null,
            ],
            [
                'id' => 3,
                'category_id' => 3,
                'title' => 'نظام إدارة المخزون والمستودعات',
                'slug' => 'inventory-system',
                'short_description' => 'نظام متكامل لإدارة المخزون والمستودعات مع تقارير دقيقة.',
                'client' => 'شركة تجارية',
                'featured_image' => null,
                'video' => null,
                'problem' => 'صعوبة تتبع المخزون وأ-stock-outs المتكررة.',
                'solution' => 'نظام إدارة مخزون ذكي مع تكامل نقاط البيع.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'تقليل التكاليف بنسبة 40% وتحسين الدقة.',
                'technologies' => ["Laravel", "Livewire", "MySQL", "Redis", "Barcode"],
                'year' => 2024,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2026-04-28 14:01:48',
                'sort_order' => 3,
                'desktop_image' => null,
                'mobile_image' => null,
            ],
            [
                'id' => 4,
                'category_id' => 4,
                'title' => 'تطبيقات خدمات ميدانية',
                'slug' => 'field-service-apps',
                'short_description' => 'تطبيقات موبايل لإدارة الفرق الميدانية.',
                'client' => 'شركة خدمات',
                'featured_image' => null,
                'video' => null,
                'problem' => 'صعوبة إدارة الفرق الميدانية وتتبع المهام.',
                'solution' => 'تطبيقات موبايل مع لوحة تحكم مركزية.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'زيادة كفاءة الفرق بنسبة 50%.',
                'technologies' => ["React Native", "Laravel API", "GPS Tracking", "Firebase"],
                'year' => 2024,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2026-03-28 14:01:48',
                'sort_order' => 4,
                'desktop_image' => null,
                'mobile_image' => null,
            ],
            [
                'id' => 5,
                'category_id' => 5,
                'title' => 'منصة حجز المواعيد',
                'slug' => 'booking-platform',
                'short_description' => 'منصة حجز مواعيد ذكية مع إدارة أتمتة.',
                'client' => 'عيادة',
                'featured_image' => null,
                'video' => null,
                'problem' => 'تعارض المواعيد وصعوبة الجدولة اليدوية.',
                'solution' => 'منصة حجز ذكية مع تذكيرات تلقائية.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'تقليل الإلغاءات بنسبة 70% وزيادة الإنتاجية.',
                'technologies' => ["Laravel", "Livewire", "MySQL", "Tailwind", "Pusher"],
                'year' => 2024,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2026-02-28 14:01:48',
                'sort_order' => 5,
                'desktop_image' => null,
                'mobile_image' => null,
            ],
            [
                'id' => 6,
                'category_id' => 6,
                'title' => 'نظام إدارة المدارس',
                'slug' => 'school-management',
                'short_description' => 'نظام متكامل لإدارة المدارس والطلاب والمنهاج.',
                'client' => 'مدرسة',
                'featured_image' => null,
                'video' => null,
                'problem' => 'إدارة البيانات اليدوية تستغرق وقتاً طويلاً.',
                'solution' => 'نظام متكامل لإدارة الطلاب والدرجات والحضور.',
                'approach' => 'تحليل شامل للمتطلبات ثم تصميم وتطوير متدرج.',
                'result' => 'توفير 80% من الوقت الإداري.',
                'technologies' => ["Laravel", "React", "Charts", "Export System", "Tailwind"],
                'year' => 2024,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2026-01-28 14:01:48',
                'sort_order' => 6,
                'desktop_image' => null,
                'mobile_image' => null,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 5. Project Team Members (pivot)
        $pivotData = [
            ['project_id' => 1, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 70],
            ['project_id' => 1, 'team_member_id' => 2, 'role_on_project' => 'التسويق', 'contribution_percent' => 30],
            ['project_id' => 2, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 100],
            ['project_id' => 3, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 100],
            ['project_id' => 4, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 80],
            ['project_id' => 4, 'team_member_id' => 2, 'role_on_project' => 'التسويق', 'contribution_percent' => 20],
            ['project_id' => 5, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 80],
            ['project_id' => 5, 'team_member_id' => 2, 'role_on_project' => 'التسويق', 'contribution_percent' => 20],
            ['project_id' => 6, 'team_member_id' => 1, 'role_on_project' => 'المطور المسؤول', 'contribution_percent' => 80],
            ['project_id' => 6, 'team_member_id' => 2, 'role_on_project' => 'التسويق', 'contribution_percent' => 20],
        ];

        \DB::table('project_team_members')->truncate();
        foreach ($pivotData as $p) {
            \DB::table('project_team_members')->insert(array_merge($p, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
