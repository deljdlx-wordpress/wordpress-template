<section>
    <header class="customizer header" style="background-image: url(<?php
    // récupération de la variable 'header-image' du thème (elle est gérée par le customizer)
    // echo get_theme_mod('header-image', DEFAULT_HEADER_IMAGE);
    echo $theme->getParameter('content-header-image')->getValue(true)
    ?>)">
        <h2>
            <?php
                echo $theme->getParameter('content-header-title')->getValue(true);
            ?>
        </h2>
        <p>
            <?php
                echo $theme->getParameter('content-header-subtitle')->getValue(true);
            ?>
        </p>

    </header>
</section>