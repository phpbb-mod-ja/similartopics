<?php
/**
*
* info_acp_similiar_topics [Dutch]
* 
* @package Precise Similar Topics II
* @version $Id$
* @copyright (c) 2010 Matt Friedman
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'PST_TITLE_ACP'		=> 'Vergelijkbare Onderwerpen',
	'PST_TITLE'			=> 'Precieze vergelijkbare onderwerpen II',
	'PST_LEGEND1'		=> 'Algemene Instellingen',
	'PST_ENABLE'		=> 'Vergelijkbare onderwerpen inschakelen',
	'PST_LEGEND2'		=> 'Laad Instellingen',
	'PST_LIMIT'			=> 'Aantal vergelijkbare onderwerpen weer te geven',
	'PST_LIMIT_EXPLAIN'	=> 'Hier kunt u opgeven hoeveel soortgelijke onderwerpen weer te laten geven. Standaard is dit 5 onderwerpen.',
	'PST_TIME'			=> 'Zoek periode',
	'PST_TIME_EXPLAIN'	=> 'Met deze optie kunt u de zoek periode van vergelijkbare onderwerpen configureren. Bijvoorbeeld, indien ingesteld op "5 dagen" het systeem zal dan alleen soortgelijke onderwerpen van de laatste 5 dagen laten zien. De standaardwaarde is 1 jaar.',	
	'PST_YEARS'			=> 'Jaren',
	'PST_MONTHS'		=> 'Maanden',
	'PST_WEEKS'			=> 'Weken',
	'PST_DAYS'			=> 'Dagen',
	'PST_CACHE'			=> 'Cache lengte vergelijkbare onderwerpen',
	'PST_CACHE_EXPLAIN'	=> 'Cache vergelijkbare onderwerpen verloopt na deze tijd in seconden. Stel in op 0 als u dit wilt uitschakelen.',
	'PST_LEGEND3'		=> 'Foruminstellingen',
	'PST_NOSHOW_LIST'	=> 'Niet weergeven in',
	'PST_NOSHOW_TITLE'	=> 'Vergelijkbare Onderwerpen Niet weergeven in',
	'PST_IGNORE_SEARCH'	=> 'Niet zoeken In',
	'PST_IGNORE_TITLE'	=> 'Niet zoeken naar vergelijkbare onderwerpen in',
	'PST_ADVANCED'		=> 'Geavanceerd',
	'PST_ADVANCED_TITLE'=> 'Klik om Geavanceerde vergelijkbare onderwerpen in te stellen voor',
	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br /><br />Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.',
	'PST_DESELECT_ALL'	=> 'Selectie opheffen',
	'PST_LEGEND4'		=> 'Optionele instellingen',
	'PST_WORDS'			=> 'Speciale woorden om te negeren',
	'PST_WORDS_EXPLAIN'	=> 'Voeg Speciale woorden toe welke uniek zijn aan uw forum dat moet worden genegeerd bij het vinden van vergelijkbare onderwerpen. (Note: Woorden die momenteel worden beschouwd als gemeenschappelijk in uw taal worden reeds standaard genegeerd.) Scheid elk woord met een spatie. Hoofdlettergevoelig. Max. 255 karakters.',
	'PST_SAVED'			=> 'Vergelijkbare onderwerpen instellingen bijgewerkt',
	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br />“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
	'PST_WARNING'		=> 'Vergelijkbare onderwerpen zal niet werken op uw forum. Vergelijkbare onderwerpen vereist een MySQL 4 of 5 MySQL database.',
	'PST_LOG_MSG'		=> '<strong>Vergelijkbare onderwerp instellingen gewijzigd</strong>',

	//For UMIL Installer
	'PST_FULLTEXT_ADD'	=> 'FULLTEXT index toevoegen: topic_title',
	'PST_FULLTEXT_DROP'	=> 'FULLTEXT index verwijderen: topic_title',
	'PST_FULLTEXT_PASS'	=> 'Uw database is compatibel met deze MOD. Geniet ervan :-)',
	'PST_FULLTEXT_FAIL'	=> '<span class="error"><strong>WAARSCHUWING:</strong> U moet deze MOD niet installeren! Aangezien uw database geen FULLTEXT indexes ondersteunt . Dit betekent meestal dat uw topic tabel niet de MyISAM opslag engine gebruikt welke vereist is voor deze MOD om te werken. <a href="http://www.phpbb.com/customise/db/mod/precise_similar_topics_ii/faq/f_737">Meer Informatie</a>.</span>',
	'PST_DATABASE_FAIL'	=> '<span class="error"><strong>WAARSCHUWING:</strong> U moet deze MOD niet installeren! Uw database is niet MySQL zoals vereist door deze MOD.</span>',
));

// For permissions
$lang = array_merge($lang, array(
	'acl_u_similar_topics'	=> array('lang' => 'Kan vergelijkbare onderwerpen bekijken', 'cat' => 'misc'),
));

?>