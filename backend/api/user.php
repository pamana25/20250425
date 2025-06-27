<?php
session_start();
require_once '../model/userModel.php';
require_once '../security.php';
include('../../library/phpmailer/send.php');
$User = new User();
$Mailer = new Mailer();
define('SALT', 'd#f453dd');
// Handle user actions

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        $users = $User->getAllUsers();
        echo json_encode($users);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['register']) && !empty($data['register'])) {
            register($data, $User, $Mailer);
        }
        if (isset($data['login'])) {
            login($data, $User);
        }
        if (isset($data['forgot_password'])) {
            forgotPassword($data, $User, $Mailer);
        }
        if (isset($data['change_password'])) {
            changePassword($data, $User);
        }
        if (isset($data['reset_password'])) {
            resetPassword($data, $User);
        }
        if (isset($data['update_user'])) {
            updateUser($data, $User, $userid);
        }
        if (isset($data['toggleUpdate'])) {
            $status = $data['toggleStatus'] === "on" ? 1 : 0;
            $User->updateReceiveEmail($status, $userid);
            echo json_encode(['status'=>$status === 1 ? 'on' : 'off']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        break;

    case 'DELETE':
        break;
}
function generateRandomToken($length = 75)
{
    return bin2hex(random_bytes($length / 2));
}

function register($data, $User, $Mailer)
{
    $getUserLastId = $User->getUserLastId();
    $user_add_num_id = $getUserLastId + 1;
    $userid = $user_add_num_id;
    $randomToken = generateRandomToken(75);
    $inputData = [
        'userid' => isset($userid) && !empty($userid) ? $userid : null,
        'firstname' => isset($data['firstname']) && !empty($data['firstname']) ? $data['firstname'] : null,
        'lastname' => isset($data['lastname']) && !empty($data['lastname']) ? $data['lastname'] : null,
        'email' => isset($data['email']) && !empty($data['email']) ? $data['email'] : null,
        'username' => isset($data['username']) && !empty($data['username']) ? $data['username'] : null,
        'password' => isset($data['password']) && !empty($data['password']) ? $data['password'] : null,
        'cpassword' => isset($data['cpassword']) && !empty($data['cpassword']) ? $data['cpassword'] : null,
        'token' => $randomToken

    ];
    if ($inputData['password'] !== $inputData['cpassword']) {
        echo json_encode(['status' => 'error', 'message' => 'Password did not match.']);
        return;
    }
    if ($User->isEmailExists($inputData['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
        return;
    }
    if ($User->isUsernameExists($inputData['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists.']);
        return;
    }

    if ($User->createUser($inputData)) {
        if ($User->createUserLogin($inputData)) {
            $Mailer->send_verifyaccount_email_to_user($inputData['email'], $inputData['firstname'], $inputData['token']);
            echo json_encode(['status' => 'success', 'message' => 'You are now registered, Please verify your email']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to register']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to register']);
    }
}

function login($data, $User)
{
    $inputData = [
        'username' => isset($data['username']) && !empty($data['username']) ? $data['username'] : null,
        'password' => isset($data['password']) && !empty($data['password']) ? $data['password'] : null,
    ];

    $db_username = $User->userLogin($inputData);
    $fetchUser = $db_username->fetch_assoc();
    $password = isset($fetchUser['password']) && !empty($fetchUser['password']) ? $fetchUser['password'] : null;
    $userid = isset($fetchUser['userid']) && !empty($fetchUser['userid']) ? $fetchUser['userid'] : null;
    $getUser = $User->getUserInfoByUserid($userid);

    if ($db_username->num_rows > 0) {
        if (password_verify($inputData['password'], $password) || md5(SALT . $inputData['password']) === $password) {
            if ($getUser['verified'] === 1) {
                echo json_encode(['status' => 'success', 'message' => 'Login success.']);
                $_SESSION['userid'] = $userid;
                // var_dump($_SESSION['userid']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Please verify your email first.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Password did not match.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username does not exist.']);
    }
}
function forgotPassword($data, $User, $Mailer)
{
    $email = $data['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $token = generateRandomToken(75);
    $getUser = $User->getUserByEmail($email);
    if ($User->forgotPassword($token, $email)) {
        $Mailer->send_passwordreset_email_to_user($getUser['email'], $getUser['firstname'], $token);
        echo json_encode(['status' => 'success', 'message' => 'Please check your email to reset password.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email does not exist.']);
    }
}
function resetPassword($data, $User)
{
    $token = $data['token'];
    $password = $data['password'];
    $cpassword = $data['confirm_password'];
    if ($password !== $cpassword) {
        echo json_encode(['status' => 'error', 'message' => 'Password did not match.']);
        return;
    }
    
    if ($User->resetPassword($token, $password)) {
        echo json_encode(['status' => 'success', 'message' => 'Reset password successful.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to reset password.']);
    }
}

function changePassword($data, $User)
{
    $userid = $data['userid'];
    $currentPassword = $data['current_password'];
    $password = $data['password'];
    $confirmPassword = $data['confirm_password'];
    $getUser = $User->getUserPasswordByUserid($userid);
    $db_user_password = isset($getUser['password']) && !empty($getUser['password']) ? $getUser['password'] : null;

    if (empty($currentPassword)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Current password is required.'
        ]);
        return;
    }
    // Verify the current password using both methods for compatibility
    if (md5(SALT . $currentPassword) === $db_user_password || password_verify($currentPassword, $db_user_password)) {
        if ($password !== $confirmPassword) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Passwords do not match.'
            ]);
            return;
        }

        // Hash the new password and attempt to update it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if ($User->changePassword($hashedPassword, $userid)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Password successfully reset or changed.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to reset or change the password.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Current password is incorrect.'
        ]);
    }
}
function updateUser($data, $User, $userid)
{
    $inputData = [
        'firstname' => isset($data['firstname']) && !empty($data['firstname']) ? $data['firstname'] : null,
        'lastname' => isset($data['lastname']) && !empty($data['lastname']) ? $data['lastname'] : null,
        'alias' => isset($data['alias']) && !empty($data['alias']) ? $data['alias'] : null,
        'cpassword' => isset($data['cpassword']) && !empty($data['cpassword']) ? $data['cpassword'] : null
    ];
    $getUser = $User->getUserPasswordByUserid($userid);
    $db_password = isset($getUser['password']) && !empty($getUser['password']) ? $getUser['password'] : null;

    if (md5(SALT . $inputData['cpassword']) === $db_password || password_verify($inputData['cpassword'], $db_password)) {
        if ($User->updateUserInfo($inputData, $userid)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Your information has been updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update info.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Comfirm password does not match.'
        ]);
    }
}
