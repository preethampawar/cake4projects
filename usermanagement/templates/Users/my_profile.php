<h1>My Profile</h1>

<div>
    <p>Name: <b><?= $userInfo->name ?></b></p>
    <p>Username: <b><?= $userInfo->username ?></b> <span class="text-muted">(Used for logging in.)</span></p>
    <p>Email: <b><?= $userInfo->email ?? '-' ?></b></p>
    <p>Phone: <b><?= $userInfo->phone ?? '-' ?></b></p>
    <p>Address: <b><?= $userInfo->address ?? '-' ?></b></p>
    <p>Is Guest: <b><?= $userInfo->is_guest === true ? 'Yes' : 'No' ?></b></p>
    <p>Created On: <b><?= $userInfo->created->format('d M Y') ?></b></p>
</div>

<div class="text-center mt-4">
    <a href="/Users/updateProfile" class="btn btn-primary">Edit Profile</a>
    <a href="/Users/updatePassword" class="btn btn-orange ms-3">Change Password</a>
</div>
