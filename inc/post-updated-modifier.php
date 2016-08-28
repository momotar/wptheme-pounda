<?php
// http://thk.kanzae.net/net/wordpress/t1426/
/* 管理画面が開いたときに実行 */
add_action( 'admin_menu', 'add_update_level_custom_box' );
/* 更新ボタンが押されたときに実行 */
add_action( 'save_post', 'save_custom_field_postdata' );
 
/* カスタムフィールドを投稿画面に追加 */
function add_update_level_custom_box() {
    //ページ編集画面にカスタムメタボックスを追加
    add_meta_box( 'update_level', '更新レベル', 'html_update_level_custom_box', 'post', 'side', 'high' );
}

/* 投稿画面に表示するフォームのHTMLソース */
function html_update_level_custom_box() {
    global $post;
    if (!empty($_GET['post'])) {
    	$update_level = get_post_meta( $_GET['post'], 'update_level' );
    } else {
    	$update_level = "";
    }

    echo '<div style="padding-top: 5px; overflow: hidden;">';
    echo '<div style="padding:5px 0"><input name="update_level" type="radio" value="high" ';
    if( $update_level=="" || $update_level=="high" ) :
        echo ' checked="checked"';
    endif;
    echo ' />通常更新</div><div style="padding:5px 0"><input name="update_level" type="radio" value="low" ';
    if( $update_level=="low" ) :
        echo ' checked="checked"';
    endif;
    echo ' />修正のみ</div>';
    echo '<div style="padding:5px 0"><input name="update_level" type="radio" value="del" ';
    echo ' />更新日時消去(公開日時と同じにする)</div>';
    echo '<div style="padding:5px 0;margin-bottom:10px"><input id="update_level_edit" name="update_level" type="radio" value="edit" ';
    echo ' />更新日時変更</div>';

    $datef = __( 'M j, Y @ G:i' );
    if( get_the_date('c') ) {
        $stamp = __('更新日時: <b>%1$s</b>');
    }
    else {
        $stamp = __('更新日時: <b>未更新</b>');
    }
    $date = date_i18n( $datef, strtotime( $post->post_modified ) );
?>
<style>
.modtime { padding: 2px 0 1px 0; display: inline !important; height: auto !important; }
.modtime:before { font: normal 20px/1 'dashicons'; content: '\f145'; color: #888; padding: 0 5px 0 0; top: -1px; left: -1px; position: relative; vertical-align: top; }
#timestamp_mod_div { padding-top: 5px; line-height: 23px; }
#timestamp_mod_div p { margin: 8px 0 6px; }
#timestamp_mod_div input { border-width: 1px; border-style: solid; }
#timestamp_mod_div select { height: 21px; line-height: 14px; padding: 0; vertical-align: top;font-size: 12px; }
#aa_mod, #jj_mod, #hh_mod, #mn_mod { padding: 1px; font-size: 12px; }
#jj_mod, #hh_mod, #mn_mod { width: 2em; }
#aa_mod { width: 3.4em; }
</style>
<span class="modtime"><?php printf($stamp, $date); ?></span>
<div id="timestamp_mod_div" onkeydown="document.getElementById('update_level_edit').checked=true" onclick="document.getElementById('update_level_edit').checked=true">
<?php global $action;touch_time_mod(($action == 'edit'), 1); ?>
</div>
</div>
<?php
}

/* 更新日時変更の入力フォーム */
function touch_time_mod() {
    global $wp_locale, $post;

    $tab_index = 0;
    $tab_index_attribute = "";
    if ( (int) $tab_index > 0 ) {
        $tab_index_attribute = " tabindex=\"$tab_index\"";
    }

    $jj_mod = mysql2date( 'd', $post->post_modified, false );
    $mm_mod = mysql2date( 'm', $post->post_modified, false );
    $aa_mod = mysql2date( 'Y', $post->post_modified, false );
    $hh_mod = mysql2date( 'H', $post->post_modified, false );
    $mn_mod = mysql2date( 'i', $post->post_modified, false );
    $ss_mod = mysql2date( 's', $post->post_modified, false );

    $month = '<label for="mm_mod" class="screen-reader-text">' . __( 'Month' ) .
        '</label><select id="mm_mod" name="mm_mod"' . $tab_index_attribute . ">\n";
    for ( $i = 1; $i < 13; $i = $i +1 ) {
        $monthnum = zeroise($i, 2);
        $month .= "\t\t\t" . '<option value="' . $monthnum . '" ' . selected( $monthnum, $mm_mod, false ) . '>';
        $month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) );
        $month .= "</option>\n";
    }
    $month .= '</select>';

    $day = '<label for="jj_mod" class="screen-reader-text">' . __( 'Day' ) .
        '</label><input type="text" id="jj_mod" name="jj_mod" value="' .
        $jj_mod . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
    $year = '<label for="aa_mod" class="screen-reader-text">' . __( 'Year' ) .
        '</label><input type="text" id="aa_mod" name="aa_mod" value="' .
        $aa_mod . '" size="4" maxlength="4"' . $tab_index_attribute . ' autocomplete="off" />';
    $hour = '<label for="hh_mod" class="screen-reader-text">' . __( 'Hour' ) .
        '</label><input type="text" id="hh_mod" name="hh_mod" value="' . $hh_mod .
        '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
    $minute = '<label for="mn_mod" class="screen-reader-text">' . __( 'Minute' ) .
        '</label><input type="text" id="mn_mod" name="mn_mod" value="' . $mn_mod .
        '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';

    printf( __( '%1$s %2$s, %3$s @ %4$s : %5$s' ), $month, $day, $year, $hour, $minute );
    echo '<input type="hidden" id="ss_mod" name="ss_mod" value="' . $ss_mod . '" />';
}

