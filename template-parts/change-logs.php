<?php
$check_date = $post->change_date;
if (!empty($check_date)) {
?>
    <h3>変更履歴</h3>
    <?php
    $repeat_group = SCF::get( 'change_logs' );
    foreach ( $repeat_group as $fields ) {
    ?>
        <dl>
            <dt><?php echo $fields['change_date']; ?></dt>
                <dd><?php echo $fields['change_point']; ?></dd>
        </dl>
    <?php
    }
}
?>