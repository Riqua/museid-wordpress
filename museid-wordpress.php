<?php
/*
Plugin Name: Wordpress-MuseiD
Plugin URI: https://cult.riqua.eu
Description: Questo plugin permette il recupero dei metadati (foto, descrizione, etc) riguardo le collezioni museali contenute su MuseiD, database opendata dei beni culturali italiani realizzato in seno al progetto Culturaitalia. Il plugin fornisce inoltre funzionalità aggiuntive al plugin <a href="">Buddypress</a>.
Version: 0.1
Author: Stefano Colarelli
Author URI: http://riqua.eu


Copyright 2012-2013  Associazione Riqua  (email: info@riqua.eu)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function culturaitalia_ajax() {
  check_ajax_referer( "helloculturaitalia");
	$europeana = 'oai%3Aculturaitalia.it%3Amuseiditalia-coll'.$_POST['elementi'];
	$ricerca = $_POST['parole'];
	$blocco = $_POST['blocco'];
	$ricercasafe=urlencode($ricerca);
	$postlink = $_POST['luogoid'];
	echo listaCulturaitalia($europeana,$ricercasafe,$blocco,$postlink);
	die();
}
add_action( 'wp_ajax_culturaitalia', 'culturaitalia_ajax' ); 
add_action( 'wp_ajax_nopriv_culturaitalia', 'culturaitalia_ajax' ); 

// si può mettere la condizione se è presente buddypress?
function schedaculturaitalia_ajax() {
	check_ajax_referer( "helloculturaitalia");
	$europeana = $_POST['scheda'];
	echo schedaCulturaitalia($europeana);
	die();
}
add_action( 'wp_ajax_schedaculturaitalia', 'schedaculturaitalia_ajax' ); 
add_action( 'wp_ajax_nopriv_schedaculturaitalia', 'schedaculturaitalia_ajax' );  

function piaceculturaitalia_ajax() {
	check_ajax_referer( "helloculturaitalia");
	$titolo = $_POST['titolo'];
	$elementi = $_POST['elementi'];
	$opera = $_POST['opera'];
	$linkopera = $_POST['linkopera'];
	$linkimg = $_POST['linkimg'];
	$postlink = $_POST['luogoid'];
	echo add_activity_culturaitalia($elementi, $titolo, $postlink, $opera, $linkopera, $linkimg);
	die();
}
add_action( 'wp_ajax_piaceculturaitalia', 'piaceculturaitalia_ajax' ); 
add_action( 'wp_ajax_nopriv_piaceculturaitalia', 'piaceculturaitalia_ajax' ); 


add_shortcode('collezione', 'collectCulturaitalia');
function collectCulturaitalia($atts) {
		extract(shortcode_atts(array(
		'link' => '#',
		'tipo' => '',
		'click' => 'no',
		'esplora' => 'la sezione'
	), $atts));
	global $post;
	if($atts[click]=='info'){wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');}
	wp_enqueue_script('wookmark', plugins_url('js/jquery.wookmark.min.js',__FILE__), array('jquery'), '1.0');
	if($atts[click]=='zoom'){wp_enqueue_script('zoomooz', plugins_url('js/jquery.zoomooz.min.js',__FILE__), array('jquery'));}
	wp_register_style( 'wp-museid-style', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style( 'wp-museid-style' );
	$stampa = '';
	$blocco =1;
	$stampa .= '<a id="guarda-culturaitalia" class="apps-location guarda-culturaitalia'.strpbrk($atts[link], '_').'" onClick="caricaCulturaitalia(\''.strpbrk($atts[link], '_').'\',\''.$ricerca.'\', '.$blocco.')">Esplora '.$atts[esplora].'</a>';
			$nonce = wp_create_nonce( 'helloculturaitalia');
			if ( $atts[tipo] != 'secondario' ){
			$stampa .= '<script  type="text/javascript"><!-- 
			function caricaCulturaitalia(coll, ricerca, pagina){
				jQuery.ajax({
					type: "post",url: "'.get_bloginfo('url').'/wp-admin/admin-ajax.php",data: {
						action: \'culturaitalia\', _ajax_nonce: \''.$nonce.'\', elementi: coll, parole: ricerca, blocco: pagina, luogoid:\''.$post->ID.'\' 
					},
					beforeSend: function() {
						jQuery(".apps-location").not(".guarda-culturaitalia"+coll).show(0);
						if (jQuery("#helloculturaitalia").hasClass("helloculturaitalia"+coll)){jQuery(".navigation-europeana").hide();}
						else{jQuery("#helloculturaitalia").empty();
						jQuery("#helloculturaitalia").addClass("helloculturaitalia"+coll);}
						jQuery(".guarda-culturaitalia"+coll).after(jQuery("#wrap-culturaitalia"));
						jQuery("#caricamento").show("fast");
						jQuery("#europeana-box").fadeTo(0, 0.3);
						jQuery(".guarda-culturaitalia"+coll).hide(0);
					},
					complete: function() { jQuery("#caricamento").hide("fast");},
					success: function(html){ //so, if data is retrieved, store it in html
						jQuery(".navigation-europeana").show();
						jQuery("#europeana-box").fadeTo(0, 1);
						jQuery("#helloculturaitalia").html(html); 
						jQuery("#helloculturaitalia").show(mostraWookmark());';
			if($atts[click]=='zoom'){$stampa .='
						jQuery("#main").addClass("zoomViewport");
						jQuery("#europeana-box").addClass("zoomContainer");
						jQuery(".europeana_object").zoomTarget({targetsize:0.95, duration:600, nativeanimation:true, closeclick:true});';}
			if($atts[click]=='info'){$stampa .='	jQuery( \'.scheda-descrittiva\' ).click(function(){
							var id = this.id;
							jQuery.ajax({
								type: "post",url: "'.get_bloginfo('url').'/wp-admin/admin-ajax.php",data: {
									action: \'schedaculturaitalia\', _ajax_nonce: \''.$nonce.'\', scheda: id 
								},
								beforeSend: function() {
									jQuery("#caricamento-elemento").show("fast");
									tb_show("Scheda descrittiva","#TB_inline?height=360&width=700&inlineId=caricamento-elemento");
									jQuery("#TB_ajaxContent").append("<div class=\'caricamento\'>Stiamo caricando la scheda...</div>")
									jQuery("#TB_title").after("<div id=\'content-thickbox\'></div>");
								},
								success: function(html){
									jQuery("#content-thickbox").html(html);
									jQuery("#TB_ajaxContent").hide(0);
								}
							});
					});';}
			$stampa .='},
					error: function() {}
				}); //close jQuery.ajax(
			}';
			$stampa .='
			function mostraWookmark() {
							var options = {
								autoResize: true,
								container: jQuery(\'#europeana-box\'),
								offset: 14
								//itemWidth: 210 
							};
							var handler = jQuery(\'.europeana_object\');
							handler.wookmark(options);
							jQuery(window).scroll(function () { 
								handler.wookmark(options);
							});
						}';
			$stampa .='
						function likeCulturaitalia(scheda, oggetto, link, immagine){
							jQuery.ajax({
								type: "post",
								url: "'.get_bloginfo('url').'/wp-admin/admin-ajax.php",
								data: {
									action: \'piaceculturaitalia\', _ajax_nonce: \''.$nonce.'\',elementi: scheda, titolo:\''.get_the_title($post->ID).'\', luogoid:\''.$post->ID.'\', opera: oggetto, linkopera: link, linkimg: immagine
								},
								success: function(){
											 alert( "Hai segnalato l\'opera come rilevante" );
										  }
							});
						}';
			 $stampa .='
			-->
			</script>';
			$stampa .='<div id="wrap-culturaitalia">
				<style>
				.europeana-button #respond{padding:8px;width:180px;margin:5px 0;}
				.europeana-button h3#reply-title{display:none;}
				.europeana-button .comment-avatar-box{display:none;}
				.europeana-button textarea:focus {background:#fff;}
				.europeana-button textarea{font-size:11px;height:100px;}
				.europeana-button .form-allowed-tags{display:none;}
				.europeana-button div.comment-content{width:100% !important;}
				</style>';
				$stampa .='<a id=\'chiudi-europeana\' style=\'display:none;\' href=\'#\'>Chiudi la collezione</a>
			<div id=\'caricamento\' style=\'display:none;\'>Stiamo caricando la collezione...</div>
			<div id=\'helloculturaitalia\'></div>
			</div>';	
						} //endif
	return $stampa;}
	
	
function listaCulturaitalia($collezione, $ricerca, $blocco, $postid) {
$posttitolo=get_the_title($postid);
$postlink=get_permalink($postid);
	$url = 'http://www.culturaitalia.it/opencms/museid/MetadataExport?id='.$collezione;
	$coll = strpbrk($collezione, '_');
	$xmlDoc = new DOMDocument();
	$xmlDoc->load($url);
	$x = $xmlDoc->documentElement;
	$totale = $x->getElementsByTagNameNS('http://purl.org/dc/terms/', 'hasPart')->length;
	$blocchi = ceil($totale/12);
	$count = 0;
	$limit = 12*$blocco;
	$stampa .='</div></div>';
	if($ricerca != ''){
		$ricerca = str_replace('+',' ',$ricerca);
		$stampa .='<span style="float:right;margin-right:10px;">risultati ottenuti per la ricerca: <b>'.$ricerca.'</b></span>';
	}
	$stampa .='<ul id="europeana-box">';
	//$stampa .='tot='.$totale.', blocchi='.$blocchi.' blocco='.$blocco.' e '.$url.'<br />';
	foreach ($x->getElementsByTagNameNS('http://purl.org/dc/terms/', 'hasPart') as $item){
	if($count>($limit-13)){
		if($count==$limit){ //navigazione e crediti
		$stampa .='</ul>';
		if ($blocchi > 1){
			$next = $blocco+1;
			$prec = $blocco-1;
			$stampa .= '<h1 id="navigazione-'.$next.'" class="navigation-europeana-title">';
			if($blocco > 1){
				$stampa .= '<a class="navigation-europeana" onClick="caricaCulturaitalia(\''.$coll.'\', \''.$ricerca.'\', '.$prec.')"><<</a> ';
			}
			if ($blocchi > $blocco){
				$stampa .= '<a class="navigation-europeana" onClick="caricaCulturaitalia(\''.$coll.'\', \''.$ricerca.'\', '.$next.')">Guarda altre opere</a> <a class="navigation-europeana" onClick="caricaCulturaitalia(\''.$coll.'\', \''.$ricerca.'\', '.$next.')">>></a>';
			}
			$stampa .= '</h1>';
		}
		$stampa .= '<div style="text-align:right"><a style="margin-top:-50px" href="http://www.europeana.eu" target="_blank"><img title="Powered by Culturaitalia.it" src="http://cult.riqua.eu/wp-content/themes/bp-cult/img/poweredyeuropeana-black.png" /></a></div>'; // credits to europeana
		break;}
		else{
		$xmlNode = new DOMDocument();
		$urN='http://www.culturaitalia.it/opencms/museid/MetadataExport?id=' . $item->nodeValue;
		$xmlNode->load($urN);
		$xn = $xmlNode->documentElement;
		$trovato=true;
		foreach($xn->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'title') as $link){
			$titolo = $link->nodeValue;
			if($ricerca != ''){
				if(!stripos($titolo, $ricerca)){
				$trovato=false;
					/* foreach($xn->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'description') as $descr){
						if(!stripos($descr, $ricerca)){
						$trovato=false;
						}
					} */
				}
			}
		foreach($xn->getElementsByTagNameNS('http://purl.org/pico/1.0/', 'preview') as $immagine){
		if(!$trovato){
		break;}
		$stampa .='<li class="europeana_object">';
		$stampa .= '<div class="europeana-button europeana-button-hover">';
		if ( !is_user_logged_in() ) {
			$stampa .= '<span style="font-size:0.6rem;vertical-align: top;float: right;"><a href="http://cult.riqua.eu/wp-login.php">Connettiti per le altre opzioni</a></span>';
		}
		else{
			$stampa .= '<a class="fav likeeuropeana" OnClick="likeCulturaitalia(\''.$item->nodeValue . '\',\''.htmlspecialchars($titolo, ENT_QUOTES, 'UTF-8').'\',\'http://www.culturaitalia.it/opencms/museid/viewItem.jsp?language=it&case=&id=' . $item->nodeValue .'\',\''.$immagine->nodeValue.'\');" title="Aggiungi ai preferiti"> </a>';
		}
		$stampa .= '</div>';
		$stampa .='<a class="scheda-culturaitalia scheda-descrittiva" id="'.$item->nodeValue . '" title="'.$titolo.'"><img src="'.$immagine->nodeValue . '" width="200px"/></a>';
		$stampa .= '<h4 style="font-size:13px;">'.$titolo. '</h4> <a href="http://www.culturaitalia.it/opencms/museid/viewItem.jsp?language=it&case=&id=' . $item->nodeValue . '" target="_blank" class="europeana-link europeana-piu_info">(Fonte)</a>';
		$stampa .='</li>';
		}}
		}}$count++;}
	return $stampa;
}

