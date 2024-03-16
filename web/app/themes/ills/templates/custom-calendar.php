<?php
require 'Calendar.php';
?>

<?php 
$which = "";
$state = 0;
$weekJaList = ["日", "月", "火", "水", "木", "金", "土"];
$dt = new Calendar($which, $state);
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['booking'])){
            $booking = $_GET['booking'];
            wp_safe_redirect("/contact?booking=$booking");
        } else if(isset($_GET['which'])){
            $which = $_GET['which'];
            $state = $_GET['state'];
            $dt = new Calendar($which, $state);
            $_GET['state'] = $dt->status;
        }
    } 
?>

<?php
/**
* Template Name: カレンダー
* @package WordPress
* @Template Post Type: post, page,
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>
<!--content-->
<!--MV-->
<div class="page__mv contact hero">
    <p class="page__mv--text">見学・体験のご予約</p>
</div>
<!--MV END-->



<section class="calendar-header content-shadow">
    <div class="calendar-header_wrap">
        <form method="GET" action="">
            <h3>ご希望の日時を選択してください。</h3>
            <div class="btn-box">
                <button class="btn-box_prev content-shadow" name="which" value="minus" type="submit">
                    <img src="img/sp-arrow.svg" alt="">
                    前の週</button>
                <a class="btn-box_month content-shadow"
                    href="#"><?php echo htmlspecialchars($dt->this_dt->year); ?>年<?php echo htmlspecialchars($dt->this_dt->month); ?>月</a>
                <button class="btn-box_next content-shadow" name="which" value="plus" type="submit">次の週<img
                        src="img/sp-arrow.svg" alt=""></button>
            </div>
            <input type="text" name="state" value="<?php echo htmlspecialchars($_GET['state']); ?>">
        </form>
    </div>
</section>

<section class="calendar-table">
    <div class="calendar-table_wrap">
        <p class="calendar-table_heading"><span class="maru">〇</span>…空いている<span class="batsu pl">×</span>…締切
        </p>
        <table>
            <tr>
                <th></th>
                <?php foreach($dt->weekdays as $wD) : ?>
                <?php if($wD->dayOfWeek === 0) : ?>
                <th class="Sunday"><?php echo $wD->day ?><br>(日)</th>
                <?php elseif($wD->dayOfWeek === 6) : ?>
                <th class="Saturday"><?php echo $wD->day ?><br>(土)</th>
                <?php else : ?>
                <th><?php echo $wD->day ?><br>(<?php echo $weekJaList[$wD->dayOfWeek] ?>)</th>
                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>

        <div class="tbody content-shadow">
            <form method="GET" action="">
                <table>
                    <?php foreach($dt->outSchedule() as $sch) : ?>
                    <tr>
                        <td class="time">
                            <?php echo $sch["dt"][0]->hour; ?>:
                            <?php if ($sch["dt"][0]->minute === 30) : ?>
                            30
                            <?php else : ?>
                            00
                            <?php endif; ?>
                        </td>
                        <?php for ($num=0; $num < 7; $num++) : ?>
                        <td>
                            <?php if($sch["state"][$num] === true) : ?>
                            <input class="check" id="<?php echo $sch["dt"][$num] ?>" name="booking"
                                value="<?php echo $sch["dt"][$num] ?>" type="submit">
                            <label class="label table-text_o" for="<?php echo $sch["dt"][$num] ?>">〇</label>
                            <?php elseif($sch["state"][$num] === false) : ?>
                            <input class="check" id="<?php echo $sch["dt"][$num] ?>" name="booking"
                                value="<?php echo $sch["dt"][$num] ?>" type="submit" disabled>
                            <label class="label table-text_×" for="<?php echo $sch["dt"][$num] ?>">×</label>
                            <? endif; ?>
                        </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>
</section>


<!--end content-->
<?php get_footer(); ?>