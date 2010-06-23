<?php
/**
*
* @package Precise Similar Topics II
* @version $Id: functions_similar_topics.php, 15 6/22/10 8:46 PM VSE $
* @copyright (c) Matt Friedman, Tobias Schäfer, Xabi
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Get similar topics based on matching topic titles
* Note: currently requires MySQL due to use of MATCH and AGAINST and UNIX_TIMESTAMP
* 
* @param array 	$topic_data		The current topic data for use in searching
* @param int 	$forum_id		The current forum to check
*/
function similar_topics(&$topic_data, $forum_id)
{
	global $auth, $config, $user, $db, $template, $phpbb_root_path, $phpEx;

	// Bail out if not using required MySQL to prevent any problems
	if ($db->sql_layer != 'mysql4' && $db->sql_layer != 'mysqli')
	{
		return;
	}

	// Bail out if the current forum is set to DO NOT DISPLAY similar topics
	if (!empty($config['similar_topics_hide']))
	{
		if (in_array($forum_id, explode(',', $config['similar_topics_hide'])))
		{
			return;
		}
	}

	// Use phpBB's stop-words if non-English language is detected
	$topic_title = ($user->lang_name != 'en' && $user->lang_name != 'en_us') ? filter_stop_words($topic_data['topic_title']) : $topic_data['topic_title'];

	// If similar topics is enabled and the number of topics to show is <> 0, proceed...
	if ($config['similar_topics'] && $config['similar_topics_limit'])
	{
		$sql_array = array(
			'SELECT'	=> 'f.forum_id, f.forum_name, 
				t.topic_id, t.topic_title, t.topic_time, t.topic_views, t.topic_replies, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, 
				MATCH (t.topic_title) AGAINST (\'' . $db->sql_escape($topic_title) . '\') as score',
		
			'FROM'		=> array(
				TOPICS_TABLE	=> 't',
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
					'ON'	=> 'f.forum_id = t.forum_id'
				)
			),

			'WHERE'		=> "MATCH (t.topic_title) AGAINST ('" . $db->sql_escape($topic_title) . "') >= 0.5
				AND t.topic_status <> " . ITEM_MOVED . '
				AND t.topic_time > (UNIX_TIMESTAMP() - ' . $config['similar_topics_time'] . ')
				AND t.topic_id <> ' . (int) $topic_data['topic_id'],

//			'GROUP_BY'	=> 't.topic_id',

//			'ORDER_BY'	=> 'score DESC',
		);

		// Now lets see if the current forum is set to search a specific forum search group, and search only those forums
		if (!empty($topic_data['similar_topic_forums']))
		{
			$sql_array['WHERE'] .= ' AND f.forum_id IN (' . $topic_data['similar_topic_forums'] . ')';
		}
		// Otherwise, lets see what forums are not allowed to be searched, and ignore those
		else if (!empty($config['similar_topics_ignore']))
		{
			$sql_array['WHERE'] .= ' AND f.forum_id NOT IN (' . $config['similar_topics_ignore'] . ')';
		}

		$sql = $db->sql_build_query('SELECT', $sql_array);
		$result = $db->sql_query_limit($sql, $config['similar_topics_limit'], 0, $config['similar_topics_cache']);

		while ($similar = $db->sql_fetchrow($result))
		{
			if ($auth->acl_get('f_read', $similar['forum_id']))
			{
				$template->assign_block_vars('similar', array(
					'TOPIC_TITLE'		=> $similar['topic_title'],
					'TOPIC_VIEWS'		=> $similar['topic_views'],
					'TOPIC_REPLIES'		=> $similar['topic_replies'],
					'TOPIC_TIME'		=> $user->format_date($similar['topic_time']),
					'TOPIC_AUTHOR_FULL'	=> get_username_string('full', $similar['topic_poster'], $similar['topic_first_poster_name'], $similar['topic_first_poster_colour']),
					'U_TOPIC'			=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f=" . $similar['forum_id'] . '&amp;t=' . $similar['topic_id']),
					'U_FORUM'			=> append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=" . $similar['forum_id']),
					'FORUM'				=> $similar['forum_name'])
				);
			}
		}
		$db->sql_freeresult($result);
	}
}

/**
* MySQL full-text has built-in English stop words. Use phpBB's stop words for non-english languages
* This will remove uppercases, handle utf8 characters, and ignore words of 2 characters or less
* Based on a function by phpbb-seo.com
* 
* @param  string $text			The topic title
* @return string $text			The topic titled with any stop-words removed
*/
function filter_stop_words($text)
{
	$word_list = array();
	$text = trim(preg_replace('/[ \t]+/', ' ', $text)); // strip extra whitespaces or tabs
	if (!empty($text))
	{
		// Put all unique words in the title into an array, and remove uppercases
		$word_list = array_unique(explode(' ', utf8_strtolower($text)));
		foreach ($word_list as $key => $word)
		{
			// Lets eliminate all words of 2 characters or less
			if (utf8_strlen(trim($word)) < 3)
			{
				unset($word_list[$key]);
			}
		}
	}

	// Remove any stop words from our array
	if (!empty($word_list))
	{
		global $phpbb_root_path, $user, $phpEx;

		$words = array();	// $words is our array of stop_words
		if (file_exists("{$user->lang_path}{$user->lang_name}/search_ignore_words.$phpEx"))
		{
			// include the file containing ignore words
			include("{$user->lang_path}{$user->lang_name}/search_ignore_words.$phpEx");
		}
		$word_list = array_diff($word_list, $words);
	}

	// Rebuild our cleaned up topic title
	$text = !empty($word_list) ? implode(' ', $word_list) : '';
	return $text;
}

?>