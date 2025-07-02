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

                            <?php if ($isAdmin) { ?>
                                <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "image"]) ?>
                            <?php } ?>
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

                            <?php if ($isAdmin) { ?>
                                <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "username"]) ?>
                            <?php } ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <?= $users[$i]["is_admin"] ?>
                            </span>

                            <?php if ($isAdmin) { ?>
                                <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "is_admin"]) ?>
                            <?php } ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <?= $users[$i]["can_access"] ?>
                            </span>

                            <?php if ($isAdmin) { ?>
                                <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "can_access"]) ?>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>