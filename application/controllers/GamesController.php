<?php
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class GamesController extends Zend_Controller_Action
{

var $itoa64;
	var $iteration_count_log2;
	var $portable_hashes;
	var $random_state;

  public function indexAction()
  {
   
   
$registry = Zend_Registry::getInstance();  
$DB = $registry['DB'];

$sql = "SELECT gameid, logo, gamename FROM games";
$games = $DB->fetchAll($sql);



$this->view->assign('datas',$games);
  }
  
   public function addAction()
  {
  
 
  
}

public function insertAction()
{

$registry = Zend_Registry::getInstance();  
$DB = $registry['DB'];

$DB->beginTransaction();
try{
$request = $this->getRequest();
	
$sql = "INSERT INTO `u1stxen`.`xf_user` (`user_id`, `username`, `email`, `gender`, `custom_title`, `language_id`, `style_id`, `timezone`, `visible`, `user_group_id`, `secondary_group_ids`, `display_style_group_id`, `permission_combination_id`, `message_count`, `conversations_unread`, `register_date`, `last_activity`, `trophy_points`, `alerts_unread`, `avatar_date`, `avatar_width`, `avatar_height`, `gravatar`, `user_state`, `is_moderator`, `is_admin`, `is_banned`, `like_count`, `warning_points`, `is_staff`) VALUES (NULL, '".$request->getParam('username')."', '".$request->getParam('email')."', '', '', '1', '0', '".$request->getParam('timezone')."', '1', '2', '', '2', '2', '0', '0', '1409326611', '1409329397', '0', '0', '0', '0', '0', '', 'valid', '0', '0', '0', '0', '0', '0')";

$DB->query($sql);

$id = $DB->lastInsertId();

$sql = "INSERT INTO `u1stxen`.`xf_user_group_relation` (`user_id`, `user_group_id`, `is_primary`) VALUES ('".$id."', '2', '1')";

$DB->query($sql);

$sql = "INSERT INTO `u1stxen`.`xf_user_option` (`user_id`, `show_dob_year`, `show_dob_date`, `content_show_signature`, `receive_admin_email`, `email_on_conversation`, `is_discouraged`, `default_watch_state`, `alert_optout`, `enable_rte`, `enable_flash_uploader`) VALUES ('".$id."', '1', '1', '1', '1', '1', '0', 'watch_email', '', '1', '1')";

$DB->query($sql);

$sql = "INSERT INTO `u1stxen`.`xf_user_privacy` (`user_id`, `allow_view_profile`, `allow_post_profile`, `allow_send_personal_conversation`, `allow_view_identities`, `allow_receive_news_feed`) VALUES ('".$id."', 'everyone', 'members', 'members', 'everyone', 'everyone')";

$DB->query($sql);

$sql = "INSERT INTO `u1stxen`.`xf_user_profile` (`user_id`, `dob_day`, `dob_month`, `dob_year`, `status`, `status_date`, `status_profile_post_id`, `signature`, `homepage`, `location`, `occupation`, `following`, `ignored`, `csrf_token`, `avatar_crop_x`, `avatar_crop_y`, `about`) VALUES ('".$id."', '".$request->getParam('dob_day')."', '".$request->getParam('dob_month')."', '".$request->getParam('dob_year')."', '', '0', '0', '', '', '', '', '', '', 'u_tZqx1W56MuL5scl3YWdja47zWsQBO3HG4m_NnE', '0', '0', '')";

$DB->query($sql);

/**
$this->construct(10, false);
$output = $this->HashPassword("Ta@9045618909");
$output = serialize($output);
echo "output ". $output;
echo "result ". $this->CheckPassword("Ta@9045618909", $output);
echo "deserialize ". unserialize($output);
*/

$sql = "SELECT data FROM xf_user_authenticate where user_id = 2";
$auth = $DB->fetchRow($sql);
$data = $auth->data;

$sql = "INSERT INTO `u1stxen`.`xf_user_authenticate` (`user_id`, `scheme_class`, `data`, `remember_key`) VALUES ('".$id."', 'XenForo_Authentication_Core12','".$data."','zFcOWQUnvJp3fiGtLoABlyf7fAvhN_3xSaENmlXx')";

$DB->query($sql);

$sql = "SELECT gamename, description FROM games where gamename ='".$request->getParam('username')."'";
$games = $DB->fetchRow($sql);

$sql = "SELECT rgt,lft FROM xf_node ORDER BY node_id DESC LIMIT 1";
$node = $DB->fetchRow($sql);
$lft = $node->rgt + 1;
$rgt = $lft + 1;
echo $games->gamename;
echo $games->description;
$sql = "INSERT INTO `u1stxen`.`xf_node` (`title`, `description`, `node_name`, `node_type_id`, `parent_node_id`, `display_order`, `display_in_list`, `lft`, `rgt`, `depth`, `style_id`, `effective_style_id`, `breadcrumb_data`) VALUES ('".$games->gamename."', '".$games->description."', NULL, 'Forum', '7', '1', '1', '".$lft."', '".$rgt."', '1', '0', '2', 0x613a313a7b693a373b613a373a7b733a373a226e6f64655f6964223b693a373b733a393a226e6f64655f6e616d65223b4e3b733a31323a226e6f64655f747970655f6964223b733a383a2243617465676f7279223b733a353a227469746c65223b733a31333a22546573742043617465676f7279223b733a353a226465707468223b693a303b733a333a226c6674223b693a353b733a333a22726774223b693a32343b7d7d);";

$DB->query($sql);
$nodeid = $DB->lastInsertId();

$sql = "INSERT INTO `u1stxen`.`xf_forum` (`node_id`, `discussion_count`, `message_count`, `last_post_id`, `last_post_date`, `last_post_user_id`, `last_post_username`, `last_thread_title`, `moderate_messages`, `allow_posting`, `count_messages`, `find_new`, `default_prefix_id`, `default_sort_order`, `default_sort_direction`, `require_prefix`, `allowed_watch_notifications`) VALUES ('".$nodeid."', '0', '0', '0', '0', '0', '', '', '0', '1', '1', '1', '0', 'last_post_date', 'desc', '0', 'all');";

$DB->query($sql);

$sql = "SELECT permission_combination_id as id FROM xf_permission_combination";
$permission_combination = $DB->fetchAll($sql);

for($i = 0; $i<= count($permission_combination)-1;$i++)
{
$sql = "INSERT INTO `u1stxen`.`xf_permission_cache_content` (`permission_combination_id`, `content_type`, `content_id`, `cache_value`) VALUES ('".$permission_combination[$i]->id."', 'node', '".$nodeid."', 0x613a32373a7b733a31383a22737469636b556e737469636b546872656164223b623a303b733a31303a22766965774f7468657273223b623a313b733a31353a226d616e616765416e79546872656164223b623a303b733a31313a2276696577436f6e74656e74223b623a313b733a343a226c696b65223b623a313b733a31303a22706f7374546872656164223b623a313b733a393a22706f73745265706c79223b623a313b733a31353a2264656c6574654f776e546872656164223b623a303b733a31313a22656469744f776e506f7374223b623a313b733a31333a2264656c6574654f776e506f7374223b623a313b733a32303a22656469744f776e506f737454696d654c696d6974223b693a2d313b733a31383a22656469744f776e5468726561645469746c65223b623a313b733a31343a22766965774174746163686d656e74223b623a313b733a31363a2275706c6f61644174746163686d656e74223b623a313b733a383a22766f7465506f6c6c223b623a313b733a31373a226861726444656c657465416e79506f7374223b623a303b733a31363a22617070726f7665556e617070726f7665223b623a303b733a31363a226c6f636b556e6c6f636b546872656164223b623a303b733a31333a2264656c657465416e79506f7374223b623a303b733a31353a2264656c657465416e79546872656164223b623a303b733a31333a22766965774d6f64657261746564223b623a303b733a31313a2265646974416e79506f7374223b623a303b733a31393a226861726444656c657465416e79546872656164223b623a303b733a31313a227669657744656c65746564223b623a303b733a383a22756e64656c657465223b623a303b733a343a227761726e223b623a303b733a343a2276696577223b623a313b7d);";

$DB->query($sql);
}




$DB->commit();
} catch (Exception $e) {

    $DB->rollBack();
	echo $e->getMessage();
}

}
 
 public function construct($iteration_count_log2, $portable_hashes)
	{
		$this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
			$iteration_count_log2 = 8;
		$this->iteration_count_log2 = $iteration_count_log2;

		$this->portable_hashes = $portable_hashes;

		$this->random_state = microtime();
		if (function_exists('getmypid'))
			$this->random_state .= getmypid();
	}

	function get_random_bytes($count)
	{
		$output = '';

		if (function_exists('openssl_random_pseudo_bytes')
			&& (substr(PHP_OS, 0, 3) != 'WIN' || version_compare(phpversion(), '5.3.4', '>='))
		)
		{
			$output = openssl_random_pseudo_bytes($count);
		}
		else if (function_exists('mcrypt_create_iv') && version_compare(phpversion(), '5.3.0', '>='))
		{
			$output = mcrypt_create_iv($count, MCRYPT_DEV_URANDOM);
		}
		else if (@is_readable('/dev/urandom') &&
		    ($fh = @fopen('/dev/urandom', 'rb'))) {
			$output = fread($fh, $count);
			fclose($fh);
		}

		if (strlen($output) < $count) {
			$output = '';
			for ($i = 0; $i < $count; $i += 16) {
				$this->random_state =
				    md5(microtime() . $this->random_state);
				$output .=
				    pack('H*', md5($this->random_state));
			}
			$output = substr($output, 0, $count);
		}

		return $output;
	}

	function encode64($input, $count)
	{
		$output = '';
		$i = 0;
		do {
			$value = ord($input[$i++]);
			$output .= $this->itoa64[$value & 0x3f];
			if ($i < $count)
				$value |= ord($input[$i]) << 8;
			$output .= $this->itoa64[($value >> 6) & 0x3f];
			if ($i++ >= $count)
				break;
			if ($i < $count)
				$value |= ord($input[$i]) << 16;
			$output .= $this->itoa64[($value >> 12) & 0x3f];
			if ($i++ >= $count)
				break;
			$output .= $this->itoa64[($value >> 18) & 0x3f];
		} while ($i < $count);

		return $output;
	}

	protected function gensalt_private($input)
	{
		$output = '$P$';
		$output .= $this->itoa64[min($this->iteration_count_log2 +
			((PHP_VERSION >= '5') ? 5 : 3), 30)];
		$output .= $this->encode64($input, 6);

		return $output;
	}

	protected function crypt_private($password, $setting)
	{
		$output = '*0';
		if (substr($setting, 0, 2) == $output)
			$output = '*1';

		$id = substr($setting, 0, 3);
		# We use "$P$", phpBB3 uses "$H$" for the same thing
		if ($id != '$P$' && $id != '$H$')
			return $output;

		$count_log2 = strpos($this->itoa64, $setting[3]);
		if ($count_log2 < 7 || $count_log2 > 30)
			return $output;

		$count = 1 << $count_log2;

		$salt = substr($setting, 4, 8);
		if (strlen($salt) != 8)
			return $output;

		# We're kind of forced to use MD5 here since it's the only
		# cryptographic primitive available in all versions of PHP
		# currently in use.  To implement our own low-level crypto
		# in PHP would result in much worse performance and
		# consequently in lower iteration counts and hashes that are
		# quicker to crack (by non-PHP code).
		if (PHP_VERSION >= '5') {
			$hash = md5($salt . $password, TRUE);
			do {
				$hash = md5($hash . $password, TRUE);
			} while (--$count);
		} else {
			$hash = pack('H*', md5($salt . $password));
			do {
				$hash = pack('H*', md5($hash . $password));
			} while (--$count);
		}

		$output = substr($setting, 0, 12);
		$output .= $this->encode64($hash, 16);

		return $output;
	}

	function gensalt_extended($input)
	{
		$count_log2 = min($this->iteration_count_log2 + 8, 24);
		# This should be odd to not reveal weak DES keys, and the
		# maximum valid value is (2**24 - 1) which is odd anyway.
		$count = (1 << $count_log2) - 1;

		$output = '_';
		$output .= $this->itoa64[$count & 0x3f];
		$output .= $this->itoa64[($count >> 6) & 0x3f];
		$output .= $this->itoa64[($count >> 12) & 0x3f];
		$output .= $this->itoa64[($count >> 18) & 0x3f];

		$output .= $this->encode64($input, 3);

		return $output;
	}

	function gensalt_blowfish($input)
	{
		# This one needs to use a different order of characters and a
		# different encoding scheme from the one in encode64() above.
		# We care because the last character in our encoded string will
		# only represent 2 bits.  While two known implementations of
		# bcrypt will happily accept and correct a salt string which
		# has the 4 unused bits set to non-zero, we do not want to take
		# chances and we also do not want to waste an additional byte
		# of entropy.
		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$output = '$2a$';
		$output .= chr(ord('0') + $this->iteration_count_log2 / 10);
		$output .= chr(ord('0') + $this->iteration_count_log2 % 10);
		$output .= '$';

		$i = 0;
		do {
			$c1 = ord($input[$i++]);
			$output .= $itoa64[$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16) {
				$output .= $itoa64[$c1];
				break;
			}

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 4;
			$output .= $itoa64[$c1];
			$c1 = ($c2 & 0x0f) << 2;

			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 6;
			$output .= $itoa64[$c1];
			$output .= $itoa64[$c2 & 0x3f];
		} while (1);

		return $output;
	}

	function HashPassword($password)
	{
		$random = '';

		if (CRYPT_BLOWFISH == 1 && !$this->portable_hashes) {
			$random = $this->get_random_bytes(16);
			$hash =
			    crypt($password, $this->gensalt_blowfish($random));
			if (strlen($hash) == 60)
				return $hash;
		}

		if (CRYPT_EXT_DES == 1 && !$this->portable_hashes) {
			if (strlen($random) < 3)
				$random = $this->get_random_bytes(3);
			$hash =
			    crypt($password, $this->gensalt_extended($random));
			if (strlen($hash) == 20)
				return $hash;
		}

		if (strlen($random) < 6)
			$random = $this->get_random_bytes(6);
		$hash =
		    $this->crypt_private($password,
		    $this->gensalt_private($random));
		if (strlen($hash) == 34)
			return $hash;

		# Returning '*' on error is safe here, but would _not_ be safe
		# in a crypt(3)-like function used _both_ for generating new
		# hashes and for validating passwords against existing hashes.
		return '*';
	}

	function CheckPassword($password, $stored_hash)
	{
	
		$hash = $this->crypt_private($password, $stored_hash);
		if ($hash[0] == '*')
			$hash = crypt($password, $stored_hash);
		return $hash == $stored_hash;
	}

	public function reverseItoA64($char)
	{
		return strpos($this->itoa64, $char);
	}
  
}
?>