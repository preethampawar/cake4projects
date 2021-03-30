<?=
json_encode([
    'error' => $error,
    'tags' => $tagsList,
    'tagsDropDown' => $this->element('tagsDropDown', ['tags' => $tags, 'selected' => $selectedTags])
])
?>
