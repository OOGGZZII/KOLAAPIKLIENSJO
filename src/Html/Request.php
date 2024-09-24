<?php

namespace App\Html;

use App\Pdf\Pdf;
use App\RestApiClient\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Request
{
    static function handle()
    {
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":
                self::postRequest();
                break;
//            case "PUT":
//                self::putRequest();
//                break;
//            case "HEAD";
//                self::headRequest();
//                break;
            case "GET":
            default:
                self::getRequest();
                break;
        }
    }

    private static function getRequest()
    {
        $request = $_REQUEST;
        if (isset($request['page'])) {
            $page = $request['page'];
            switch ($page) {
                case 'counties':
                    PageCounties::table(self::getCounties());
                    break;
                case 'cities':
                      break;
            }
        }
//        header("Refresh:0");
    }

    private static function postRequest()
    {
        $request = $_REQUEST;
        switch ($request) {
            case isset($request['btn-home']) :
                break;
            case isset($request['btn-counties']) :
                PageCounties::table(self::getCounties());
                break;

            case isset($request['btn-save-county']) :
                $client = new Client();
                if (!empty($request['id'])) {
                    $data['id'] = $request['id'];
                }
                if (isset($request['name'])) {
                    $data['name'] = $request['name'];
                }
                $client->post('counties/county', $data);
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-del-county']):
                $client = new Client();
                $response = $client->delete('counties', $request['btn-del-county']);
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-search']):
                $client = new Client();
                $response = $client->post('counties/search', ['needle' => $request['needle']]);
                $entities = [];
                if (isset($response['data'])) {
                    $entities = $response['data'];
                }
                PageCounties::table($entities);
//                header("Refresh:0");
                break;
            case isset($request['btn-pdf']):
                self::makeCountiesPdf('D', 'counties.pdf');
                break;
            case isset($request['btn-email']):
                self::sendMailWithPdfAttachment();
                break;
            case isset($request["btn-view-cities"]):
                PageCities::table(self::getCities($request["btn-view-cities"]));
                break;
        }
//        header("Refresh:0");
    }

    private static function getCounties() : array
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
    }
    private static function getCities($id):array
    {
        $client = new Client();
        $response = $client->get("counties/$id/cities");

        return $response['data'];
    }

    private static function makeCountiesPdf($destination, $fileName)
    {
        $counties = self::getCounties();
        $pdf = new Pdf();
        $pdf->createCountiesList($counties);
        ob_clean();
        $pdf->Output($destination, $fileName, true);
    }

    private static function sendMailWithPdfAttachment()
    {
        $pdfFile = './pdf/' . date('Ymd-His-') . 'counties.pdf';
        self::makeCountiesPdf('F', $pdfFile);
        $mail = new PHPMailer();
        try {

//            $mail->SMTPDebug = 3;
            //Server settings
            $mail->Host = 'localhost'; // SMTP szerver
            $mail->Port = 1025; // SMTP port
            $mail->IsSMTP(); // SMTP-n keresztuli kuldes
            $mail->SMTPAuth = false; // SMTP
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SMTP titkosítás
            // $mail->Username = 'xxxxx@gmail.com'; // SMTP felhasználó
            // $mail->Password = 'xxxxxx'; // SMTP jelszó

            //Recipients
            $mail->setFrom('sender@example.com', 'Sender'); // Felado e-mail cime);
            $mail->addAddress('kovacs.laszlo@boronkay.hu', 'Kovacs Laszlo');     //Add a recipient
            $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            //Attachments
            $mail->addAttachment($pdfFile);         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->WordWrap = 80; // Sortörés állítása
            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>with PDF attachment</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {
                echo 'Message has been sent';
            } else {
                echo "Message could not be sent";
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}