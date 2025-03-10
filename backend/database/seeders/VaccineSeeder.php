<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vaccine;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccines = [
            [
                'vaccine_name' => 'BCG (Bacillus Calmette-Guerin)',
                'description' => 'Protects against tuberculosis.',
                'disease_prevented' => 'Tuberculosis',
                'recommended_age' => 'At birth',
                'dosage' => 'Single dose',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Hepatitis B',
                'description' => 'Protects against Hepatitis B virus infection.',
                'disease_prevented' => 'Hepatitis B',
                'recommended_age' => 'At birth, 1 month, 6 months',
                'dosage' => '3 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Oral Polio Vaccine (OPV)',
                'description' => 'Protects against poliovirus.',
                'disease_prevented' => 'Polio',
                'recommended_age' => 'At birth, 6 weeks, 10 weeks, 14 weeks',
                'dosage' => '4 doses',
                'administration_method' => 'Oral',
            ],
            [
                'vaccine_name' => 'Inactivated Polio Vaccine (IPV)',
                'description' => 'Alternative to OPV, provides protection against poliovirus.',
                'disease_prevented' => 'Polio',
                'recommended_age' => '14 weeks',
                'dosage' => 'Single dose',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'DTP (Diphtheria, Tetanus, Pertussis)',
                'description' => 'Protects against diphtheria, tetanus, and whooping cough.',
                'disease_prevented' => 'Diphtheria, Tetanus, Pertussis',
                'recommended_age' => '6 weeks, 10 weeks, 14 weeks',
                'dosage' => '3 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Haemophilus Influenzae Type B (Hib)',
                'description' => 'Protects against Haemophilus influenzae type B infections.',
                'disease_prevented' => 'Meningitis, Pneumonia',
                'recommended_age' => '6 weeks, 10 weeks, 14 weeks',
                'dosage' => '3 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Pneumococcal Conjugate Vaccine (PCV)',
                'description' => 'Protects against pneumococcal infections like pneumonia and meningitis.',
                'disease_prevented' => 'Pneumonia, Meningitis',
                'recommended_age' => '6 weeks, 10 weeks, 14 weeks',
                'dosage' => '3 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Rotavirus Vaccine',
                'description' => 'Protects against severe rotavirus infections causing diarrhea.',
                'disease_prevented' => 'Rotavirus',
                'recommended_age' => '6 weeks, 10 weeks',
                'dosage' => '2 doses',
                'administration_method' => 'Oral',
            ],
            [
                'vaccine_name' => 'Measles Vaccine',
                'description' => 'Protects against measles infection.',
                'disease_prevented' => 'Measles',
                'recommended_age' => '9 months, 18 months',
                'dosage' => '2 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Yellow Fever Vaccine',
                'description' => 'Protects against yellow fever virus infection.',
                'disease_prevented' => 'Yellow Fever',
                'recommended_age' => '9 months',
                'dosage' => 'Single dose',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'Human Papillomavirus (HPV) Vaccine',
                'description' => 'Protects against cervical cancer caused by HPV.',
                'disease_prevented' => 'HPV-related cancers',
                'recommended_age' => '9-14 years',
                'dosage' => '2 doses',
                'administration_method' => 'Injection',
            ],
            [
                'vaccine_name' => 'COVID-19 Vaccine',
                'description' => 'Provides immunity against COVID-19.',
                'disease_prevented' => 'COVID-19',
                'recommended_age' => '12 years and above',
                'dosage' => '2 doses + booster',
                'administration_method' => 'Injection',
            ]
        ];

        foreach ($vaccines as $vaccine) {
            Vaccine::create($vaccine);
        }
    }
}
