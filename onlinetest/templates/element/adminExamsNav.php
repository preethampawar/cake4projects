<?php
$indexClass = '';
$addExamClass = '';

$action = $this->request->getParam('action');

switch ($action) {
    case 'index':
        $indexClass = 'active';
        break;
    case 'add':
    case 'addQuestions':
        $addExamClass = 'active';
        break;
    case 'userAttendedExams':
        $userAttendedExamsClass = 'active';
        break;
    default:
        break;
}
?>
<nav class="d-print-none mb-3 card-header">
    <div class="nav nav-tabs card-header-tabs nav-sm">
        <a class="nav-link px-2 <?= $indexClass ?>" href="/Exams">Exams</a>
        <a class="nav-link px-2 <?= $addExamClass ?>" href="/Exams/add">New Exam</a>
    </div>
</nav>
