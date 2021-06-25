<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ActivitiesTable extends Table
{
    const ACTIVITY_TYPES = [
        'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'STAGE_1_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'STAGE_2_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'STAGE_3_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'STAGE_4_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'STAGE_5_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_1_FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_2_FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_3_FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_4_FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_5_FEEDING' => 'FEEDING SILKWORMS',
        'STAGE_1_LARVE_HATCHED' => 'LARVE HATCHED FROM EGGS',
        'STAGE_1_LARVE_BRUSHING' => 'BRUSHING LARVE',
        'STAGE_1_LARVE_FEEDING' => 'FEEDING LARVE',
        'STAGE_1_MOULT_1_STARTED' => '1st MOULT STARTED',
        'STAGE_1_MOULT_1_COMPLETED' => '1st MOULT COMPLETED',
        'STAGE_2_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 50g/100dfls (30mins BEFORE 1ST FEEDING)',
        'STAGE_2_MOULT_2_STARTED' => '2nd MOULT STARTED',
        'STAGE_2_MOULT_2_COMPLETED' => '2nd MOULT COMPLETED',
        'STAGE_3_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 100g/100dfls (30mins BEFORE 1ST FEEDING)',
        'STAGE_3_MOULT_3_STARTED' => '3rd MOULT STARTED',
        'STAGE_3_MOULT_3_COMPLETED' => '3rd MOULT COMPLETED',
        'STAGE_4_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 550g/100dfls (30mins BEFORE 1ST FEEDING)',
        'STAGE_4_MOULT_4_STARTED' => '4th MOULT STARTED',
        'STAGE_4_MOULT_4_COMPLETED' => '4th MOULT COMPLETED',
        'STAGE_5_DUSTING_VIJETHA_1' => 'DUSTING DISINFECTANT - VIJETHA 800g/100dfls (30mins BEFORE 1ST FEEDING)',
        'STAGE_5_DUSTING_VIJETHA_2' => 'DUSTING DISINFECTANT - VIJETHA 1500g/100dfls (30mins BEFORE FEEDING ON 4th DAY)',
        'STAGE_5_SIGNS_OF_SPINNING' => 'SIGNS OF SPINNING',
        'STAGE_5_SPINNING_AND_MOUNTING' => 'SPINNING & MOUNTING OF SILKWORMS ON CHANDRIKAS/TRAYS',
        'HARVESTING_COCOONS' => 'HARVESTING COCOONS',
        'STAGE_6_HARVESTING_COCOONS' => 'HARVESTING COCOONS',
        'MARKETING_OF_COCOONS' => 'MARKETING OF COCOONS',
        'STAGE_6_MARKETING_OF_COCOONS' => 'MARKETING OF COCOONS',
        'GARDEN_MAINTENANCE' => 'MULBERRY GARDEN MAINTENANCE',
        'GENERAL_SHED_CLEANING' => 'SHED & REARING BEDS CLEANING',
        'GENERAL_SHED_DISINFECTION' => 'SHED & REARING BEDS DISINFECTION',
        'GENERAL_EQUIPMENTS_DISINFECTION' => 'REARING EQUIPMENTS DISINFECTION',
        'OTHERS' => 'OTHERS'
    ];

    const ACTIVITY_OPTIONS = [
        'General' => [
            'GARDEN_MAINTENANCE' => 'MULBERRY GARDEN MAINTENANCE',
            'GENERAL_SHED_CLEANING' => 'SHED & REARING BEDS CLEANING',
            'GENERAL_SHED_DISINFECTION' => 'SHED & REARING BEDS DISINFECTION',
            'GENERAL_EQUIPMENTS_DISINFECTION' => 'REARING EQUIPMENTS DISINFECTION',
            'OTHERS' => 'OTHERS'
        ],
        'Stage 1 (1st Instar)' => [
            'STAGE_1_LARVE_HATCHED' => 'LARVE HATCHED FROM EGGS',
            'STAGE_1_LARVE_BRUSHING' => 'BRUSHING LARVE',
            'STAGE_1_LARVE_FEEDING' => 'FEEDING LARVE',
            'STAGE_1_MOULT_1_STARTED' => '1st MOULT STARTED',
            'STAGE_1_MOULT_1_COMPLETED' => '1st MOULT COMPLETED',
        ],

        'Stage 2 (2nd Instar)' => [
            'STAGE_2_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 50g/100dfls (30mins BEFORE 1ST FEEDING)',
            'STAGE_2_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'STAGE_2_FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_2_MOULT_2_STARTED' => '2nd MOULT STARTED',
            'STAGE_2_MOULT_2_COMPLETED' => '2nd MOULT COMPLETED',
        ],

        'Stage 3 (3rd Instar)' => [
            'STAGE_3_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 100g/100dfls (30mins BEFORE 1ST FEEDING)',
            'STAGE_3_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'STAGE_3_FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_3_MOULT_3_STARTED' => '3rd MOULT STARTED',
            'STAGE_3_MOULT_3_COMPLETED' => '3rd MOULT COMPLETED',
        ],

        'Stage 4 (4th Instar)' => [
            'STAGE_4_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 550g/100dfls (30mins BEFORE 1ST FEEDING)',
            'STAGE_4_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'STAGE_4_FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_4_MOULT_4_STARTED' => '4th MOULT STARTED',
            'STAGE_4_MOULT_4_COMPLETED' => '4th MOULT COMPLETED',
        ],

        'Stage 5 (5th Instar)' => [
            'STAGE_5_DUSTING_VIJETHA_1' => 'DUSTING DISINFECTANT - VIJETHA 800g/100dfls (30mins BEFORE 1ST FEEDING)',
            'STAGE_5_DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'STAGE_5_FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_5_DUSTING_VIJETHA_2' => 'DUSTING DISINFECTANT - VIJETHA 1500g/100dfls (30mins BEFORE FEEDING ON 4th DAY)',
            'STAGE_5_SIGNS_OF_SPINNING' => 'SIGNS OF SPINNING',
            'STAGE_5_SPINNING_AND_MOUNTING' => 'SPINNING & MOUNTING OF SILKWORMS ON CHANDRIKAS/TRAYS',
        ],

        'Final' => [
            'STAGE_6_HARVESTING_COCOONS' => 'HARVESTING COCOONS',
            'STAGE_6_MARKETING_OF_COCOONS' => 'MARKETING OF COCOONS',
        ],
    ];

    // Todo: the above data to be replaced with below
//    const ACTIVITY_TYPES = [
//        'DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'STAGE_1_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'STAGE_2_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'STAGE_3_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'STAGE_4_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'STAGE_5_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//        'FEEDING' => 'Feeding silkworms',
//        'STAGE_1_FEEDING' => 'Feeding silkworms',
//        'STAGE_2_FEEDING' => 'Feeding silkworms',
//        'STAGE_3_FEEDING' => 'Feeding silkworms',
//        'STAGE_4_FEEDING' => 'Feeding silkworms',
//        'STAGE_5_FEEDING' => 'Feeding silkworms',
//        'STAGE_1_LARVE_HATCHED' => 'Larve hatched from eggs',
//        'STAGE_1_LARVE_BRUSHING' => 'Brushing larve',
//        'STAGE_1_LARVE_FEEDING' => 'Feeding larve',
//        'STAGE_1_MOULT_1_STARTED' => '1st Moult started',
//        'STAGE_1_MOULT_1_COMPLETED' => '1st Moult completed',
//        'STAGE_2_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 50g/100dfls (30mins before 1st feeding)',
//        'STAGE_2_MOULT_2_STARTED' => '2nd Moult started',
//        'STAGE_2_MOULT_2_COMPLETED' => '2nd Moult completed',
//        'STAGE_3_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 100g/100dfls (30mins before 1st feeding)',
//        'STAGE_3_MOULT_3_STARTED' => '3rd Moult started',
//        'STAGE_3_MOULT_3_COMPLETED' => '3rd Moult completed',
//        'STAGE_4_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 550g/100dfls (30mins before 1st feeding)',
//        'STAGE_4_MOULT_4_STARTED' => '4th Moult started',
//        'STAGE_4_MOULT_4_COMPLETED' => '4th Moult completed',
//        'STAGE_5_DUSTING_VIJETHA_1' => 'Dusting disinfectant - Vijetha 800g/100dfls (30mins before 1st feeding)',
//        'STAGE_5_DUSTING_VIJETHA_2' => 'Dusting disinfectant - Vijetha 1500g/100dfls (30mins before feeding on 4th day)',
//        'STAGE_5_SIGNS_OF_SPINNING' => 'Signs of spinning',
//        'STAGE_5_SPINNING_AND_MOUNTING' => 'Spinning & mounting of silkworms on chandrikas/trays',
//        'HARVESTING_COCOONS' => 'Harvesting cocoons',
//        'STAGE_6_HARVESTING_COCOONS' => 'Harvesting cocoons',
//        'MARKETING_OF_COCOONS' => 'Marketing of cocoons',
//        'STAGE_6_MARKETING_OF_COCOONS' => 'Marketing of cocoons',
//        'GARDEN_MAINTENANCE' => 'Mulberry garden maintenance',
//        'GENERAL_SHED_CLEANING' => 'Shed & rearing beds cleaning',
//        'GENERAL_SHED_DISINFECTION' => 'Shed & rearing beds disinfection',
//        'GENERAL_EQUIPMENTS_DISINFECTION' => 'Rearing equipments disinfection',
//        'OTHERS' => 'Others'
//    ];
//
//    const ACTIVITY_OPTIONS = [
//        'GENERAL' => [
//            'GARDEN_MAINTENANCE' => 'Mulberry garden maintenance',
//            'GENERAL_SHED_CLEANING' => 'Shed & rearing beds cleaning',
//            'GENERAL_SHED_DISINFECTION' => 'Shed & rearing beds disinfection',
//            'GENERAL_EQUIPMENTS_DISINFECTION' => 'Rearing equipments disinfection',
//            'OTHERS' => 'Others'
//        ],
//        'Stage 1 (1st Instar)' => [
//            'STAGE_1_LARVE_HATCHED' => 'Larve hatched from eggs',
//            'STAGE_1_LARVE_BRUSHING' => 'Brushing larve',
//            'STAGE_1_LARVE_FEEDING' => 'Feeding larve',
//            'STAGE_1_MOULT_1_STARTED' => '1st Moult started',
//            'STAGE_1_MOULT_1_COMPLETED' => '1st Moult completed',
//        ],
//
//        'Stage 2 (2nd Instar)' => [
//            'STAGE_2_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 50g/100dfls (30mins before 1st feeding)',
//            'STAGE_2_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//            'STAGE_2_FEEDING' => 'Feeding silkworms',
//            'STAGE_2_MOULT_2_STARTED' => '2nd Moult started',
//            'STAGE_2_MOULT_2_COMPLETED' => '2nd Moult completed',
//        ],
//
//        'Stage 3 (3rd Instar)' => [
//            'STAGE_3_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 100g/100dfls (30mins before 1st feeding)',
//            'STAGE_3_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//            'STAGE_3_FEEDING' => 'Feeding silkworms',
//            'STAGE_3_MOULT_3_STARTED' => '3rd Moult started',
//            'STAGE_3_MOULT_3_COMPLETED' => '3rd Moult completed',
//        ],
//
//        'Stage 4 (4th Instar)' => [
//            'STAGE_4_DUSTING_VIJETHA' => 'Dusting disinfectant - Vijetha 550g/100dfls (30mins before 1st feeding)',
//            'STAGE_4_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//            'STAGE_4_FEEDING' => 'Feeding silkworms',
//            'STAGE_4_MOULT_4_STARTED' => '4th Moult started',
//            'STAGE_4_MOULT_4_COMPLETED' => '4th Moult completed',
//        ],
//
//        'Stage 5 (5th Instar)' => [
//            'STAGE_5_DUSTING_VIJETHA_1' => 'Dusting disinfectant - Vijetha 800g/100dfls (30mins before 1st feeding)',
//            'STAGE_5_DUSTING_LIME_POWDER' => 'Dusting lime powder (30mins before feeding)',
//            'STAGE_5_FEEDING' => 'Feeding silkworms',
//            'STAGE_5_DUSTING_VIJETHA_2' => 'Dusting disinfectant - Vijetha 1500g/100dfls (30mins before feeding on 4th day)',
//            'STAGE_5_SIGNS_OF_SPINNING' => 'Signs of spinning',
//            'STAGE_5_SPINNING_AND_MOUNTING' => 'Spinning & mounting of silkworms on chandrikas/trays',
//        ],
//
//        'Final' => [
//            'STAGE_6_HARVESTING_COCOONS' => 'Harvesting cocoons',
//            'STAGE_6_MARKETING_OF_COCOONS' => 'Marketing of cocoons',
//        ],
//    ];

    const ACTIVITY_PROGRESS = [
            'STAGE_1_LARVE_HATCHED' => 3,
            'STAGE_1_LARVE_BRUSHING' => 6,
            'STAGE_1_LARVE_FEEDING' => 9,
            'STAGE_1_MOULT_1_STARTED' => 12,
            'STAGE_1_MOULT_1_COMPLETED' => 15,
            'STAGE_2_DUSTING_VIJETHA' => 18,
            'STAGE_2_DUSTING_LIME_POWDER' => 21,
            'STAGE_2_FEEDING' => 24,
            'STAGE_2_MOULT_2_STARTED' => 27,
            'STAGE_2_MOULT_2_COMPLETED' => 30,
            'STAGE_3_DUSTING_VIJETHA' => 33,
            'STAGE_3_DUSTING_LIME_POWDER' => 36,
            'STAGE_3_FEEDING' => 39,
            'STAGE_3_MOULT_3_STARTED' => 42,
            'STAGE_3_MOULT_3_COMPLETED' => 45,
            'STAGE_4_DUSTING_VIJETHA' => 48,
            'STAGE_4_DUSTING_LIME_POWDER' => 51,
            'STAGE_4_FEEDING' => 54,
            'STAGE_4_MOULT_4_STARTED' => 57,
            'STAGE_4_MOULT_4_COMPLETED' => 60,
            'STAGE_5_DUSTING_VIJETHA_1' => 62,
            'STAGE_5_DUSTING_LIME_POWDER' => 65,
            'STAGE_5_FEEDING' => 70,
            'STAGE_5_DUSTING_VIJETHA_2' => 72,
            'STAGE_5_SIGNS_OF_SPINNING' => 75,
            'STAGE_5_SPINNING_AND_MOUNTING' => 80,
            'STAGE_6_HARVESTING_COCOONS' => 85,
            'STAGE_6_MARKETING_OF_COCOONS' => 100,
    ];

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Batches');
    }
}
