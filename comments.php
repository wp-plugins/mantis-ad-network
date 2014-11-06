<?php
$location = get_option('mantis_recommend');

if($location == 'before_comments'){
    mantis_recommend_render();
}

comments_template();

if($location == 'after_comments'){
    mantis_recommend_render();
}
?>