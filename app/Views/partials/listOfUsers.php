<div class="user-table-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>Image of User</th>
                <th>ID</th>
                <th>Username</th>
                <th>Is an Admin</th>
                <th>Can Access the Reserved Page</th>
            </tr>
        </thead>

        <tbody>
            <?php for ($i = 0; $i < count($users); $i++) { ?>
                <tr>
                    <td>
                        <div>
                            <span>
                                <img src="<?= base_url("./userImages/" . ($users[$i]["image_path"] ?? "./user.svg")) ?>" alt="User Image" width="32px" height="auto">
                            </span>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "image"]) ?>
                        </div>
                    </td>
                    <td>
                        <?= $users[$i]["id"] ?>
                    </td>
                    <td>
                        <div>
                            <span>
                                <?= $users[$i]["username"] ?>
                            </span>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "username"]) ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <?= $users[$i]["is_admin"] ?>
                            </span>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "is_admin"]) ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <?= $users[$i]["can_access"] ?>
                            </span>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "can_access"]) ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>