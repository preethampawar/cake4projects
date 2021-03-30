<?=
json_encode([
    'error' => $error,
    'educationLevels' => $educationLevelsList,
    'educationLevelsDropDown' => $this->element('educationLevelsDropDown', ['educationLevels' => $educationLevels, 'selected' => $selected])
])
?>
