<?php
    include('functions.php');
    $wiki_data = getWikiData();
?>

<html>
<head>
    <title>Tweebly's Fascinating Dailies</title>
    <meta name="description" content="A daily literature of randomly odd information.">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="_assets/style.css">
    <script src="_assets/script.js" defer></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-42051595-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-42051595-1');
    </script>
</head>
<body>

<div class="funline">A daily literature of randomly odd information.</div>
<header>
    <div class="logo" alt="logo"></div>
    <div id="date"></div>
</header>

<main>
    <div class="content" id="wiki">
        <h1><a href="<?php echo $wiki_data['url'];?>"><?php echo $wiki_data['title']; ?></a></h1>
        <p>
            <?php  

                // Loop through every 5th period and add a line break
                $content = $wiki_data['content']; ;
                $content = preg_replace('/(.+?)\. (.+?)\. /', '$1. $2.<br><br>', $content);
                echo $content;
                
            ?>
        </p>
        <div class="credit"> - <a href="<?php echo $wiki_data['url'];?>">Wikipedia</a></div>
    </div>

    <div class="center"><a href="mailto:info@mishavinokur.com" class="btn">Report an Item</a></div>
</main>

<footer>
    <div class="cc"><br><a href="https://mishavinokur.com">©<span id="foot-date"></span> Misha Vinokur</a></div>
</footer>

</body>
</html>