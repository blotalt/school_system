<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name'        => 'Chan Prak',
                'khmer_name'  => 'ចាន់ ប្រាក់',
                'email'       => 'chan.prak@school.test',
                'gender'      => 'male',
                'dob'         => '1982-03-15',
                'phone'       => '012-345-001',
                'specialty'   => 'History',
                'subjects'    => ['History'],
                'classes'     => ['Grade 10-A', 'Grade 11-A'],
            ],
            [
                'name'        => 'Samnang Sok',
                'khmer_name'  => 'សំណាង សុក',
                'email'       => 'samnang.sok@school.test',
                'gender'      => 'male',
                'dob'         => '1980-07-22',
                'phone'       => '012-345-002',
                'specialty'   => 'History',
                'subjects'    => ['History'],
                'classes'     => ['Grade 10-B', 'Grade 11-B'],
            ],
            [
                'name'        => 'Davin Hor',
                'khmer_name'  => 'ដាវីន ហ',
                'email'       => 'davin.hor@school.test',
                'gender'      => 'male',
                'dob'         => '1985-11-08',
                'phone'       => '012-345-003',
                'specialty'   => 'Geography',
                'subjects'    => ['Geography'],
                'classes'     => ['Grade 12-A'],
            ],
            [
                'name'        => 'Vanna Heng',
                'khmer_name'  => 'វ័ណ្ណ ហេង',
                'email'       => 'vanna.heng@school.test',
                'gender'      => 'female',
                'dob'         => '1988-05-30',
                'phone'       => '012-345-004',
                'specialty'   => 'Geography',
                'subjects'    => ['Geography'],
                'classes'     => ['Grade 12-B'],
            ],
            [
                'name'        => 'Rattana Nguon',
                'khmer_name'  => 'រតនា នួន',
                'email'       => 'rattana.nguon@school.test',
                'gender'      => 'female',
                'dob'         => '1990-02-14',
                'phone'       => '012-345-005',
                'specialty'   => 'Mathematics',
                'subjects'    => ['Mathematics'],
                'classes'     => ['Grade 10-A', 'Grade 10-B'],
            ],
            [
                'name'        => 'Thida Meas',
                'khmer_name'  => 'ធីដា មាស',
                'email'       => 'thida.meas@school.test',
                'gender'      => 'female',
                'dob'         => '1987-09-18',
                'phone'       => '012-345-006',
                'specialty'   => 'Mathematics',
                'subjects'    => ['Mathematics'],
                'classes'     => ['Grade 11-A', 'Grade 11-B'],
            ],
            [
                'name'        => 'Vibol Sok',
                'khmer_name'  => 'វិបុល សុក',
                'email'       => 'vibol.sok@school.test',
                'gender'      => 'male',
                'dob'         => '1983-12-05',
                'phone'       => '012-345-007',
                'specialty'   => 'Mathematics',
                'subjects'    => ['Mathematics'],
                'classes'     => ['Grade 12-A', 'Grade 12-B'],
            ],
            [
                'name'        => 'Sovann Va',
                'khmer_name'  => 'សុវណ្ណ វ៉ា',
                'email'       => 'sovann.va@school.test',
                'gender'      => 'male',
                'dob'         => '1979-06-20',
                'phone'       => '012-345-008',
                'specialty'   => 'Chemistry',
                'subjects'    => ['Chemistry'],
                'classes'     => [],
            ],
            [
                'name'        => 'Kanha Ros',
                'khmer_name'  => 'កញ្ញា រស',
                'email'       => 'kanha.ros@school.test',
                'gender'      => 'female',
                'dob'         => '1991-04-03',
                'phone'       => '012-345-009',
                'specialty'   => 'Chemistry',
                'subjects'    => ['Chemistry'],
                'classes'     => [],
            ],
            [
                'name'        => 'Vannak Seng',
                'khmer_name'  => 'វណ្ណក សេង',
                'email'       => 'vannak.seng@school.test',
                'gender'      => 'male',
                'dob'         => '1986-08-11',
                'phone'       => '012-345-010',
                'specialty'   => 'Physics',
                'subjects'    => ['Physics'],
                'classes'     => [],
            ],
            [
                'name'        => 'Sreymom Sar',
                'khmer_name'  => 'ស្រីមំ សារ',
                'email'       => 'sreymom.sar@school.test',
                'gender'      => 'female',
                'dob'         => '1989-01-25',
                'phone'       => '012-345-011',
                'specialty'   => 'Physics',
                'subjects'    => ['Physics'],
                'classes'     => [],
            ],
            [
                'name'        => 'Chantha Va',
                'khmer_name'  => 'ចាន់ថា វ៉ា',
                'email'       => 'chantha.va@school.test',
                'gender'      => 'female',
                'dob'         => '1984-10-07',
                'phone'       => '012-345-012',
                'specialty'   => 'English',
                'subjects'    => ['English'],
                'classes'     => [],
            ],
            [
                'name'        => 'Vibol Seng',
                'khmer_name'  => 'វិបុល សេង',
                'email'       => 'vibol.seng@school.test',
                'gender'      => 'male',
                'dob'         => '1981-03-28',
                'phone'       => '012-345-013',
                'specialty'   => 'English',
                'subjects'    => ['English'],
                'classes'     => [],
            ],
            [
                'name'        => 'Chan Meas',
                'khmer_name'  => 'ចាន់ មាស',
                'email'       => 'chan.meas@school.test',
                'gender'      => 'female',
                'dob'         => '1992-07-16',
                'phone'       => '012-345-014',
                'specialty'   => 'Biology',
                'subjects'    => ['Biology'],
                'classes'     => [],
            ],
            [
                'name'        => 'Vichea Va',
                'khmer_name'  => 'វិចា វ៉ា',
                'email'       => 'vichea.va@school.test',
                'gender'      => 'male',
                'dob'         => '1978-11-19',
                'phone'       => '012-345-015',
                'specialty'   => 'Biology',
                'subjects'    => ['Biology'],
                'classes'     => [],
            ],
            [
                'name'        => 'Sothea Meas',
                'khmer_name'  => 'សុធា មាស',
                'email'       => 'sothea.meas@school.test',
                'gender'      => 'male',
                'dob'         => '1977-05-04',
                'phone'       => '012-345-016',
                'specialty'   => 'Computer Science',
                'subjects'    => ['Computer Science'],
                'classes'     => [],
            ],
            [
                'name'        => 'Kunthea Sam',
                'khmer_name'  => 'គុណ្ឋា សាម',
                'email'       => 'kunthea.sam@school.test',
                'gender'      => 'female',
                'dob'         => '1993-09-09',
                'phone'       => '012-345-017',
                'specialty'   => 'Computer Science',
                'subjects'    => ['Computer Science'],
                'classes'     => [],
            ],
            [
                'name'        => 'Sophea Heng',
                'khmer_name'  => 'សំភារ ហេង',
                'email'       => 'sophea.heng@school.test',
                'gender'      => 'male',
                'dob'         => '1975-12-31',
                'phone'       => '012-345-018',
                'specialty'   => 'Khmer Literature',
                'subjects'    => ['Khmer Literature'],
                'classes'     => [],
            ],
            [
                'name'        => 'Chenda Tan',
                'khmer_name'  => 'ចេន្ទា តាន',
                'email'       => 'chenda.tan@school.test',
                'gender'      => 'female',
                'dob'         => '1994-02-22',
                'phone'       => '012-345-019',
                'specialty'   => 'Khmer Literature',
                'subjects'    => ['Khmer Literature'],
                'classes'     => [],
            ],
            [
                'name'        => 'Sokha Va',
                'khmer_name'  => 'សុខា វ៉ា',
                'email'       => 'sokha.va@school.test',
                'gender'      => 'male',
                'dob'         => '1982-08-14',
                'phone'       => '012-345-020',
                'specialty'   => 'Earth Science',
                'subjects'    => ['Earth Science'],
                'classes'     => [],
            ],
            [
                'name'        => 'Pisey Ouk',
                'khmer_name'  => 'ពិសី អ៊ុក',
                'email'       => 'pisey.ouk@school.test',
                'gender'      => 'female',
                'dob'         => '1988-06-06',
                'phone'       => '012-345-021',
                'specialty'   => 'Morality & Civics',
                'subjects'    => ['Morality & Civics'],
                'classes'     => [],
            ],
            [
                'name'        => 'Dara Pich',
                'khmer_name'  => 'ដារ៉ា ភិក',
                'email'       => 'dara.pich@school.test',
                'gender'      => 'male',
                'dob'         => '1980-04-17',
                'phone'       => '012-345-022',
                'specialty'   => 'Morality & Civics',
                'subjects'    => ['Morality & Civics'],
                'classes'     => [],
            ],
        ];

        foreach ($teachers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'       => $data['name'],
                    'khmer_name' => $data['khmer_name'],
                    'password'   => '123123123',
                    'role'       => 'teacher',
                ]
            );

            if (!$user->wasRecentlyCreated) {
                $user->update([
                    'khmer_name' => $data['khmer_name'],
                ]);
            }

            if (!$user->teacher) {
                $teacher = Teacher::create([
                    'user_id'           => $user->id,
                    'subject_specialty' => $data['specialty'],
                    'gender'            => $data['gender'],
                    'date_of_birth'     => $data['dob'],
                    'phone'             => $data['phone'],
                ]);

                foreach ($data['subjects'] as $subjectName) {
                    $subject = Subject::where('name', $subjectName)->first();
                    if ($subject) {
                        $teacher->subjects()->syncWithoutDetaching([$subject->id]);
                    }
                }

                foreach ($data['classes'] as $className) {
                    $class = SchoolClass::where('name', $className)->first();
                    if ($class) {
                        $class->update(['teacher_id' => $teacher->id]);
                    }
                }
            }
        }
    }
}
