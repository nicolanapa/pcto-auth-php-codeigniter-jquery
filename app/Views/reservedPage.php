<div class="edit-form"></div>

<?= view("partials/listOfUsers", ["users" => $users, "canEdit" => $isAdmin]) ?>