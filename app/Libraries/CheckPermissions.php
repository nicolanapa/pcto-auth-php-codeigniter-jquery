<?php

namespace App\Libraries;

class CheckPermissions {
    public static function userType($typeOfUser = "normalUser"): bool {
        $sessionHandler = new UserSession();
        $user = $sessionHandler->getSession();

        if ($typeOfUser === "normalUser") {
            if (!$sessionHandler->checkIfExists()) {
                return false;
            }

            if (isset($user) && isset($user["is_admin"]) && isset($user["can_access"])) {
                if ($user["can_access"] !== "1") {
                    return false;
                }

                return true;
            }
        } else if ($typeOfUser === "adminUser") {
            if (!$sessionHandler->checkIfExists()) {
                return false;
            }

            if (isset($user) && isset($user["is_admin"]) && isset($user["can_access"])) {
                if ($user["is_admin"] !== "1" || $user["can_access"] !== "1") {
                    return false;
                }

                return true;
            }
        }

        return false;
    }
}
