<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\AccessPoint;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@uin.ac.id',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        $admin1 = User::create([
            'name' => 'Admin PSB',
            'email' => 'admin.psb@uin.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'unit_kerja' => 'PSB',
        ]);

        $admin2 = User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin.perpus@uin.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'unit_kerja' => 'Perpustakaan',
        ]);

        // Create Buildings
        $buildings = [
            [
                'name' => 'Gedung Rektorat',
                'total_floors' => 3,
                'shape_type' => 'rectangle',
                'width' => 120,
                'height' => 180,
                'position_x' => 200,
                'position_y' => 150,
                'color' => '#5eead4',
            ],
            [
                'name' => 'Gedung Perpustakaan',
                'total_floors' => 4,
                'shape_type' => 'l_shape',
                'width' => 150,
                'height' => 200,
                'position_x' => 400,
                'position_y' => 100,
                'color' => '#5eead4',
            ],
            [
                'name' => 'Gedung PSB',
                'total_floors' => 3,
                'shape_type' => 'rectangle',
                'width' => 130,
                'height' => 170,
                'position_x' => 400,
                'position_y' => 350,
                'color' => '#5eead4',
            ],
            [
                'name' => 'Gedung Audit',
                'total_floors' => 2,
                'shape_type' => 'square',
                'width' => 100,
                'height' => 100,
                'position_x' => 600,
                'position_y' => 250,
                'color' => '#5eead4',
            ],
        ];

        foreach ($buildings as $buildingData) {
            $building = Building::create($buildingData);

            // Create Floors for each building
            for ($i = 1; $i <= $building->total_floors; $i++) {
                $floor = Floor::create([
                    'building_id' => $building->id,
                    'floor_number' => $i,
                    'name' => "Lantai {$i}",
                ]);

                // Create Rooms for each floor
                $roomsCount = rand(3, 6);
                for ($j = 1; $j <= $roomsCount; $j++) {
                    $room = Room::create([
                        'floor_id' => $floor->id,
                        'name' => $this->generateRoomName($building->name, $j),
                        'shape_type' => $this->getRandomShape(),
                        'width' => rand(100, 200),
                        'height' => rand(100, 180),
                        'position_x' => ($j - 1) * 220 + 50,
                        'position_y' => 100,
                        'color' => '#bfdbfe',
                    ]);

                    // Create Access Points for each room
                    $apCount = rand(1, 3);
                    for ($k = 1; $k <= $apCount; $k++) {
                        $status = $this->getRandomStatus();
                        AccessPoint::create([
                            'room_id' => $room->id,
                            'name' => "{$building->name}-L{$i}-R{$j}-AP{$k}",
                            'status' => $status,
                            'position_x' => rand(20, $room->width - 20),
                            'position_y' => rand(20, $room->height - 20),
                            'notes' => $status === 'maintenance' ? 'Scheduled maintenance' : null,
                        ]);
                    }
                }
            }
        }

        // Create some sample tickets
        $accessPoints = AccessPoint::where('status', 'offline')->take(3)->get();
        
        foreach ($accessPoints as $ap) {
            Ticket::create([
                'access_point_id' => $ap->id,
                'admin_id' => $admin1->id,
                'category' => 'Koneksi Terputus',
                'description' => 'Access point tidak dapat diakses, koneksi terputus sejak pagi ini.',
                'status' => 'open',
            ]);
        }

        $resolvedAp = AccessPoint::where('status', 'active')->first();
        if ($resolvedAp) {
            Ticket::create([
                'access_point_id' => $resolvedAp->id,
                'admin_id' => $admin2->id,
                'category' => 'Koneksi Lambat',
                'description' => 'Koneksi internet sangat lambat di area perpustakaan.',
                'status' => 'resolved',
                'resolved_at' => now()->subDays(1),
                'resolved_by' => $superadmin->id,
                'resolution_notes' => 'Telah dilakukan restart router dan konfigurasi ulang.',
            ]);
        }

        echo "✅ Database seeded successfully!\n";
        echo "📧 Superadmin: superadmin@uin.ac.id / password\n";
        echo "📧 Admin PSB: admin.psb@uin.ac.id / password\n";
        echo "📧 Admin Perpus: admin.perpus@uin.ac.id / password\n";
    }

    private function generateRoomName(string $buildingName, int $number): string
    {
        $types = ['Lab Komputer', 'Ruang Kelas', 'Ruang Dosen', 'Ruang Seminar', 'Kantor'];
        return $types[array_rand($types)] . " {$number}";
    }

    private function getRandomShape(): string
    {
        $shapes = ['rectangle', 'square', 'l_shape'];
        return $shapes[array_rand($shapes)];
    }

    private function getRandomStatus(): string
    {
        $statuses = [
            'active' => 70,      // 70% active
            'offline' => 20,     // 20% offline
            'maintenance' => 10, // 10% maintenance
        ];

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($statuses as $status => $percentage) {
            $cumulative += $percentage;
            if ($rand <= $cumulative) {
                return $status;
            }
        }

        return 'active';
    }
}