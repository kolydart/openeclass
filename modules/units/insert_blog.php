<?php

/**
 * @brief list available blogs
 */
function list_blogs() {
    global $id, $course_id, $tool_content, $urlServer,
           $langAddModulesButton, $langChoice, $langBlogEmpty,
           $langBlogPostTitle, $course_code, $langBlogPosts;

    $result = Database::get()->queryArray("SELECT * FROM blog_post WHERE course_id = ?d ORDER BY time DESC", $course_id);
    $bloginfo = array();
    foreach ($result as $row) {
        $bloginfo[] = array(
            'id' => $row->id,
            'name' => $row->title,
            'content' => $row->content);
    }
    if (count($bloginfo) == 0) {
        $tool_content .= "<div class='col-sm-12'><div class='alert alert-warning'>$langBlogEmpty</div></div>";
    } else {
        $tool_content .= "<form action='insert.php?course=$course_code' method='post'>" .
            "<input type='hidden' name='id' value='$id'>" .
            "<div class='table-responsive'><table class='table-default'>" .
            "<tr class='list-header'>" .
            "<th width='80'>$langChoice</th>" .
            "<th><div class='text-start'>&nbsp;$langBlogPosts</div></th>" .
            "<th><div class='text-start'>$langBlogPostTitle</div></th>" .
            "</tr>";

        foreach ($bloginfo as $entry) {
            $tool_content .= "<tr>";
            $tool_content .= "<td class='text-center'><input type='checkbox' name='blog[]' value='$entry[id]'></td>";
            $tool_content .= "<td><a href='{$urlServer}modules/blog/index.php?course=$course_code&action=showPost&pId=$entry[id]'>" . q($entry['name']) . "</a></td>";
            $tool_content .= "<td>" . $entry['content'] . "</td>";
            $tool_content .= "</tr>";
        }
        $tool_content .= "</table></div>";
        $tool_content .= "<div class='d-flex justify-content-center mt-3'>";
        $tool_content .= "<input class='btn submitAdminBtn' type='submit' name='submit_blog' value='$langAddModulesButton'></div></form>";
    }
}
