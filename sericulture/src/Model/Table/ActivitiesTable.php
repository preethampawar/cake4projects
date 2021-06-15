<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ActivitiesTable extends Table
{
    const ACTIVITY_TYPES = [
        'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
        'FEEDING' => 'FEEDING SILKWORMS',
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
        'MARKETING_OF_COCOONS' => 'MARKETING OF COCOONS',
    ];

    const ACTIVITY_OPTIONS = [
        'Stage 1' => [
            'STAGE_1_LARVE_HATCHED' => 'LARVE HATCHED FROM EGGS',
            'STAGE_1_LARVE_BRUSHING' => 'BRUSHING LARVE',
            'STAGE_1_LARVE_FEEDING' => 'FEEDING LARVE',
            'STAGE_1_MOULT_1_STARTED' => '1st MOULT STARTED',
            'STAGE_1_MOULT_1_COMPLETED' => '1st MOULT COMPLETED',
        ],

        'Stage 2' => [
            'STAGE_2_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 50g/100dfls (30mins BEFORE 1ST FEEDING)',
            'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_2_MOULT_2_STARTED' => '2nd MOULT STARTED',
            'STAGE_2_MOULT_2_COMPLETED' => '2nd MOULT COMPLETED',
        ],

        'Stage 3' => [
            'STAGE_3_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 100g/100dfls (30mins BEFORE 1ST FEEDING)',
            'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_3_MOULT_3_STARTED' => '3rd MOULT STARTED',
            'STAGE_3_MOULT_3_COMPLETED' => '3rd MOULT COMPLETED',
        ],

        'Stage 4' => [
            'STAGE_4_DUSTING_VIJETHA' => 'DUSTING DISINFECTANT - VIJETHA 550g/100dfls (30mins BEFORE 1ST FEEDING)',
            'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_4_MOULT_4_STARTED' => '4th MOULT STARTED',
            'STAGE_4_MOULT_4_COMPLETED' => '4th MOULT COMPLETED',
        ],

        'Stage 5' => [
            'STAGE_5_DUSTING_VIJETHA_1' => 'DUSTING DISINFECTANT - VIJETHA 800g/100dfls (30mins BEFORE 1ST FEEDING)',
            'DUSTING_LIME_POWDER' => 'DUSTING LIME POWDER (30mins BEFORE FEEDING)',
            'FEEDING' => 'FEEDING SILKWORMS',
            'STAGE_5_DUSTING_VIJETHA_2' => 'DUSTING DISINFECTANT - VIJETHA 1500g/100dfls (30mins BEFORE FEEDING ON 4th DAY)',
            'STAGE_5_SIGNS_OF_SPINNING' => 'SIGNS OF SPINNING',
            'STAGE_5_SPINNING_AND_MOUNTING' => 'SPINNING & MOUNTING OF SILKWORMS ON CHANDRIKAS/TRAYS',
        ],

        'Final' => [
            'HARVESTING_COCOONS' => 'HARVESTING COCOONS',
            'MARKETING_OF_COCOONS' => 'MARKETING OF COCOONS',
        ],
    ];

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Batches');
    }
}
