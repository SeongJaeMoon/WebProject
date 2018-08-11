<?php
Class DBConnect
{
	public $db;
	public $wp_prefix			= "";
	public $field_types	= array();

	public function __construct($db=NULL){	
		if(!empty($db)){
			$this->db				= $db;
			$this->wp_prefix		= $db->prefix;
		}		
	}

	public function query($query){
		return $this->db->query($query);
	}

	public function get_row( $query = null, $output = "OBJECT", $y = 0 ) {
		return $this->db->get_row($query,$output,$y);
	}
	public function get_var($query){
		return $this->db->get_var($query);
	}
	public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		// This is not meant to be foolproof -- but it will catch obviously incorrect usage.
		if ( strpos( $query, '%' ) === false ) {
			return $query;
		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
	}
	function _real_escape( $string ) {
		if ( $this->db->dbh ) {
			if ( $this->db->use_mysqli ) {
				return mysqli_real_escape_string( $this->db->dbh, $string );
			} else {
				return mysql_real_escape_string( $string, $this->db->dbh );
			}
		}

		$class = get_class( $this );
		//_doing_it_wrong( $class, "$class must set a database connection for use with escaping.", E_USER_NOTICE );
		return addslashes( $string );
	}

	/**
	 * Escape data. Works on arrays.
	 *
	 * @uses wpdb::_real_escape()
	 * @since  2.8.0
	 * @access private
	 *
	 * @param  string|array $data
	 * @return string|array escaped
	 */
	function _escape( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $k => $v ) {
				if ( is_array($v) )
					$data[$k] = $this->_escape( $v );
				else
					$data[$k] = $this->_real_escape( $v );
			}
		} else {
			$data = $this->_real_escape( $data );
		}

		return $data;
	}

	function escape_by_ref( &$string ) {
		if ( ! is_float( $string ) )
			$string = $this->_real_escape( $string );
	}

	function get_distinct_values($table,$field,$wData=null){
		 $where_query		= "";

		if(!empty($wData)){			
			$add_data		= array();
			$index			= 0;
			$count			= count($wData)-1;
			
			foreach ( $wData  as $data ) {
				if(empty($data["prefix"])) $data["prefix"]	= "";
				if(empty($data["suffix"])) $data["suffix"]	= "";
				if(empty($data["sign"])) $data["sign"]		= "=";
				if(empty($data["operator"])) $data["operator"]		= "AND";

				if(!empty($data["field"]) && isset($data["value"])){
					$w_query		= $data["prefix"].$data["field"]." ".$data["sign"]." '".$data["value"]."'".$data["suffix"];
					if($index<$count) $w_query		= $w_query." ".$data["operator"]." ";
					$add_data[]			= $w_query;
				}
				$index++;
			}
			$where_query		= " WHERE ".implode( "", $add_data );
		}


		$values				= $this->get_results("select distinct ".$field." from ".$table.$where_query,ARRAY_A);
		$data					= array();
		foreach($values as $value){
			$data[]		= $value[$field];
		}
		return $data;
	}

	function get_results($query,$output = "OBJECT"){
		return $this->db->get_results($query,$output);
	}

	function db_query($type, $table, $data, $where=null, $format=null, $where_format = null){

		$type		= strtoupper( $type );
		if ( ! in_array( $type , array( 'REPLACE', 'INSERT', 'UPDATE', 'DELETE' ) ) )
			return false;

		if($type=="INSERT"){
			$sql	=  $this->_insert_replace_sql( $table, $data, $format, $type );
			return $this->query( $this->prepare( $sql, $data ) );
		}else if($type=="REPLACE"){
			$sql	=  $this->_insert_replace_sql( $table, $data, $format, $type );
			return $this->query( $this->prepare( $sql, $data ) );
		}else if($type=="UPDATE"){
			return $this->update( $table, $data, $where, $format, $where_format);
		}else if($type=="DELETE"){
			return $this->delete( $table, $where, $where_format);
		}
	}

	function get_query($type, $table, $data, $where=null, $format=null, $where_format = null){

		$type		= strtoupper( $type );
		if ( ! in_array( $type , array( 'REPLACE', 'INSERT', 'UPDATE', 'DELETE' ) ) )
			return false;

		if($type=="INSERT"){
			$sql	=  $this->_insert_replace_sql( $table, $data, $format, $type );
			return $this->prepare( $sql, $data );
		}else if($type=="REPLACE"){
			$sql	=  $this->_insert_replace_sql( $table, $data, $format, $type );
			return $this->prepare( $sql, $data );
		}
	}

	function _insert_replace_sql( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		$sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";

		if(strpos($table, 'logs')===false && MBW_QUERY_LOG)
			mbw_set_log("query",$this->prepare( $sql, $data ),array("mode"=>"db","board_action"=>$type,"board_name"=>$table));

		return $sql;		
	}
	function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}
		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );

		if(MBW_QUERY_LOG) mbw_set_log("query",$this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ), array("mode"=>"db","board_action"=>"UPDATE","board_name"=>$table));


		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}
	function delete( $table, $where, $where_format = null ) {
		if ( ! is_array( $where ) )
			return false;

		$bits = $wheres = array();

		$where_formats = $where_format = (array) $where_format;

		foreach ( array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) ) {
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			} elseif ( isset( $this->field_types[ $field ] ) ) {
				$form = $this->field_types[ $field ];
			} else {
				$form = '%s';
			}

			$wheres[] = "$field = $form";
		}

		$sql = "DELETE FROM $table WHERE " . implode( ' AND ', $wheres );

		if(MBW_QUERY_LOG) mbw_set_log("query",$this->prepare( $sql, $where),array("mode"=>"db","board_action"=>"DELETE","board_name"=>$table));
		return $this->query( $this->prepare( $sql, $where ) );
	}


}

?>