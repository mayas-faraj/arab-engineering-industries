<?
    $type = 'html';//$_POST['mimetype'];
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';



        var_dump($_POST);
        foreach($_FILES as $file) {
            $n = $file['name'];
            $s = $file['size'];
            if (!$n) continue;
            echo "File: $n ($s bytes)";
        }

?> 