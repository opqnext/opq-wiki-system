<?php
/**
 * Created by PhpStorm.
 * User: momo
 * Date: 2017/11/8
 * Time: 下午1:56
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Asia/Shanghai');
require 'vendor/autoload.php';

$git = new PHPGit\Git();

$git->setRepository('/data/wiki.opqnext.com/wiki');

$hash = strval($_GET['hash']);
//
//echo $hash;
//var_dump($git->tree('master'));

$a = ['oneline', 'short', 'medium', 'full', 'fuller', 'email'];

$res =  $git->show($hash,['format'=>'oneline','abbrev-commit'=>true]);


echo $res;
?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="dist/diff2html.css">

<!-- Javascripts -->
<script type="text/javascript" src="dist/diff2html.js"></script>
<script type="text/javascript" src="dist/diff2html-ui.js"></script>

<div id="html-target-elem">

</div>

<div class="html-target-elem">

</div>

<script>
    var diff2htmlUi = new Diff2HtmlUI({diff: '<?php echo str_replace('\n','',$res);?>'});
    diff2htmlUi.draw('html-target-elem', {inputFormat: 'diff', showFiles: true, matching: 'lines'});
</script>