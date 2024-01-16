<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit();
}

// Ваш сайт
$site = 'file:///C:/Users/%D0%91%D0%B0%D0%BA%D0%BE%D1%82%D0%B8%D0%BD/Desktop/%D0%A3%D1%87%D0%B5%D0%B1%D0%B0%2024/%D0%9E%D0%B1%D1%89%D0%B8%D0%B9%20%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82/%D0%9E%D0%B1%D1%89%D0%B8%D0%B9%20%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%2016.01.24/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B%2016.01.24/index.html';
// Тема письма
$subject = 'Заявка с сайта '.$site.'!';
// От кого
$from = 'form@'.$site;
// Кому
$to = 'info@'.$site;

//В переменную $token нужно вставить id вашего бота
$token = "6660986001:AAEIFvCvFCeeZf9wzeSRk9e0uG02Rx37TuA";
//В chat_id вставляем id группы
$chat_id = "1842050958";

var_dump($_POST);
if ( ! empty( $_POST ) ) {
    $name  = htmlspecialchars($_POST['name']);
    $phone  = htmlspecialchars($_POST['phone']);
    $question  = htmlspecialchars($_POST['question']);

    // Тело сообщения для отправки по почте
    // $message = "Имя клиента: $name \r\n";
    // $message .= "Телефон клиента: $phone \r\n";
    // $message .= "Сообщение: $question";

    //Тело сообщения для отправки в телеграмм
    $txt = "Имя клиента: $name %0A";
    $txt .= "Телефон клиента: $phone %0A";
    $txt .= "Сообщение: $question";

    try {
        $headers = 'From: form@'.$site."\r\n".
                'X-Mailer: PHP/' . phpversion();

        //Передаем сообщение по почте
		// $mail = mail( $to, $subject, $message, $headers );

        //Передаем сообщение в телеграмм
        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
        // $mail &&
        if (  $sendToTelegram ) {
            echo json_encode('Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.');
        } else {
            echo json_encode('Ошибка отправки!');
        }

        die();

    } catch (Exception $e) {
        echo json_encode("Ошибка: $e->getMessage()");
    }
} else {
    echo json_encode("Тело сообщения пустое");
}
?>