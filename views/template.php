<!DOCTYPE html>
<html>
    <head>
        <title>Paula Watt</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700" rel="stylesheet">
        <link rel="stylesheet"href="css/styles.css"/>
        <link rel="stylesheet"href="css/hotel.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/hotels.js"></script>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <span class="logo">
                    <img src="images/Glyph_greenshadow.png"/>
                </span>
                <span class="name">Paula Watt</span>
            </div>
        </header>

		<?=$this->section('content')?>

        <footer class="footer">
            <div class="container">
                <?php //  &copy; copyright here ?>
            </div>
        </footer>
    </body>
</html>