<div class="edit-form-container"></div>

<?= view("partials/listOfUsers", ["users" => $users, "canEdit" => $isAdmin]) ?>