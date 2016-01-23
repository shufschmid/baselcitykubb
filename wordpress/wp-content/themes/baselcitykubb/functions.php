<?php
/**
 * baselcitykubb functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package baselcitykubb
 */



/** Liga-Funktionen  */

function berechnen($elo1, $elo2, $saetze1, $saetze2){
    #formel P = K G (W - W_e) vgl. http://en.wikipedia.org/wiki/World_Football_Elo_Ratings#Basic_calculation_principles

    #k berechnen
    if($saetze1 > 5 || $saetze2 > 5){       $k = 60;    }
    elseif($saetze1 > 3 || $saetze2 > 3){   $k = 40;    }
    else{                                   $k = 20;    }

    #G berechnen
    if(abs($saetze1-$saetze2) == 2){        $g = 3/2;    }
    elseif(abs($saetze1-$saetze2) > 2){     $g = (11 + abs($saetze1-$saetze2))/8;    }
    else{                                   $g = 1;    }

    #w berechnen
    if($saetze1>$saetze2){                  $w = 1;    }
    elseif($saetze1<$saetze2){              $w = 0;    }
    else{                                   $w = 0.5;  }

    #W_e berechnen
    $we = 1 / (pow(10, -(($elo1-$elo2)/400)) +1);

    $punkte = $k * $g * ($w - $we);

    return $punkte;
}
#Name:	DJ
#Gegner	Elo	    Anz. Spiele	% Siege	Sätze S:N	Punkte
#Mu	    1922	22	        69	    44:12	    53
class KubbLigaArrayItem {
    public $id;
    public $name;
    public $anzSpiele;
    public $anzSiege;
    public $ProzSiege;
    public $saetzeG;
    public $saetzeV;
    public $Gegner;
    public $EloGegner;
    public $AnzGegner;
    public $elo;
    public $anzSpieleX;
    public $anzSiegeX;
    public $ProzSiegeX;
    public $saetzeGX;
    public $saetzeVX;
    public $punkteX;
    public $eloentwicklungX;

}


// sort function
function sortByElo($kubbLigaItem1, $kubbLigaItem2){

    if($kubbLigaItem1->elo == $kubbLigaItem2->elo){
        return 0;
    }

    return ($kubbLigaItem1->elo < $kubbLigaItem2->elo) ? 1 : -1;

}

//holt spiele
$spiele = $wpdb->get_results("SELECT * FROM `liga_spiele` ORDER BY `date` ASC ");
$spiele365 = $wpdb->get_results("SELECT * FROM `liga_spiele` WHERE date >= DATE(NOW() - INTERVAL 12 MONTH) ORDER BY `date` ASC ");
$spielesaison = $wpdb->get_results("SELECT * FROM `liga_spiele` WHERE (date BETWEEN '2013-01-01' AND '2013-05-01') ORDER BY `date` ASC ");


function getEinzelspieler($spiele, $curauth){
    return $curauth;
}

