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
                    <td><?= $users[$i]["id"] ?></td>
                    <td><?= $users[$i]["username"] ?></td>
                    <td><?= $users[$i]["is_admin"] ?></td>
                    <td><?= $users[$i]["can_access"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>