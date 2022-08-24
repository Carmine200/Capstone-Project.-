<!DOCTYPE HTML>
<html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="with=device-width, install-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ei=edge">
  <title> APIs Music </title>

  <link rel="stylesheet" href="/api_music/styles.css">
 </head>

 <body>
   <header>
     <?php if(! Auth::isLoggedIn()): ?>
       <img src="music_api.jpg" alt="Favorite Music Blog" width=100% height="150">
    <?php endif; ?>
   </header>

   <nav>
     <ul class="links">

       <li class="link"><a href="/api_music/">Home</a></li>
       <li class="link"><a href="/api_music/search_page.php">Step Through</a></li>

       <?php if(Auth::isLoggedIn()): ?>
          <li class="link"><a href="/api_music/admin/">Admin</a></li>
       <?php else: ?>
       <?php endif; ?>


       <li class="link"><a href="/api_music/about.php">About</a></li>

     </ul>
   </nav>
   <main>
