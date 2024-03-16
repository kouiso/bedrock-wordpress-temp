<?php
global $wpdb;
$error = [];
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    //バリデーション
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //　フォームの送信時にエラーをチェックする
    if ($post['name'] === ''){
        $error['name'] = 'blank';
    }
    if ($post['email'] === ''){
        $error['email'] = 'blank';
    } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
        $error['email'] = 'email';
    }
    if ($post['tel'] === ''){
        $error['tel'] = 'blank';
    }
    if ($post['address'] === ''){
        $error['address'] = 'blank';
    }
    if ($post['question'] === 'default'){
        $error['question'] = 'blank';
    }
    if ($post['inquery'] === ''){
        $error['inquery'] = 'blank';
    }

    if (count($error) === 0){
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $address = $_POST['address'];
        $question = $_POST['question'];
        $inquery = $_POST['inquery'];
        $reserve_dt = $_POST['reserve_dt'];
        $record = array(
            'name' => $name,
            'email' => $email,
            'tel' => $tel,
            'address' => $address,
            'question' => $question,
            'inquery' => $inquery,
            'reserve_dt' => $reserve_dt,
        );
        $types = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
        );
        $wpdb->insert(
            'reserves',
            $record,
            $types
        );

        $subject = array('admin' => "ご予約が入りました", 'customer' => "ご予約ありがとうございます");
        $to = array('admin' => "", 'customer' => $email);
        $body = array('admin' => "ご予約が入りました", 'customer' => "$fullname様。ご予約ありがとうございます");
        $headers[] = "Cc: cc@example.com";
        
        wp_mail($to['admin'], $subject['admin'], $body['admin'], $headers);//管理者に対して贈るメール
        wp_mail($to['customer'], $subject['customer'], $body['customer'], $headers);//お客さんに送るメール

        wp_safe_redirect("/thanks");
        exit;   
    }
}
?>

<?php
/**
* Template Name: お問い合わせ
* @package WordPress
* @Template Post Type: post, page,
* @subpackage I'LL
* @since I'LL 1.0
*/
get_header(); ?>


<!--content-->
<!--MV-->
<div class="page__mv contact hero">
    <p class="page__mv--text">お問い合わせ</p>
</div>
<!--MV END-->

<!--FORM-->
<div id="formWrap">
    <div class="inner">
        <div class="heading">
            <h3>予約日時</h3>
            <p class="date"><?php echo $_GET["booking"]; ?></p>
        </div>

        <div class="heading">
            <h3>基本情報を入力</h3>
            <p class="text">下記フォームに必要事項を入力後、確認ボタンを押してください。</p>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="reserve_dt" value="<?php echo $_GET["booking"]; ?>">
            <div class="form_wrap">
                <div class="form_wrap_flex">
                    <label for="fullname">お名前<span>*</span></label>
                    <input type="text" name="fullname" id="fullname"
                        value="<?php echo htmlspecialchars($_POST['fullname']); ?>">
                    <?php if ($error['fullname'] === 'fullname'): ?>
                    <p class="error_msg">※メールアドレスを正しくご記入下さい</p>
                    <?php endif; ?>
                </div>
                <div class="form_wrap_flex">
                    <label for="email">メールアドレス<span>*</span></label>
                    <input type="email" name="email" id="email"
                        value="<?php echo htmlspecialchars($_POST['email']); ?>">
                    <?php if ($error['email'] === 'blank'): ?>
                    <p class="error_msg">※メールアドレスをご記入下さい</p>
                    <?php endif; ?>
                    <?php if ($error['email'] === 'email'): ?>
                    <p class="error_msg">※メールアドレスを正しくご記入下さい</p>
                    <?php endif; ?>
                </div>
                <div class="form_wrap_flex">
                    <label for="tel">電話番号<span>*</span></label>
                    <input type="tel" name="tel" value="<?php echo htmlspecialchars($_POST['tel']); ?>">
                    <?php if ($error['tel'] === 'blank'): ?>
                    <p class="error_msg">※電話番号をご記入下さい</p>
                    <?php endif; ?>
                </div>
                <div class="form_wrap_flex">
                    <label for="address">住所<span>*</span></label>
                    <input type="text" name="address" id="address"
                        value="<?php echo htmlspecialchars($_POST['address']); ?>">
                    <?php if ($error['address'] === 'blank'): ?>
                    <p class="error_msg">※住所をご記入下さい</p>
                    <?php endif; ?>
                </div>
                <div class="form_wrap_flex">
                    <label for="question">質問事項<span>*</span></label>
                    <select id="question" name="question" value="<?php echo htmlspecialchars($_POST['question']); ?>">
                        <option value="default" checked>未選択</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                    <?php if ($error['question'] === 'blank'): ?>
                    <p class="error_msg">※質問事項を選択して下さい</p>
                    <?php endif; ?>
                </div>
                <div class="form_wrap_flex">
                    <label for="inquery">お問い合わせ内容<span>*</span></label>
                    <textarea rows="" cols="" name="inquery"
                        id="inquery"><?php echo htmlspecialchars($_POST['inquery']); ?></textarea>
                    <?php if ($error['inquery'] === 'blank'): ?>
                    <p class="error_msg">※お問い合わせ内容をご記入下さい</p>
                    <?php endif; ?>
                </div>
                <button type="submit">上記の内容で申し込む</button>
            </div>
        </form>
    </div>
</div>
</div>
<!--FORM END-->

<!--end content-->
<?php get_footer(); ?>