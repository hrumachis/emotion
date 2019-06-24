<?php
    require_once __DIR__.'/../src/Main.php';

    $totalMessages = MessagesTable::total(); // Total messages
    $totalPages = ceil( $totalMessages / ITEMS_PER_PAGE ); // Total pages 
    $pageGet = HttpGETValue::getIntNatural( 'page' ) > 1 ? HttpGETValue::getIntNatural( 'page' ) : 1; // Check page requeast value, normalize it
    $currentPage = $pageGet <= $totalPages ? $pageGet : $totalPages; // Compare to max pages, normalize it
    $offset = $totalMessages - $currentPage * ITEMS_PER_PAGE; // Calculate flipped table offset select
    $posts = MessagesTable::read( ITEMS_PER_PAGE, $offset > 0 ? $offset : 0 ); // array<Object>
    $postsCount = count( $posts ); // int

    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Žinutės</title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css" />
    </head>

    <body>
        <div id="wrapper" onsubmit="onSubmitEvent( event )">
            <h1>Jūsų žinutės</h1>
            <form method="post" action="?page=<?php echo $currentPage; ?>&action=sendMessage">
                <p class="<?php echo ApiErr::isError( 'fullName' ) ? "err" : ""; ?>">
                    <label for="fullname">Vardas, pavardė *</label><br/>
                    <input id="fullname" type="text" name="fullName" maxlength="255" value="<?php echo HttpPOSTValue::get( 'fullName' ); ?>" />
                </p>
                <p class="<?php echo ApiErr::isError( 'birthdate' ) ? "err" : ""; ?>">
                    <label for="birthdate">Gimimo data *</label><br/>
                    <input id="birthdate" type="date" name="birthdate" maxlength="255" value="<?php echo HttpPOSTValue::get( 'birthdate' ); ?>" />
                </p>
                <p class="<?php echo ApiErr::isError( 'email' ) ? "err" : ""; ?>" >
                    <label for="email">El.pašto adresas</label><br/>
                    <input id="email" type="text" name="email" maxlength="255" value="<?php echo HttpPOSTValue::get( 'email' ); ?>" />
                </p>
                <p class="<?php echo ApiErr::isError( 'message' ) ? "err" : ""; ?>">
                    <label for="message">Jūsų žinutė *</label><br/>
                    <textarea id="message" name="message" maxlength="<?php echo MSG_LENGTH_MAX; ?>"><?php echo HttpPOSTValue::get( 'message' ); ?></textarea>
                </p>
                <p>
                    <span>* - privalomi laukai</span>
                    <input id="submit" type="submit" value="Skelbti" />
                    <img id="loading" class="hidden" src="img/ajax-loader.gif" alt="" />
                </p>
            </form>
            <ul id="messages">
                <?php
                    if ( $postsCount > 0 ) {
                        for ( $i = $postsCount-1; $i >= 0; $i-- ) {
                            $post = $posts[ $i ];
                            $postTime = $post->post_date;
                            $email = $post->email;
                            $fullName = $post->fullName;
                            $birthdate = $post->birthdate;
                            $message = $post->message;
                            
                            echo "<li><span>$postTime</span>";

                            // Check if post have email
                            if ( $email ) {
                                echo "<a href='mailto:$email'>$fullName</a>";
                            } else {
                                echo $fullName;
                            }

                            echo ", ". CalculateYears::calc( $birthdate ) ."m. <br/>
                                $message
                            </li>";
                        }
                    } else {
                        echo '<li><strong>Šiuo metu žinučių nėra. Būk pirmas!</strong></li>';
                    }
                ?>
            </ul>
            <?php echo Pagination::getHTML( $currentPage, $totalPages ); ?>
        </div>

        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/api.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
