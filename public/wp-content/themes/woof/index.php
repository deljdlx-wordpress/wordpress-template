<?php
$theme = \Woof\Theme\Skeleton::getInstance();
?>
<!DOCTYPE html>
<html>
<head>
    <?php $theme->getView()->getHeader();?>
</head>
<body>


    <?php
        $theme->partial('partials/sections/customizer');
    ?>

    <?php
        $theme->partial('partials/sections/bootstrap');
    ?>

    <?php
        $theme->partial('partials/sections/vuejs');
    ?>

    <section>
        <h1>Headings 1 </h1>
        <h2>Headings 2 </h2>
        <h3>Headings 3 </h3>
        <h4>Headings 4 </h4>
        <h5>Headings 5 </h5>
        <h6>Headings 6 </h6>
    </section>

    <section>
        <h2>Theme Parameters</h2>
        <?php

        echo '<table>';
            echo '<thead><tr>';
                echo '<th>Name</th>';
                echo '<th>Value</th>';
                echo '<th>Default value</th>';
            echo '</tr><thead>';
            echo '<tbody>';
                foreach($theme->getParameters() as $parameterName => $parameter) {
                    echo '<tr>';
                        echo '<th>' . $parameterName .'</th><td>'  . $parameter->getValue() . '</td><td>'  . $parameter->getDefaultValue() . '</td>';
                    echo '</tr>';
                }
            echo '</tbody>';
        echo '</table>';
        ?>
    </section>

    <section>
        <?php
            foreach($theme->getModel()->getPosts() as $post) {
                echo "<article>
                    <h2>{$post->getTitle()}</h2>
                    <main>
                        <p>{$post->getContent()}</p>
                    </main>
                </article>";
            }
        ?>
    </section>

    <?php $theme->getView()->getFooter();?>
</body>
</html>
