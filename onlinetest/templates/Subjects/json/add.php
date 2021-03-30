<?=
json_encode([
    'error' => $error,
    'subjects' => $subjectsList,
    'subjectsDropDown' => $this->element('subjectsDropDown', ['subjects' => $subjects, 'selectedSubject' => $selectedSubject])
])
?>
