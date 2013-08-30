<?php 
	
	error_reporting(-1);
	
	$system_path = 'system';
	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}
	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));
	
	
	include('application/config/db_custom.php');
	global $config;
	
    function get_db_connection($config)
    {
        global $g_link;
        if( $g_link )
            return $g_link;
        $g_link = mysql_connect( $config['hostname'], $config['username'], $config['password']) or die('Could not connect to mysql server.' );
        mysql_select_db($config['database'], $g_link) or die('Could not select database.');
        return $g_link;
    }

    function clean_up_db()
    {
        global $g_link;
        if( $g_link != false )
            mysql_close($g_link);
        $g_link = false;
    }
	
	function filter_input_to_mysql($char)
	{
		return mysql_real_escape_string(trim(htmlspecialchars($char)));
	}
	
	// all table having link image source
	function get_posted_table_name($table_name, $field_name)
	{
		
		$query = sprintf("SELECT %s FROM `%s`",
		filter_input_to_mysql($field_name),
		filter_input_to_mysql($table_name));
		
		// Perform Query
		$result = mysql_query($query);
		
		return $result;
	}
	
	function get_list_tables() {
		
		// index => table name, value field name
		return array('events'=>'event_link_image',
					'accessories'=>'acc_link_image',
					'banners'=>'banner_link_image',
					'partners'=>'partner_link_image',
					'parts'=>'part_link_image',
					'products'=>'product_image_link',
					'rearbody'=>'rear_link_image',
					'product_cate'=>'pc_image_link_sub|pc_image_link|pc_image_link_extra',
					'product_cate_gallery'=>'created_folder|full_url_path',
					'product_gallery'=>'created_folder|full_path_image',
					'media'=>'main_url|thumb_url');
		
	}
	
	function update_new_value($table_name, $field_name, $newvalue) {
		
		$sql = "";
		if(strstr($field_name, ",")) {
			$field_name = explode(',',$field_name);
			$sql = "UPDATE `".filter_input_to_mysql($table_name)."` SET ";
			foreach($field_name as $e_field_name) {
				$sql .= "`".filter_input_to_mysql($e_field_name)."`='".filter_input_to_mysql($newvalue)."',";
			}
			$sql = substr($sql, 0, -1); // remove last comma
		} else {
			$sql = sprintf("UPDATE `%s` SET `%s`='%s'",
			filter_input_to_mysql($table_name),
			filter_input_to_mysql($field_name),
			filter_input_to_mysql($newvalue));
		}
		
		$result = mysql_query($sql);
		if(!$result) {
			echo 'An error has occured!SQL error: '.mysql_error();
			exit();
		}
		
	}
	
	function process_change_new_value_location($tablename, $query_result, $field_name, $old_location, $new_location)
	{
		if (!$query_result) {
			die('Invalid query: ' . mysql_error());
		}
		else {
			$newvalue = "";
			while ($row = mysql_fetch_assoc($query_result)) {
				if(strstr($field_name, ',')) {
					$temp_field_name = explode(',', $field_name);
					foreach($temp_field_name as $e_field_name) {
						$newvalue = str_replace($old_location, $new_location, $row[$e_field_name]);
					}
					unset($temp_field_name);
				} else $newvalue = str_replace($old_location, $new_location, $row[$field_name]);
				// update process
				
				update_new_value($tablename, $field_name, $newvalue);
			}
		}
		
		clean_result($query_result);
	}
	
	function clean_result($result)
	{
		// Free the resources associated with the result set
		// This is done automatically at the end of the script
		mysql_free_result($result);
	}
	
	get_db_connection($config);// open connection
	
	// public var
	$list_table = get_list_tables(); // list of table
?>


<form action="update_source.php" name="form_update_source" id="form_update_source" method="post">
	
	<legend>Select New Location</legend>
	
	<fieldset>
	<!-- list of table -->
	<p><label>List of changing-tables</label><br />
	<select name="table-changing[]" id="table-changing" multiple style="width:300px;height:100px;">
		<?php foreach($list_table as $table=>$field) {?>
		<option value="<?php echo $table.'@@'.$field;?>"><?php echo $table;?></option>
		<?php }?>
	</select>
	</p>
	
	<p><label>Current Source Location</label>
	<input type="textbox" name="oldfolder" id="oldfolder" value="/demo" />
	</p>
	<p><label>New Source Location</label>
	<input type="textbox" name="newfolder" id="newfolder" value="" />
	</p>
	<p>
	<input type="submit" name="submit" id="submit" value="Change" />
	</p>
	</fieldset>
</form>

<?php 

if(isset($_POST['submit'])) {
		
		$which_table_change = $_POST['table-changing'];
		$old_location = trim(htmlspecialchars($_POST['oldfolder']));
		$new_location = trim(htmlspecialchars($_POST['newfolder']));
		
		$query = false;
		$which_table = '';
		$field_name = '';
		foreach($which_table_change as $table_field_name) {
			
			if(strstr($table_field_name, '@@')) {
				$table_field_name = explode('@@', $table_field_name);
				$which_table = $table_field_name[0];
				$field_name = $table_field_name[1];
			}
			
			if($which_table!='' && $field_name!='') {
				if(strstr($field_name, '|')) {
					$field_name = explode('|', $field_name);
					$field_name = implode(',',$field_name);
				}
				
				
				$query = get_posted_table_name($which_table, $field_name);
				if($query) {
					process_change_new_value_location($which_table, $query, $field_name, $old_location, $new_location);
				}
			}
			
			
		}
		
		echo '<script type="text/javascript">alert("Update successful!"); window.location='.$_SERVER['HTTP_REFERER'].'</script>';
}
	
clean_up_db(); // end connection?>