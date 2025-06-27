<div>
    <table>
        <thead>
            <tr>
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
                        <?= $users[$i]["id"] ?>
                    </td>
                    <td>
                        <div>
                            <?= $users[$i]["username"] ?>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "username"]) ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <?= $users[$i]["is_admin"] ?>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "is_admin"]) ?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <?= $users[$i]["can_access"] ?>
                            <?= view("partials/editX", ["userId" => $users[$i]["id"], "typeOfAction" => "can_access"]) ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>