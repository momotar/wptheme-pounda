<?php
$check_author = $post->photo_author;
if (!empty($check_author)) {
    $repeat_group = SCF::get( 'photo_credit' );
    foreach ( $repeat_group as $fields ) {
        $photo_url = $fields['photo_url'];
        $photo_license = $fields['photo_license'];
        $license_url = 'unknown';
        if ($photo_license == 'CC0 1.0 Universal') {
            $license_url = 'http://creativecommons.org/publicdomain/zero/1.0/deed.ja';
        } elseif ($photo_license == 'CC Attribution 1.0') {
            $license_url = 'http://creativecommons.org/licenses/by/1.0/deed.ja';
        } elseif ($photo_license == 'CC Attribution 2.0') {
            $license_url = 'http://creativecommons.org/licenses/by/2.0/deed.ja';
        } elseif ($photo_license == 'CC Attribution 3.0') {
            $license_url = 'http://creativecommons.org/licenses/by/3.0/deed.ja';
        } elseif ($photo_license == 'CC Attribution 4.0') {
            $license_url = 'http://creativecommons.org/licenses/by/4.0/deed.ja';
        }
    ?>
        <p>Photo <a href="<?php echo $photo_url; ?>">
                        <?php echo $check_author; ?></a></p>
                        <p>Photo License <a href="<?php echo $license_url; ?>">
                    <?php echo $photo_license; ?></a></p>
    <?php
    }
}
?>