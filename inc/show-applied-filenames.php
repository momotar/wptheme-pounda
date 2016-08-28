<?php
function show_template_filenames() {
	global $template;
	$description = '[適用テンプレートファイル] ';
	$template_name = basename($template, '.php');
	echo '<p>', $description, $template_name, '.php', '</p>';
}
function show_included_filenames() {
	$inc_file_list = get_included_files();
	$inc_file_array = array();
	foreach ($inc_file_list as $inc_key => $inc_val) {
		if ( stristr($inc_val, 'themes') ) {
			$current_dir = get_template_directory().'/'; //親テーマのディレクトリを取得
			//テンプレートファイルのフルパスからテーマディレクトリからの相対パスに変換
			$file_slug = str_replace($current_dir, '', $inc_val);
			array_push($inc_file_array, $file_slug);
		}
	}
	echo  '[include ファイル]',
			'<ul style="list-style: inside disc;">';
	foreach ($inc_file_array as $inc_file_slug) {
		echo '<li>', $inc_file_slug, '</li>';
	}
	echo '</ul>';
} 
?>