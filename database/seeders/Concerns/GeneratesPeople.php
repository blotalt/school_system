<?php

namespace Database\Seeders\Concerns;

/**
 * Deterministic Khmer name generation shared by TeacherSeeder and
 * StudentSeeder, so re-running the seed suite always produces the exact
 * same roster. Every name fragment here is real Khmer script (not
 * machine-transliterated) — combined combinatorially so a large roster
 * doesn't need hundreds of hand-typed full names.
 */
trait GeneratesPeople
{
    private const MALE_FIRST = [
        ['ចាន់', 'Chan'], ['សំណាង', 'Samnang'], ['ដាវីន', 'Davin'], ['វិបុល', 'Vibol'],
        ['សុវណ្ណ', 'Sovann'], ['វណ្ណក', 'Vannak'], ['វិចា', 'Vichea'], ['សុធា', 'Sothea'],
        ['សុខា', 'Sokha'], ['ដារ៉ា', 'Dara'], ['ចំរើន', 'Chamroeun'], ['ពិសាច', 'Pisach'],
        ['សំបូរ', 'Sambath'], ['វិរះ', 'Virak'], ['គោសល់', 'Kosal'], ['សុភាព', 'Sopheap'],
        ['ពិសិដ្ឋ', 'Piseth'], ['ប៊ុនធឿន', 'Bunthoeun'], ['គីមហាក់', 'Kimhak'], ['សារិទ្ធ', 'Sarith'],
    ];

    private const FEMALE_FIRST = [
        ['កញ្ញា', 'Kanha'], ['ស្រីមុំ', 'Sreymom'], ['ចាន់ថា', 'Chantha'], ['ចន្ធា', 'Chandara'],
        ['មុនីនាថ', 'Monineath'], ['គុណ្ឋា', 'Kunthea'], ['សំភារ', 'Sophea'], ['ចេន្ទា', 'Chenda'],
        ['ពិសី', 'Pisey'], ['ធីដា', 'Thida'], ['វ័ណ្ណ', 'Vanna'], ['រតនា', 'Rattana'],
        ['ម៉ាលីស', 'Malis'], ['កាន់យ៉ា', 'Kanya'], ['ដារ៉ូ', 'Daro'], ['សុគន្ធា', 'Sokunthea'],
        ['ម៉ូលិកា', 'Molika'], ['កាលីយ៉ាន់', 'Kaliyan'], ['ណារី', 'Nary'], ['រក្សម៉ី', 'Reaksmey'],
    ];

    private const LAST_NAMES = [
        ['ប្រាក់', 'Prak'], ['សុក', 'Sok'], ['ហ', 'Hor'], ['ហេង', 'Heng'], ['នួន', 'Nguon'],
        ['មាស', 'Meas'], ['វ៉ា', 'Va'], ['សារ', 'Sar'], ['សេង', 'Seng'], ['សាម', 'Sam'],
        ['តាន', 'Tan'], ['អ៊ុក', 'Ouk'], ['ភិក', 'Pich'], ['ដួង', 'Duong'], ['ចាន់', 'Chan'],
        ['គង់', 'Kong'], ['លី', 'Ly'], ['សុវណ្ណ', 'Sovan'], ['គីម', 'Kim'], ['ណុប', 'Nop'],
    ];

    /**
     * @return array{name: string, khmer_name: string, gender: string}
     */
    private function generatePerson(int $index, string $gender): array
    {
        $firstPool = $gender === 'male' ? self::MALE_FIRST : self::FEMALE_FIRST;
        [$firstKm, $firstEn] = $firstPool[$index % count($firstPool)];
        [$lastKm, $lastEn] = self::LAST_NAMES[intdiv($index, count($firstPool)) % count(self::LAST_NAMES)];

        return [
            'name'       => "{$firstEn} {$lastEn}",
            'khmer_name' => "{$firstKm} {$lastKm}",
            'gender'     => $gender,
        ];
    }

    private function slugEmail(string $name, string $prefix, int $index): string
    {
        $slug = strtolower(str_replace(' ', '.', $name));

        return "{$slug}.{$prefix}{$index}@school.test";
    }
}
