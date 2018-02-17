<!doctype html>
<?php
require "./gateway/Data.php";
$categories = Data::getCategoriesStructure();
$aboutMe = Data::getAboutMe();

?>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="insertCode portfolio website.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>insertCode - Portfolio</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="insertCode Portfolio">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <link rel="shortcut icon" href="images/favicon.ico">

    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=nl"
    >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.red-amber.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="mdl mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
            <div class="mdl-layout--large-screen-only mdl-layout__header-row">
            </div>
            <div class="mdl-layout--large-screen-only mdl-layout__header-row">
                <h3>insertCode Portfolio</h3>
            </div>
            <div class="mdl-layout--large-screen-only mdl-layout__header-row">
            </div>
            <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
				<?php
				// Add category tabs
				$first = true;
				foreach ($categories as $category) {
					?>
                    <a href="#<?php echo $category->getCssId(); ?>"
                       class="mdl-layout__tab <? if ($first) echo "is-active"; ?>">
						<?php echo $category->title; ?>
                    </a>
					<?php
					$first = false;
				}
				?>
                <a href="#about_me" class="mdl-layout__tab">About Me</a>
            </div>
        </header>
        <main class="mdl-layout__content">
			<?php
			//Add category pages
			$firstPage = true;
			foreach ($categories as $category) {
				echo "<div class=\"mdl-layout__tab-panel" . ($firstPage ? " is-active" : "") . "\" id=\"" . $category->getCssId() . "\"  style=\"background: #f5f5f5;\">";
				$firstPage = false;

				//Add project cards
				foreach ($category->items as $item) {
					if ($item instanceof Project) {
						?>
                        <section
                                class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp"
                        >
                            <div class="mdl-card mdl-cell mdl-cell--12-col">
                                <!--TODO: images-->
                                <div class="mdl-card__supporting-text">
                                    <h4><?php echo $item->title ?></h4>
                                    <!-- TODO: date -->
									<?php echo $item->shortDescription ?>
                                    <!-- TODO: fullDescription -->
                                </div>
                                <div class="mdl-card__actions">
                                    <!-- TODO: tags -->
                                    <!-- TODO: expand button -->
                                </div>
                            </div>
                        </section>
						<?php
					}
				}

				echo "</div>";
			}
			?>

            <!-- About Me page -->
            <div class="mdl-layout__tab-panel" id="about_me">
                <section class="section--center mdl-grid mdl-grid--no-spacing">
                    <div class="mdl-cell mdl-cell--12-col">
						<?php echo $aboutMe ?>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <footer class="mdl-mini-footer">
                <div class="mdl-mini-footer--bottom-section">
                    <div class="mdl-logo">
                        Meer informatie
                    </div>
                    <ul class="mdl-mini-footer--link-list">
                        <li><a href="https://github.com/MrTheGood/">Github</a></li>
                        <li><a href="mailto:mail@insertcode.eu">Mail</a></li>
                    </ul>
                </div>
            </footer>
        </main>
    </div>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
