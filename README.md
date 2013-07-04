MuseiD OPENDATA for Wordpress
================

Plugin che permette la visualizzazione,all'interno di un post, di una collezione museale presente nel portale MuseiD

Descrizione
================

<p>Museid-Wordpress aggiunge ad un post una o più collezioni museali contenute nel database opendata di <a target="_blank" href="http://www.culturaitalia.it/opencms/museid/index_museid.jsp">MuseiD</a>, progetto del MIBAC.
Ad ogni collezione museale corrisponde un identificatore univoco: ad esempio la <a href="http://www.culturaitalia.it/opencms/opencms/system/modules/com.culturaitalia_stage.liberologico/templates/museid/viewItem.jsp?language=it&id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445">"Collezione Pansa"</a>, custodita nel Museo archeologico nazionale di Villa Frigerj,
è identificata con la stringa <b>coll-445</b>. All'interno delle schede di MuseiD, l'identificatore della collezione è individuabile nella descrizione della scheda, nei breadcrumbs e nell'url della pagina.</p>
<p>Il plugin recupera i metadati e i thumbnails delle opere presenti nella collezione attraverso un parsing dalla <a href="http://www.culturaitalia.it/opencms/opencms/system/modules/com.culturaitalia_stage.liberologico/templates/museid/MetadataExport?id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445" target="_blank">versione XML (vocabolario PICO)</a> della scheda.</p>
<p>Inoltre il plugin supporta <a target="blank" href="http://buddypress.org">Buddypress</a>, abilitando nuove funzionalità nel plugin di social network di Wordpress.</p>

Funzionalità
================

Il plugin [shortcode]

<a href="http://cult.riqua.eu/reggia-di-caserta/">uii</a>
Una pagina funzionante del plugin (senza Buddypress) è consultabile all'indirizzo <a href="http://wp-museid.riqua.eu/">http://wp-museid.riqua.eu/</a>

Funzionalità per Buddypress
================

Museid-Wordpress 


Condividi sulle attività: se Buddypress è attivo, su ogni opera visualizzata comparirà un pulsante attraverso cui segnalare l'opera nello stream delle attività di Buddypress (bp-activity).

<img src="https://github.com/Riqua/museid-wordpress/blob/master/buddypress-screenshot.PNG" />
