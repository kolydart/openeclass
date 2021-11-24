<?php

$require_current_course = true;
require_once '../../include/baseTheme.php';
require_once 'classes/H5PFactory.php';

function upload_content() { // anebasma // na elen3w to database & na balw to user_input
    global $course_id, $course_code, $webDir;

    $upload_dir = $webDir . '/courses/temp/h5p/' . $course_code;
    if (file_exists($upload_dir)) {
        H5PCore::deleteFileTree($upload_dir);
    }
    mkdir($upload_dir, 0755, true);

    $target_file = $upload_dir . "/" . basename($_FILES["userFile"]["name"]);
    move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file);

    $factory = new H5PFactory();
    $framework = $factory->getFramework();
    
    $h5pPath = $webDir . '/courses/h5p';
    $classCore = new H5PCore($framework, $h5pPath, $upload_dir, 'en', FALSE);
    $classVal = new H5PValidator($framework, $classCore);
    $classStor = new H5PStorage($framework, $classCore);

    if ($classVal->isValidPackage()) {
        $classStor->savePackage();
        $content_id = Database::get()->querySingle("SELECT * FROM h5p_content WHERE course_id = ?d ORDER BY id DESC", $course_id)->id;

        // handle package title
        Database::get()->query("UPDATE h5p_content SET title = ?s WHERE id = ?d AND course_id = ?d", $classCore->mainJsonData["title"], $content_id, $course_id);

        // handle package final location and contents
        $courseH5pBase = $webDir . "/courses/" . $course_code . "/h5p";
        $courseH5pWorkspace = $courseH5pBase . "/content/" . $content_id . "/workspace";
        $courseH5pContent = $courseH5pWorkspace . "/content";
        $srcH5pContent = $h5pPath . "/content/" . $content_id;

        mkdir($courseH5pContent, 0755, true);
        recurse_copy($srcH5pContent, $courseH5pContent);
        $fp = fopen($courseH5pWorkspace . "/h5p.json", "w");
        fwrite($fp, json_encode($classCore->mainJsonData));
        fclose($fp);

        return true;
    } else {
        return false;
    }
}