function getRanking($spiele, $X)
{
    global $letztespiele;
    $letztespiele = Array();
    global $letztespieleX;
    $letztespieleX = Array();

    $letztesspiel = Array();
    //holt benutzer
    $allewordpressnutzer = get_users();


    //definitives array, das zurückgegeben wird
    $ranking = Array();

    foreach ($allewordpressnutzer as $spieler) {
        $entry = new KubbLigaArrayItem(); // eine neue, leere Instanz von einem Tabelleneitrag

        // befüllt das neue objekt mit Name und Standard-Elo
        $entry->id = $spieler->id;
        $entry->name = $spieler->user_nicename;
        $entry->anzSpiele = 0;
        $entry->anzSiege = 0;
        $entry->ProzSiege = 0;
        $entry->saetzeG = 0;
        $entry->saetzeV = 0;
        $entry->EloGegner = 1500;
        $entry->Gegner = Array();
        $entry->elo = 1500;
        $entry->anzSpieleX = 0;
        $entry->anzSiegeX = 0;
        $entry->ProzSiegeX = 0;
        $entry->saetzeGX = 0;
        $entry->saetzeVX = 0;
        $entry->punkteX = 0;
        $entry->eloentwicklungX = Array();

        // array_push($ranking, $entry); // das neu erstellte entry Item wird dem array hinzugefügt
        $ranking[$spieler->id] = $entry;
    }

    foreach ($spiele as $spiel) {
        if($ranking[$spiel->spieler1]->elo == ""){
            echo $spiel->spieler1;
        }
        $punkte = berechnen($ranking[$spiel->spieler1]->elo, $ranking[$spiel->spieler2]->elo, $spiel->resultat1, $spiel->resultat2);

        $date = date_create($spiel->date);

        #temporäres Array für letzte Spiele füllen;
        $letztesspiel[0] = date_format($date, 'd.m. H:i');
        $letztesspiel[1] = $ranking[$spiel->spieler1]->name;
        $letztesspiel[2] = $ranking[$spiel->spieler2]->name;
        $letztesspiel[3] = intval($ranking[$spiel->spieler1]->elo);
        $letztesspiel[4] = intval($ranking[$spiel->spieler2]->elo);
        $letztesspiel[5] = $spiel->resultat1;
        $letztesspiel[6] = $spiel->resultat2;
        $letztesspiel[7] = $punkte;

        array_push($letztespiele, $letztesspiel);

        #elo hinzufügen
        $ranking[$spiel->spieler1]->elo += $punkte;
        $ranking[$spiel->spieler2]->elo -= $punkte;
        #Anzahl Spiele erhöhen
        $ranking[$spiel->spieler1]->anzSpiele += 1;
        $ranking[$spiel->spieler2]->anzSpiele += 1;
        #Anzahl Siege (des Siegers) erhöhen
        if($spiel->resultat1 > $spiel->resultat2){
            $ranking[$spiel->spieler1]->anzSiege += 1;
        }
        elseif($spiel->resultat1 < $spiel->resultat2){
            $ranking[$spiel->spieler2]->anzSiege += 1;
        }
        #Prozent gewonnene Spiele berechnen
        $ranking[$spiel->spieler1]->ProzSiege = ($ranking[$spiel->spieler1]->anzSiege / $ranking[$spiel->spieler1]->anzSpiele) * 100;
        $ranking[$spiel->spieler2]->ProzSiege = ($ranking[$spiel->spieler2]->anzSiege / $ranking[$spiel->spieler2]->anzSpiele) * 100;


        #gewonnene / verlorene Sätze hinzufügen
        $ranking[$spiel->spieler1]->saetzeG += $spiel->resultat1;
        $ranking[$spiel->spieler1]->saetzeV += $spiel->resultat2;
        $ranking[$spiel->spieler2]->saetzeG += $spiel->resultat2;
        $ranking[$spiel->spieler2]->saetzeV += $spiel->resultat1;

        #Durchschnittlicher Elo Gegner
        $ranking[$spiel->spieler1]->EloGegner = ($ranking[$spiel->spieler1]->EloGegner * ($ranking[$spiel->spieler1]->anzSpiele - 1) + $ranking[$spiel->spieler2]->elo) / $ranking[$spiel->spieler1]->anzSpiele;
        $ranking[$spiel->spieler2]->EloGegner = ($ranking[$spiel->spieler2]->EloGegner * ($ranking[$spiel->spieler2]->anzSpiele - 1) + $ranking[$spiel->spieler1]->elo) / $ranking[$spiel->spieler2]->anzSpiele;

        #Array Gegner füllen (für Anzahl Gegner)
        if(!in_array($ranking[$spiel->spieler2]->id, $ranking[$spiel->spieler1]->Gegner, true)){
            array_push($ranking[$spiel->spieler1]->Gegner, $ranking[$spiel->spieler2]->id);
        }
        if(!in_array($ranking[$spiel->spieler1]->id, $ranking[$spiel->spieler2]->Gegner, true)){
            array_push($ranking[$spiel->spieler2]->Gegner, $ranking[$spiel->spieler1]->id);
        }
        #Daten für Einzelspieler-Ansicht sammeln
        if($spiel->spieler1 == $X){
            #Anz Spiele gegen Gegner X erhöhen
            $ranking[$spiel->spieler2]->anzSpieleX += 1;



            #Bei Sieg Gegenspieler: Anzahl Siege gegen Spieler X erhöhen
            if($spiel->resultat1 < $spiel->resultat2){
                $ranking[$spiel->spieler2]->anzSiegeX += 1;
            }

            #Gewinnquote in Prozent gegen Spieler X
            $ranking[$spiel->spieler2]->ProzSiegeX = ($ranking[$spiel->spieler2]->anzSiegeX / $ranking[$spiel->spieler2]->anzSpieleX) * 100;

            #gewonnene / verlorene Sätze gegen Spieler X hinzufügen
            $ranking[$spiel->spieler2]->saetzeGX += $spiel->resultat2;
            $ranking[$spiel->spieler2]->saetzeVX += $spiel->resultat1;

            #gewonnene / verlorene Elo-Punkte gegen Spieler X hinzufügen
            $ranking[$spiel->spieler2]->punkteX -= $punkte;

            #Eloentwicklung
            $array = [
                "jsonDate" => $spiel->date,
                "jsonHitCount" => intval($ranking[$spiel->spieler1]->elo),
                "seriesKey" => "Website Usage"
            ];
            array_push($ranking[$spiel->spieler1]->eloentwicklungX, $array);
            array_push($letztespieleX, $letztesspiel);

        }
        elseif($spiel->spieler2 == $X){
            #Anz Spiele gegen Gegner X erhöhen
            $ranking[$spiel->spieler1]->anzSpieleX += 1;

            #Bei Sieg Gegenspieler: Anzahl Siege gegen Spieler X erhöhen
            if($spiel->resultat1 > $spiel->resultat2){
                $ranking[$spiel->spieler1]->anzSiegeX += 1;
            }

            #Gewinnquote in Prozent gegen Spieler X
            $ranking[$spiel->spieler1]->ProzSiegeX = ($ranking[$spiel->spieler1]->anzSiegeX / $ranking[$spiel->spieler1]->anzSpieleX) * 100;

            #gewonnene / verlorene Sätze gegen Spieler X hinzufügen
            $ranking[$spiel->spieler1]->saetzeGX += $spiel->resultat1;
            $ranking[$spiel->spieler1]->saetzeVX += $spiel->resultat2;

            #gewonnene / verlorene Elo-Punkte gegen Spieler X hinzufügen
            $ranking[$spiel->spieler1]->punkteX += $punkte;

            #Eloentwicklung
            $array = [
                "jsonDate" => $spiel->date,
                "jsonHitCount" => intval($ranking[$spiel->spieler2]->elo),
                "seriesKey" => "Website Usage"
            ];
            array_push($ranking[$spiel->spieler1]->eloentwicklungX, $array);

            #temporäres Array für letzte Spiele umkehren, wenn Spieler an zweiter Position genannt;
            $letztesspielInvers[0] = $letztesspiel[0];
            $letztesspielInvers[1] = $letztesspiel[2];
            $letztesspielInvers[2] = $letztesspiel[1];
            $letztesspielInvers[3] = $letztesspiel[4];
            $letztesspielInvers[4] = $letztesspiel[3];
            $letztesspielInvers[5] = $letztesspiel[6];
            $letztesspielInvers[6] = $letztesspiel[5];
            $letztesspielInvers[7] = $letztesspiel[7] * -1;


            array_push($letztespieleX, $letztesspielInvers);

        }
    }

    // do the actual sorting
    usort($ranking, "sortByElo");

    // return the array
    return $ranking;
}

if ( ! function_exists( 'baselcitykubb_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function baselcitykubb_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on baselcitykubb, use a find and replace
	 * to change 'baselcitykubb' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'baselcitykubb', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'baselcitykubb' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'baselcitykubb_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'baselcitykubb_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function baselcitykubb_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'baselcitykubb_content_width', 640 );
}
add_action( 'after_setup_theme', 'baselcitykubb_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function baselcitykubb_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'baselcitykubb' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'baselcitykubb_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function baselcitykubb_scripts() {
	wp_enqueue_style( 'baselcitykubb-style', get_stylesheet_uri() );

	wp_enqueue_script( 'baselcitykubb-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'baselcitykubb-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'baselcitykubb_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
