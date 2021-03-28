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
        $indexLinkClass = 'active';
        break;
    default:
        break;
}
?>
<nav class="d-print-none mb-3">
    <div class="nav nav-tabs">
        <a class="nav-link <?= $indexLinkClass ?>" href="/UserExams/">Online Exams</a>
        <a class="nav-link  <?= $myTestsLinkClass ?>" href="/UserExams/myTests">My Tests</a>
    </div>
</nav>
