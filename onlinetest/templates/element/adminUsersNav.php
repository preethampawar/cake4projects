<?php
$usersLinkClass = '';
$userAttendedExamsClass = '';

$action = $this->request->getParam('action');

switch ($action) {
    case 'users':
        $usersLinkClass = 'active';
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
        <a class="nav-link px-2 <?= $usersLinkClass ?>" href="/UserExams/users">Users</a>
        <a class="nav-link px-2 <?= $userAttendedExamsClass ?>" href="/UserExams/userAttendedExams">User Attempted Exams</a>
    </div>
</nav>
