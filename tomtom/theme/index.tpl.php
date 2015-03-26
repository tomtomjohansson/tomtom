<!doctype html>
<html class='no-js' lang='<?=$lang?>'>

<head>
<meta charset='utf-8'/>
<title><?=get_title($title)?></title>
<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
<?php foreach($stylesheets as $val): ?>
<link rel='stylesheet' type='text/css' href='<?=$val?>'/>
<?php endforeach; ?>
<script src='<?=$modernizr?>'></script>
<link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Italianno' rel='stylesheet' type='text/css'>
</head>
<body>
  <div id='header'><?=$header?></div>

  <div id='content'>

    
    <?php if(isset($navbar)): ?><div id='navbar'><?=get_navbar($navbar)?></div><?php endif; ?>
    <div id='main'><?=$main?></div>
    <div id='footer'><?=$footer?></div>
  </div>

<?php if(isset($jquery)):?><script src='<?=$jquery?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$val?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
