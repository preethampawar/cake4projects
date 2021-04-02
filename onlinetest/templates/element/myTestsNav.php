<?php
$myTestsLinkClass = '';
$indexLinkClass = '';

$action = $this->request->getParam('action');

switch ($action) {
    case 'myResult':
    case 'myTests':
    $myTestsLinkClass = 'active';
        break;
    case 'index':
    case 'view':
    case 'list':
        $indexLinkClass = 'active';
        break;
    default:
        break;
}
?>
<nav class="d-print-none mb-3">
    <div class="nav nav-tabs nav-sm">
        <a class="nav-link px-2 <?= $indexLinkClass ?>" href="/UserExams/">Online Exams</a>
        <a class="nav-link px-2 <?= $myTestsLinkClass ?>" href="/UserExams/myTests">Completed Tests</a>
    </div>
</nav>
