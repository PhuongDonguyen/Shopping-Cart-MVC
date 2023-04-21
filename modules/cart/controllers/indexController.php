<?php
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


function construct() {
    load_model('index');
    load('helper', 'format');
}

function indexAction() {
    $list_buy =  get_list_buy_cart();
    $cart_info = get_cart_info();
    $data['list_buy'] = $list_buy;
    $data['cart_info'] = $cart_info;
    load_view('index', $data);
}

function addAction() {
    $product_id = $_GET['id'];
    add_to_cart($product_id);
    $list_buy =  get_list_buy_cart();
    $cart_info = get_cart_info();
    $data['list_buy'] = $list_buy;
    $data['cart_info'] = $cart_info;
    load_view('index', $data);
}

function deleteAction() {
    $delete_id = !empty($_GET['id']) ? $_GET['id'] : "";
    delete_cart($delete_id);
    $list_buy =  get_list_buy_cart();
    $cart_info = get_cart_info();
    $data['list_buy'] = $list_buy;
    $data['cart_info'] = $cart_info;
    load_view('index', $data);
}

function updateAction() {
    $qty_arr = $_POST['qty'];
    update_cart($qty_arr);
    $list_buy =  get_list_buy_cart();
    $cart_info = get_cart_info();
    $data['list_buy'] = $list_buy;
    $data['cart_info'] = $cart_info;
    load_view('index', $data);
}

function update_ajaxAction() {
    $id = $_POST['product_id'];
    $new_qty = $_POST['qty'];
    $item = $_SESSION['cart']['buy'][$id];
    if (isset($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart']['buy'])) {
        $_SESSION['cart']['buy'][$id]['qty'] = $new_qty;
        $sub_total = $new_qty * $item['price'];
        $_SESSION['cart']['buy'][$id]['sub_total'] = $new_qty * $item['price'];

        update_cart_info();
        $total = get_total_cart();

        $data = array(
            'sub_total' => currency_format($sub_total),
            'total' => currency_format($total)
        );

        echo json_encode($data);
    }
}

function checkoutAction() {
    $list_buy = get_list_buy_cart();
    $cart_total = get_total_cart();
    $data['list_buy'] = $list_buy;
    $data['cart_total'] = $cart_total;
    load_view('checkout', $data);
}

function sendmailAction() {
    $to_email = $_POST['email'];
    $client_name = $_POST['fullname'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $note = $_POST['note'];

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    // use PHPMailer\PHPMailer\Exception;

    // require 'PHPMailer/src/Exception.php';
    // require 'PHPMailer/src/PHPMailer.php';
    // require 'PHPMailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'phuongdonguyen03@gmail.com';                     //SMTP username
        $mail->Password = 'cukzhczcrbvbrfqg';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('phuongdonguyen03@gmail.com', 'PHUONG STORE');
        $mail->addAddress("$to_email", 'Do Nguyen Phuong');     //Add a recipient
    //    $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('phuongdonguyen03@gmail.com', 'PHUONG STORE');
    //    $mail->addCC('cc@example.com');
    //    $mail->addBCC('bcc@example.com');
        //Attachments
    //    $mail->addAttachment('public/images/thank-you-attach.jpg');         //Add attachments
    //    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = '[XÁC NHẬN ĐƠN HÀNG] Từ hệ thống PHUONG STORE';
        $mail->Body = "Xin chào quý khách <b>{$client_name}</b><br>
                    Hệ thống <strong>PHUONG STORE</strong> xin gửi đến quý khách thông tin đơn đặt hàng: <br>
                    <ul>
                            <li>Người nhận: <strong>$client_name</strong></li>
                            <li>Số điện thoại: <strong>$tel</strong></li>
                            <li>Đơn hàng sẽ được gửi đến địa chỉ: <i><strong>{$address}</strong></i></li>
                    </ul>
                    <i>Chúng tôi sẽ chuyển đơn hàng đến quý khách trong thời gian sớm nhất!</i><br><br>
                    <strong><i>Trân trọng</i></strong>
    ";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
        unset($_SESSION['cart']);
        header("Location: ?mod=cart&controller=index");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}