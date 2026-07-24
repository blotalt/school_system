<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::orderBy('name')->get()->keyBy('name');

        $testStudent = User::where('email', 'student@school.test')->first();
        if ($testStudent && !$testStudent->student) {
            $firstClass = $classes->first();
            Student::create([
                'user_id'  => $testStudent->id,
                'class_id' => $firstClass->id,
                'roll_no'  => 'STU-000',
                'gender'   => 'male',
            ]);
            $testStudent->update(['khmer_name' => 'សិស្ស​ ធ្វើ​តេស្ត']);
        }

        $students = [
            // Grade 10-A (15 students)
            ['name' => 'Chamroeun Nguon',   'khmer' => 'ចំរើន នួន',     'email' => 'chamroeun.nguon@school.test',   'roll' => 'STU-001', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-03-12', 'guardian' => '012-100-001'],
            ['name' => 'Dara Ouk',          'khmer' => 'ដារ៉ា អ៊ុក',      'email' => 'dara.ouk@school.test',          'roll' => 'STU-002', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-07-25', 'guardian' => '012-100-002'],
            ['name' => 'Thida Heng',        'khmer' => 'ធីដា ហេង',       'email' => 'thida.heng@school.test',        'roll' => 'STU-003', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-01-08', 'guardian' => '012-100-003'],
            ['name' => 'Molika Kim',        'khmer' => 'មុនីកា គឹម',     'email' => 'molika.kim@school.test',        'roll' => 'STU-004', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-11-30', 'guardian' => '012-100-004'],
            ['name' => 'Kaliyan Nguon',     'khmer' => 'កាលីយ៉ាន នួន',  'email' => 'kaliyan.nguon@school.test',     'roll' => 'STU-005', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-05-14', 'guardian' => '012-100-005'],
            ['name' => 'Nary Ouk',          'khmer' => 'នារី អ៊ុក',       'email' => 'nary.ouk@school.test',          'roll' => 'STU-006', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-08-19', 'guardian' => '012-100-006'],
            ['name' => 'Veasna Meas',       'khmer' => 'វាសនា មាស',      'email' => 'veasna.meas@school.test',       'roll' => 'STU-007', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-02-27', 'guardian' => '012-100-007'],
            ['name' => 'Raksa Ke',          'khmer' => 'រក្សា កែ',        'email' => 'raksa.ke@school.test',          'roll' => 'STU-008', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-09-03', 'guardian' => '012-100-008'],
            ['name' => 'Chan Chan',         'khmer' => 'ចាន់ ចាន់',       'email' => 'chan.chan@school.test',          'roll' => 'STU-009', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-12-16', 'guardian' => '012-100-009'],
            ['name' => 'Rith Pich',         'khmer' => 'រិទ្ធ ភិក',        'email' => 'rith.pich@school.test',         'roll' => 'STU-010', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-04-22', 'guardian' => '012-100-010'],
            ['name' => 'Sethy Chan',        'khmer' => 'សែថី ចាន់',       'email' => 'sethy.chan@school.test',        'roll' => 'STU-011', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-06-05', 'guardian' => '012-100-011'],
            ['name' => 'Chhaya Pich',       'khmer' => 'ឆាយ៉ា ភិក',      'email' => 'chhaya.pich@school.test',       'roll' => 'STU-012', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-10-11', 'guardian' => '012-100-012'],
            ['name' => 'Chariya Chhun',     'khmer' => 'ចរិយា ឈុន',      'email' => 'chariya.chhun@school.test',     'roll' => 'STU-013', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-03-28', 'guardian' => '012-100-013'],
            ['name' => 'Leakena Heng',      'khmer' => 'លក្ខិណា ហេង',    'email' => 'leakena.heng@school.test',      'roll' => 'STU-014', 'class' => 'Grade 10-A', 'gender' => 'female', 'dob' => '2009-07-07', 'guardian' => '012-100-014'],
            ['name' => 'Davin Lee',         'khmer' => 'ដាវីន លី',        'email' => 'davin.lee@school.test',         'roll' => 'STU-015', 'class' => 'Grade 10-A', 'gender' => 'male',   'dob' => '2009-01-15', 'guardian' => '012-100-015'],

            // Grade 10-B (15 students)
            ['name' => 'Bopha Tep',         'khmer' => 'បុប្ផា ទែប',      'email' => 'bopha.tep@school.test',         'roll' => 'STU-016', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-04-18', 'guardian' => '012-100-016'],
            ['name' => 'Sothea Meas',       'khmer' => 'សុធា មាស',       'email' => 'sothea.meas2@school.test',      'roll' => 'STU-017', 'class' => 'Grade 10-B', 'gender' => 'male',   'dob' => '2009-08-23', 'guardian' => '012-100-017'],
            ['name' => 'Chhaya Sam',        'khmer' => 'ឆាយ៉ា សាម',      'email' => 'chhaya.sam@school.test',        'roll' => 'STU-018', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-12-01', 'guardian' => '012-100-018'],
            ['name' => 'Reaksmey Lee',      'khmer' => 'រស្មី លី',         'email' => 'reaksmey.lee@school.test',      'roll' => 'STU-019', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-02-09', 'guardian' => '012-100-019'],
            ['name' => 'Chenda Va',         'khmer' => 'ចេន្ទា វ៉ា',       'email' => 'chenda.va@school.test',         'roll' => 'STU-020', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-06-14', 'guardian' => '012-100-020'],
            ['name' => 'Sophea Sok',        'khmer' => 'សុភា សុក',        'email' => 'sophea.sok@school.test',        'roll' => 'STU-021', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-09-20', 'guardian' => '012-100-021'],
            ['name' => 'Kimly Heng',        'khmer' => 'គីមលី ហេង',      'email' => 'kimly.heng@school.test',        'roll' => 'STU-022', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-11-05', 'guardian' => '012-100-022'],
            ['name' => 'Nita Sam',          'khmer' => 'នីតា សាម',        'email' => 'nita.sam@school.test',          'roll' => 'STU-023', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-03-17', 'guardian' => '012-100-023'],
            ['name' => 'Rith Khiev',        'khmer' => 'រិទ្ធ ខ្យេវ',      'email' => 'rith.khiev@school.test',        'roll' => 'STU-024', 'class' => 'Grade 10-B', 'gender' => 'male',   'dob' => '2009-07-29', 'guardian' => '012-100-024'],
            ['name' => 'Kunthea Tan',       'khmer' => 'គុណ្ឋា តាន',      'email' => 'kunthea.tan@school.test',       'roll' => 'STU-025', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-01-24', 'guardian' => '012-100-025'],
            ['name' => 'Samnang Tep',       'khmer' => 'សំណាង ទែប',      'email' => 'samnang.tep@school.test',       'roll' => 'STU-026', 'class' => 'Grade 10-B', 'gender' => 'male',   'dob' => '2009-05-08', 'guardian' => '012-100-026'],
            ['name' => 'Mealea Sar',        'khmer' => 'មាលា សារ',        'email' => 'mealea.sar@school.test',        'roll' => 'STU-027', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-10-13', 'guardian' => '012-100-027'],
            ['name' => 'Kanha Tan',         'khmer' => 'កញ្ញា តាន',       'email' => 'kanha.tan@school.test',         'roll' => 'STU-028', 'class' => 'Grade 10-B', 'gender' => 'female', 'dob' => '2009-02-26', 'guardian' => '012-100-028'],
            ['name' => 'Piseth Sar',        'khmer' => 'ពិសិទ្ធ សារ',     'email' => 'piseth.sar@school.test',        'roll' => 'STU-029', 'class' => 'Grade 10-B', 'gender' => 'male',   'dob' => '2009-08-04', 'guardian' => '012-100-029'],
            ['name' => 'Makara Sok',        'khmer' => 'មករា សុក',        'email' => 'makara.sok@school.test',        'roll' => 'STU-030', 'class' => 'Grade 10-B', 'gender' => 'male',   'dob' => '2009-12-19', 'guardian' => '012-100-030'],

            // Grade 11-A (15 students)
            ['name' => 'Nary Sar',          'khmer' => 'នារី សារ',         'email' => 'nary.sar@school.test',          'roll' => 'STU-031', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-04-10', 'guardian' => '012-100-031'],
            ['name' => 'Veasna Prak',       'khmer' => 'វាសនា ប្រាក់',     'email' => 'veasna.prak@school.test',       'roll' => 'STU-032', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-08-15', 'guardian' => '012-100-032'],
            ['name' => 'Sopheak Ros',       'khmer' => 'សុភ័ក្រ រស',       'email' => 'sopheak.ros@school.test',       'roll' => 'STU-033', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-01-22', 'guardian' => '012-100-033'],
            ['name' => 'Bopha Sam',         'khmer' => 'បុប្ផា សាម',        'email' => 'bopha.sam@school.test',         'roll' => 'STU-034', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-11-07', 'guardian' => '012-100-034'],
            ['name' => 'Piseth Ly',         'khmer' => 'ពិសិទ្ធ លី',       'email' => 'piseth.ly@school.test',         'roll' => 'STU-035', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-03-30', 'guardian' => '012-100-035'],
            ['name' => 'Dalis Nguon',       'khmer' => 'ដាលីស នួន',       'email' => 'dalis.nguon@school.test',       'roll' => 'STU-036', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-07-18', 'guardian' => '012-100-036'],
            ['name' => 'Sreymom Yem',       'khmer' => 'ស្រីមំ យ៉ែម',     'email' => 'sreymom.yem@school.test',       'roll' => 'STU-037', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-09-25', 'guardian' => '012-100-037'],
            ['name' => 'Makara Ly',         'khmer' => 'មករា លី',          'email' => 'makara.ly@school.test',         'roll' => 'STU-038', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-12-03', 'guardian' => '012-100-038'],
            ['name' => 'Dara Nguon',        'khmer' => 'ដារ៉ា នួន',        'email' => 'dara.nguon@school.test',        'roll' => 'STU-039', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-02-14', 'guardian' => '012-100-039'],
            ['name' => 'Sreypov Heng',      'khmer' => 'ស្រីពៅ ហេង',      'email' => 'sreypov.heng@school.test',      'roll' => 'STU-040', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-05-21', 'guardian' => '012-100-040'],
            ['name' => 'Rith Ouk',          'khmer' => 'រិទ្ធ អ៊ុក',        'email' => 'rith.ouk@school.test',          'roll' => 'STU-041', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-10-09', 'guardian' => '012-100-041'],
            ['name' => 'Kanha Hor',         'khmer' => 'កញ្ញា ហ',          'email' => 'kanha.hor@school.test',         'roll' => 'STU-042', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-06-16', 'guardian' => '012-100-042'],
            ['name' => 'Sophea Prak',       'khmer' => 'សុភា ប្រាក់',      'email' => 'sophea.prak@school.test',       'roll' => 'STU-043', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-04-28', 'guardian' => '012-100-043'],
            ['name' => 'Vichea Kim',        'khmer' => 'វិចា គឹម',         'email' => 'vichea.kim@school.test',        'roll' => 'STU-044', 'class' => 'Grade 11-A', 'gender' => 'male',   'dob' => '2008-08-01', 'guardian' => '012-100-044'],
            ['name' => 'Chhaya Ly',         'khmer' => 'ឆាយ៉ា លី',         'email' => 'chhaya.ly@school.test',         'roll' => 'STU-045', 'class' => 'Grade 11-A', 'gender' => 'female', 'dob' => '2008-11-20', 'guardian' => '012-100-045'],

            // Grade 11-B (15 students)
            ['name' => 'Sovann Reyes',      'khmer' => 'សុវណ្ណ រ៉ាយ',     'email' => 'sovann.reyes@school.test',      'roll' => 'STU-046', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-01-05', 'guardian' => '012-100-046'],
            ['name' => 'Sethy Ke',          'khmer' => 'សែថី កែ',           'email' => 'sethy.ke@school.test',          'roll' => 'STU-047', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-05-12', 'guardian' => '012-100-047'],
            ['name' => 'Chenda Va',         'khmer' => 'ចេន្ទា វ',          'email' => 'chenda.va2@school.test',        'roll' => 'STU-048', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-09-28', 'guardian' => '012-100-048'],
            ['name' => 'Sreypov Tan',       'khmer' => 'ស្រីពៅ តាន',       'email' => 'sreypov.tan@school.test',       'roll' => 'STU-049', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-03-06', 'guardian' => '012-100-049'],
            ['name' => 'Kimly Chhun',       'khmer' => 'គីមលី ឈុន',        'email' => 'kimly.chhun@school.test',       'roll' => 'STU-050', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-07-23', 'guardian' => '012-100-050'],
            ['name' => 'Reaksmey Doe',      'khmer' => 'រស្មី ដូ',          'email' => 'reaksmey.doe@school.test',      'roll' => 'STU-051', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-10-31', 'guardian' => '012-100-051'],
            ['name' => 'Sokha Doe',         'khmer' => 'សុខា ដូ',           'email' => 'sokha.doe@school.test',         'roll' => 'STU-052', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-02-17', 'guardian' => '012-100-052'],
            ['name' => 'Bopha Heng',        'khmer' => 'បុប្ផា ហេង',        'email' => 'bopha.heng@school.test',        'roll' => 'STU-053', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-06-04', 'guardian' => '012-100-053'],
            ['name' => 'Nimol Chan',        'khmer' => 'នីម៉ុល ចាន់',      'email' => 'nimol.chan@school.test',        'roll' => 'STU-054', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-12-22', 'guardian' => '012-100-054'],
            ['name' => 'Raksa Pham',        'khmer' => 'រក្សា ផាម',         'email' => 'raksa.pham@school.test',        'roll' => 'STU-055', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-04-08', 'guardian' => '012-100-055'],
            ['name' => 'Panha Heng',        'khmer' => 'បញ្ញា ហេង',        'email' => 'panha.heng@school.test',        'roll' => 'STU-056', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-08-26', 'guardian' => '012-100-056'],
            ['name' => 'Thida Seng',        'khmer' => 'ធីដា សេង',         'email' => 'thida.seng@school.test',        'roll' => 'STU-057', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-01-13', 'guardian' => '012-100-057'],
            ['name' => 'Sona Heng',         'khmer' => 'សណ្ឋ ហេង',         'email' => 'sona.heng@school.test',         'roll' => 'STU-058', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-05-30', 'guardian' => '012-100-058'],
            ['name' => 'Veasna Doe',        'khmer' => 'វាសនា ដូ',         'email' => 'veasna.doe@school.test',        'roll' => 'STU-059', 'class' => 'Grade 11-B', 'gender' => 'male',   'dob' => '2008-09-16', 'guardian' => '012-100-059'],
            ['name' => 'Leakena Pich',      'khmer' => 'លក្ខិណា ភិក',      'email' => 'leakena.pich@school.test',      'roll' => 'STU-060', 'class' => 'Grade 11-B', 'gender' => 'female', 'dob' => '2008-11-02', 'guardian' => '012-100-060'],
        ];

        foreach ($students as $data) {
            $class = $classes->get($data['class']);
            if (!$class) {
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'       => $data['name'],
                    'khmer_name' => $data['khmer'],
                    'password'   => '123123123',
                    'role'       => 'student',
                ]
            );

            if (!$user->wasRecentlyCreated) {
                $user->update(['khmer_name' => $data['khmer']]);
            }

            if (!$user->student) {
                Student::create([
                    'user_id'          => $user->id,
                    'class_id'         => $class->id,
                    'roll_no'          => $data['roll'],
                    'gender'           => $data['gender'],
                    'date_of_birth'    => $data['dob'],
                    'guardian_contact' => $data['guardian'],
                ]);
            }
        }
    }
}
