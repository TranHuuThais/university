$icon_url = get_post_meta(get_the_ID(), 'teacher_icon_url', true);
if ($icon_url) {
    echo '<img src="' . esc_url($icon_url) . '" alt="Teacher Icon" style="width: 50px; height: auto;">';
}