function schedaCulturaitalia($collezione) {
	$url = 'http://www.culturaitalia.it/opencms/museid/MetadataExport?id='.$collezione;
	$stampa ='<div class="schedaculturaitalia">';
	$xmlNode = new DOMDocument();
	$xmlNode->load($url);
	$xn = $xmlNode->documentElement;
	$stampa .= '<h5>Nome</h5>';
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'title') as $link){
		$stampa .= '<div>'.$link->nodeValue. '</div>';
	}
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'creator') as $link){
		$stampa .= '<h5>Autore</h5><div>'.$link->nodeValue.'</div>';
	}
	$stampa .= '<h5>Descrizione</h5>';
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'description') as $link){
		$stampa .= '<div>'.$link->nodeValue.'</div>';
	}
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/terms/', 'created') as $link){
		$stampa .= '<h5>Epoca</h5><div>'.$link->nodeValue.'</div>';break;
	}
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/terms/', 'spatial') as $link){
		$stampa .= '<h5>Collocazione</h5><div>'.$link->nodeValue.'</div>';break;
	}
	$stampa .= '<h5>Materiale e tecnica</h5>';
	foreach($xn->getElementsByTagNameNS('http://purl.org/pico/1.0/', 'materialAndTechnique') as $link){
		$stampa .= '<div>'.$link->nodeValue.'</div>';
	}
	$stampa .= '<h5>Dimensioni</h5>';
	foreach($xn->getElementsByTagNameNS('http://purl.org/dc/terms/', 'extent') as $link){
		$stampa .= '<div>'.$link->nodeValue.'</div>';
	}
	$stampa .='</div>';
	return $stampa;
}

//buddypress function
function add_activity_culturaitalia($elementi, $titolo, $postlink, $opera, $linkopera, $immagine){
global $bp, $current_user;
 if ( function_exists( 'bp_activity_add' ) ){
 if ( version_compare( BP_VERSION, '1.3', '>' ) ){
 $user_id = $current_user->id;
 
 $userlink = bp_core_get_userlink( $user_id );

 bp_activity_add( array(
 'user_id' => $user_id,
 'item_id' => $postlink,
 'action' => sprintf( __( '%s piace l&#039;opera "%s", custodita nel Luogo: %s', 'attendingusers' ), $userlink, '<a href="'.$linkopera.'" >'.$opera.'</a>', '<a href="'.get_permalink( $postlink ).'">'.$titolo.'</a>' ),
 'content' => '<a id="'.$elementi. '" class="scheda-culturaitalia" title="'.$titolo.'" rel="culturaitalia-gallery"><img src="'.$immagine.'" alt="'.$titolo.'" width="300px" /></a>',
 'primary_link' => '<a href="'.get_permalink( $postlink ).'" >'.$titolo.'</a>',
 'component' => 'profile',
 'type' => 'mipiace_opera',
 ) );
}}}

?>