/* 設定したカスタムフィールドの値をDBに書き込む記述 */
function save_custom_field_postdata( $post_id ) {
    if (!empty($_POST['update_level'])){
    	$mydata = $_POST['update_level'];
    } else {
    	delete_post_meta( $post_id, 'update_level' ) ;
    	return;
    }
    if( $mydata == "edit" ){ $mydata = "low"; }
    elseif( $mydata == "del" ){ $mydata = ""; }

    if( "" == get_post_meta( $post_id, 'update_level' )) {
        /* update_levelというキーでデータが保存されていなかった場合、新しく保存 */
        add_post_meta( $post_id, 'update_level', $mydata, true ) ;
    } elseif( $mydata != get_post_meta( $post_id, 'update_level' )) {
        /* update_levelというキーのデータと、現在のデータが不一致の場合、更新 */
        update_post_meta( $post_id, 'update_level', $mydata ) ;
    } elseif( "" == $mydata ) {
        /* 現在のデータが無い場合、update_levelというキーの値を削除 */
        delete_post_meta( $post_id, 'update_level' ) ;
    }
}
 
/* 「修正のみ」は更新しない。それ以外は、それぞれの更新日時に変更する */
add_filter( 'wp_insert_post_data', 'my_insert_post_data', 10, 2 );
function my_insert_post_data( $data, $postarr ){
	if (!empty($_POST['update_level'])){
    	$mydata = $_POST['update_level'];
    } else {
    	return $data;
    }
    if( $mydata == "low" ){
        unset( $data["post_modified"] );
        unset( $data["post_modified_gmt"] );
    }
    elseif( $mydata == "edit" ) {
        $aa_mod = ($_POST['aa_mod'] <= 0 ) ? date('Y') : $_POST['aa_mod'];
        $mm_mod = ($_POST['mm_mod'] <= 0 ) ? date('n') : $_POST['mm_mod'];
        $jj_mod = ($_POST['jj_mod'] > 31 ) ? 31 : $_POST['jj_mod'];
        $jj_mod = ($jj_mod <= 0 ) ? date('j') : $jj_mod;
        $hh_mod = ($_POST['hh_mod'] > 23 ) ? $_POST['hh_mod'] -24 : $_POST['hh_mod'];
        $mn_mod = ($_POST['mn_mod'] > 59 ) ? $_POST['mn_mod'] -60 : $_POST['mn_mod'];
        $ss_mod = ($_POST['ss_mod'] > 59 ) ? $_POST['ss_mod'] -60 : $_POST['ss_mod'];
        $modified_date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $aa_mod, $mm_mod, $jj_mod, $hh_mod, $mn_mod, $ss_mod );
        if ( ! wp_checkdate( $mm_mod, $jj_mod, $aa_mod, $modified_date ) ) {
            unset( $data["post_modified"] );
            unset( $data["post_modified_gmt"] );
            return $data;
        }
        $data["post_modified"] = $modified_date;
        $data["post_modified_gmt"] = get_gmt_from_date( $modified_date );
    }
    elseif( $mydata == "del" ) {
        $data["post_modified"] = $data["post_date"];
    }
    return $data;
}