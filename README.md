MuseiD OPENDATA for Wordpress
================

<p>Museid-wordpress è un plugin che permette la visualizzazione, all'interno di un articolo, di una collezione museale presente nel portale <a target="_blank" href="http://www.culturaitalia.it/opencms/museid/index_museid.jsp">MuseiD</a>.</p>
<p>Il plugin recupera i metadati e i thumbnails delle opere presenti nella collezione attraverso un parsing dalla <a href="http://www.culturaitalia.it/opencms/opencms/system/modules/com.culturaitalia_stage.liberologico/templates/museid/MetadataExport?id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445" target="_blank">versione XML (vocabolario PICO)</a> delle schede contenute nel portale Museid.</p>
<p>Inoltre il plugin supporta <a target="blank" href="http://buddypress.org">Buddypress</a>, abilitando nuove funzionalità nel plugin di social network di Wordpress.</p>

Funzionalità
================

<p>Il plugin funziona attraverso lo shortcode <strong>[collezione]</strong>, che carica un pulsante (tasto "Esplora") per caricare i dati da MuseiD</p>
<p>La variabile <strong>link</strong> contiene il riferimento alla collezione museale da visualizzare. </p>
<p>Su Museid, ad ogni collezione museale presente corrisponde un identificatore univoco: ad esempio la <a href="http://www.culturaitalia.it/opencms/opencms/system/modules/com.culturaitalia_stage.liberologico/templates/museid/viewItem.jsp?language=it&id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445">"Collezione Pansa"</a>, custodita nel Museo archeologico nazionale di Villa Frigerj,
è identificata con la stringa <b>coll-445</b>. All'interno delle schede di MuseiD, l'identificatore della collezione è individuabile nella descrizione della scheda, nei breadcrumbs e nell'url della pagina.</p>
<p>Il file xml dell'opendata di riferimento è<br />
<a target="blank" href="http://www.culturaitalia.it/opencms/museid/MetadataExport?id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445">http://www.culturaitalia.it/opencms/museid/MetadataExport?id=oai%3Aculturaitalia.it%3Amuseiditalia-coll_445</a>.</p>
<p>Per caricare solo le fotografie delle opere conservate nella collezione, basta insererire il codice della collezione preceduto dalla stringa <i>oai%3Aculturaitalia.it%3Amuseiditalia-</i></p>
<p>Esempio:<br />
<strong>[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_295"]</strong><br />
Esempio su post: <a target="blank" href="http://wp-museid.riqua.eu/museo-nazionale-preistorico-etnografico-luigi-pigorini/">link</a> (cliccare sul tasto verde per visualizzare la collezione)</p>
<br /><br />
<p>Spesso le opere conservate non rappresentano l'intera collezione, ma solo una parte, una raccolta, un piano, una sezione. Per rendere possibile una più accurata presentazione delle opere custodite, è possibile aggiungere del testo all'interno del pulsante attraverso la variabile <strong>esplora</strong>.</p>
<p>Esempio:<br />
<strong>[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_295" esplora="la sezione 'dal villaggio alla città'"]</strong><br />
Esempio su post: <a target="blank" href="http://wp-museid.riqua.eu/museo-pigorini-tasto-modificato/">link</a> (cliccare sul tasto verde per visualizzare la collezione)</p>
<br /><br />
<p>Oltre alle foto, è possibile caricare alcuni metadati (autore, datazione, descrizione, etc) delle opere, impostando la variabile <strong>click="info"</strong></p>
<p>Esempio:<br />
<strong>[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_177" esplora="le opere esposte" click="info"]</strong><br />
Esempio su post: <a target="blank" href="http://wp-museid.riqua.eu/galleria-nazionale-dellumbria/">link</a> (cliccare sul tasto verde per visualizzare la collezione)</p>
<br /><br />
<p>Le foto contenute su MuseiD sono spesso a grande risoluzione, quindi il plugin contiene anche una funzionalità per ingrandire le fotografie: imposta la variabile <strong>click="info"</strong></p>
<p>Esempio:<br />
<strong>[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_522" click="zoom" esplora="parte della collezione"]</strong><br />
Esempio su post: <a target="blank" href="http://wp-museid.riqua.eu/museo-di-san-marco/">link</a> (cliccare sul tasto verde per visualizzare la collezione)</p>
<br /><br />
<p>Come già mostrato, il plugin può contenere più di una collezione per stanza. Tuttavia, all'attuale versione del plugin (0.2) è necessario impostare la variabile <strong>tipo="secondario"</strong> per ogni shortcode oltre al primo presente nella stessa pagina.</p>
<p>Esempio:<br />
<strong>
[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_451" tipo="secondario" esplora="il parco"]</strong><br />
<strong>
[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_319" tipo="secondario" esplora="la Pinacoteca"]</strong><br />
<strong>
[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_320" tipo="secondario" esplora="la Quadreria"]</strong><br />
<strong>
[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_322" esplora="la sezione Terrae Motus"]</strong> questo è lo shortcode che carica le librerie ajax <br />
<strong>
[collezione link="oai%3Aculturaitalia.it%3Amuseiditalia-coll_316" tipo="secondario" esplora="gli appartamenti ottocenteschi"]</strong><br />
Esempio su post: <a target="blank" href="http://cult.riqua.eu/reggia-di-caserta/">link</a> (cliccare sul tasto verde per visualizzare la collezione)</p>
<br /><br />

<p>Infine, il plugin è dotato di funzionalità per <strong>Buddypress</strong>: se Buddypress è attivo, su ogni opera visualizzata comparirà un pulsante attraverso cui segnalare l'opera nello stream delle attività di Buddypress (bp-activity).</p>
<p>Esempi:<br />
https://github.com/Riqua/museid-wordpress/blob/master/buddypress-screenshot.PNG <br />
http://cult.riqua.eu/tracce ad esempio con le attività di http://cult.riqua.eu/membri/stefanocolarelli1/activity <br />

Showcases
================

<ul>
<li>http://cult.riqua.eu/</li>
</ul>
