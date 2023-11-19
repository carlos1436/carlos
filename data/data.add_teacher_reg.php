<?php
// DATABASE CONNECTION
include_once("database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
function get_domain($email)
{
    if (strrpos($email, '.') == strlen($email) - 3)
        $num_parts = 3;
    else
        $num_parts = 2;

    $domain = implode(
        '.',
        array_slice(preg_split("/(\.|@)/", $email), -$num_parts)
    );

    return strtolower($domain);
}
if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $teacher_fullname = strip_tags(legal_input($_POST["lastname"])) . ", " . strip_tags(legal_input($_POST["firstname"]));
        $random = rand(100000, 999999);
        $code = md5($random);

        //ALLOWED DOMAINS
        $allowed = array('ctu.edu.ph');
        // CHECK USERNAME

        $check_username = $conn->prepare("
            SELECT * FROM users WHERE user_username =? OR user_email =? OR user_id_number=? OR user_fullname =?
        ");
        $check_username->execute([
            strip_tags($_POST["username"]),
            strip_tags($_POST["email"]),
            strip_tags($_POST["ctuid"]),
            $teacher_fullname
        ]);

        if ($check_username->fetch()) {
            echo "username_same_error";
        } else if (preg_match('/^[a-zA-Z]+$/', $_POST["username"])) {
            echo "username_error";
        } else if (preg_match('/^[a-zA-Z]+$/', $_POST["password"]) && strlen(trim($_POST["password"])) < 8) {
            echo "password_error";
        } else if (strlen(trim($_POST["ctuid"])) < 5) {
            echo "CTU_ID_error";
        } else if (!in_array(get_domain($_POST["email"]), $allowed)) {
            echo "email_error";
        } else {
            $insert_teacher_user = $conn->prepare("
                    INSERT INTO users
                    (user_username,user_password,user_fullname,user_contact,user_email,user_email_verified,user_type,user_address,user_id_number)
                    VALUES
                    (?,?,?,?,?,?,?,?,?)
                ");
            $teacher_user_added = $insert_teacher_user->execute([
                strip_tags($_POST["username"]),
                strip_tags($_POST["password"]),
                $teacher_fullname,
                strip_tags($_POST["phone_number"]),
                strip_tags($_POST["email"]),
                strip_tags($code),
                "Teacher",
                strip_tags($_POST["address"]),
                strip_tags($_POST["ctuid"])
            ]);
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = 'argieabuloc060302@gmail.com'; //SMTP username
                $mail->Password = 'ijfv jtfs mutv nvyk'; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('argieabuloc060302@gmail.com');
                $mail->addAddress($_POST["email"]); //Add a recipient

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body = 'Here is the verification link <b><a href="http://localhost/raw_project_scheduling_email_verification/login_page.php?verification=' . $code . '">http://localhost/raw_project_scheduling_email_verification/login_page.php?verification=' . $code . '</a></b>';

                $mail->send();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            if ($teacher_user_added) {
                echo 1;
            } else {
                echo 0;
            }


            // CHECK ID NUMBER
            $check_id_number = $conn->prepare("
                SELECT teacher_id_number
                FROM teacher
                WHERE teacher_id_number = ?
            ");
            $check_id_number->execute([
                strip_tags($_POST["ctuid"])
            ]);

            if ($check_id_number->fetch()) {
                echo "id_number_error";
            } else {
                $insert_teacher = $conn->prepare("
                INSERT INTO teacher
                (teacher_id_number, teacher_firstname, teacher_lastname, teacher_middlename, teacher_bachelor, teacher_master, teacher_doctor, teacher_special, teacher_major, teacher_minor, teacher_designation, teacher_status, teacher_research, teacher_production, teacher_extension, teacher_others)
                VALUES
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                ");
                $teacher_added = $insert_teacher->execute([
                    strip_tags($_POST["ctuid"]),
                    strip_tags($_POST["firstname"]),
                    strip_tags($_POST["lastname"]),
                    strip_tags($_POST["middlename"]),
                    strip_tags($_POST["bachelor"]),
                    strip_tags($_POST["master"]),
                    strip_tags($_POST["doctor"]),
                    strip_tags($_POST["special"]),
                    strip_tags($_POST["major"]),
                    strip_tags($_POST["minor"]),
                    strip_tags($_POST["designation"]),
                    strip_tags($_POST["status"]),
                    strip_tags($_POST["research"]),
                    strip_tags($_POST["production"]),
                    strip_tags($_POST["extension"]),
                    strip_tags($_POST["others"])
                ]);

                if ($teacher_added) {
                    echo 1;
                } else {
                    echo 0;
                }

            }
        }


    }

}

$check_id_number = null;
$insert_teacher = null;
$conn = null;

?>