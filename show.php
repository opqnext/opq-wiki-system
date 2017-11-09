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
    var diff2htmlUi = new Diff2HtmlUI({diff: "f9eb2d4 修改了MTZ文件 diff --git a/8.html b/8.html index 4d9495e..6bce554 100644 --- a/8.html +++ b/8.html @@ -3,8 +3,9 @@ 听少爷说他在说这些不是我的错 难道说这么多都是孩儿惹的祸 阿玛说阿玛说人生不可重来过 -废话还是最好尽量地少说为妙 +1. 年轻的确很美但骄傲是你不对 - 应该关爱社会你也得感动落泪 - 不管你是否想要简化些的思维 -- 年轻的确很美但骄傲是你不对 \ No newline at end of file +1. 年轻的确很美但骄傲是你不对 +2. 年轻的确很美但骄傲是你不对"});
    diff2htmlUi.draw('html-target-elem', {inputFormat: 'diff', showFiles: true, matching: 'lines'});
</script>