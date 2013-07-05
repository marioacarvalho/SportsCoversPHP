<?php
/**
* CRUD base Model Class
*
* CRUD Generic Database Operations
* 
* @author EAE
* @link crud
*/ 
class Crud extends CI_Model {
	
    const RESULT_LIST = "_ARRAY";
    const RESULT_ROW = "_ROW";

	function __construct()
	{
        parent::__construct();
    }


	/**
	* Generic Simple Insert
	* 
	* @access public
	* @param array $data_array
	* @param string $table	 
	* @return boolean - query result
	*/


	public function create ($table, $data_array)
	{
		
	$sql = $this->db->insert_string($table, $data_array);
	return $this->db->query($sql);
		
	}

    /**
    * Get inserted id from last insert
    * 
    * @access public    
    * @return number
    */


    public function insert_id()
    {
        
    return $this->db->insert_id();
        
    }


	/**
	* Simple Update Generic 
	* 
	* @access public
	* @param array $data_array
	* @param string $table	 
	* @param string $where		
	* @return boolean - query result
	*/
	
	
	public function update ($table, $data_array, $where)
	{
        $this->db->where($where);
        return $this->db->update($table, $data_array); 	
	}
	
	
	/**
	* Simple Delete Generic 
	* 
	* @access public
	* @param string $table	 
	* @param string $field	 
	* @param string $value		
	* @return boolean - query result
	*/
	
	
	public function delete ($table, $where)
	{
	
        $this->db->where($where);
        return $this->db->delete($table);
		
	}	


	/**
	* Simple Retrive by field Generic 
	* 
	* @access public
	* @param string $table	 
	* @param string $what
	* @param string $where	 
	* @param string $type
    * @param string $orderby	
    * @param joint_tables array(array) - Join tables (ex: array(array('joint_table_name', 'table_name.pk = joint_table_name.fk', 'inner|left|right')) )	
	* @return boolean - query result
	*/
    
    public function retrieve ($table, $what ,$where = FALSE, $type="_ROW", $orderby=FALSE, $join_tables = FALSE, $group_by = FALSE, $limit = FALSE, $escape_from_clause = TRUE)
    {
    
        $this->db->select($what, $escape_from_clause)->from($table);

        if(is_array($join_tables)){
            foreach($join_tables as $join_table){
                $this->db->join($join_table[0], $join_table[1],(isset($join_table[2])?$join_table[2]:'inner'));
            } 
        }
        
        if($where !== FALSE){
            $this->db->where($where);
        }

        if($orderby !== FALSE){
            $this->db->order_by($orderby);
        }

        if($group_by !== FALSE){
            $this->db->group_by($group_by);
        }

        if($limit !== FALSE){
            $this->db->limit($limit);
        }

        $query=$this->db->get();
    
        if($type=="_ARRAY")
        {
            return $query->result_array();
        
        } else {
        
            return $query->row_array();
        
        }
         
    
    }

    public function run_query($sql){
        return $this->db->query($sql);
    }
	
	
	
	/**
	* retrives the info from the table $table_name in the 
	* flexigrid format
	* 
	* @access public
	* @param table_name
    * @param fields - Fields to return
    * @param where - Where clause
    * @param joint_tables array(array) - Join tables (ex: array(array('joint_table_name', 'table_name.pk = joint_table_name.fk', 'inner|left|right')) )
	* @return array
	*/

    public function retrieve_flexigrid($table_name,$fields = '*',$where = FALSE, $join_tables = FALSE, $group_by = FALSE)
    {
        
        $this->db->select($fields, FALSE)->from($table_name);

        if(is_array($join_tables)){
            foreach($join_tables as $join_table){
                $this->db->join($join_table[0], $join_table[1],(isset($join_table[2])?$join_table[2]:'inner'));
            } 
        }

    
        if(!empty($where)){
            $this->db->where($where);
        }
      
        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }
        
        $this->flexigrid->build_query();   
        
        $return['records'] = $this->db->get();
       
        $this->db->from($table_name);

        if(is_array($join_tables)){
            foreach($join_tables as $join_table){
                $this->db->join($join_table[0], $join_table[1],(isset($join_table[2])?$join_table[2]:'inner'));
            } 
        }

        if(!empty($where)){
            $this->db->where($where);
        }                             

        if(!empty($group_by)){
            $this->db->select('count(distinct(' . $group_by . ')) as record_count');
        }else{
            $this->db->select('count(1) as record_count');
        }

        $this->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();
        
        //Get Record Count
        $return['record_count'] = $row->record_count;
        
    
        return $return;
    }


    /**
    * gets the max from a specific field 
    * 
    * @access public
    * @param table_name
    * @param $field - Field to get the max position
    * @param where - Where clause
    * @return number
    */

    public function get_max ($table, $field ,$where = FALSE)
    {
    
        $this->db->select_max($field,"max_field")->from($table);

        if($where !== FALSE){
            $this->db->where($where);
        }

        $query = $this->db->get();
        $row = $query->row_array();

        if(empty($row) || empty($row["max_field"])){
            return 0;
        }else{
            return $row["max_field"];
        }

    }
    
    
    
    /**
    * Checks if a record exists or not
    * 
    * @access public
    * @param table_name
    * @param where - Where clause
    * @return boolean
    */
    
    
    public function record_exists($table, $where = FALSE){
        
       $this->db->from($table);

        if($where !== FALSE){
            $this->db->where($where);
        }

        $num_rows = $this->db->count_all_results();
     

        if($num_rows >0){
            return TRUE;
        }else{
            return FALSE;
        } 
    }

    public function list_pagination_count($table,$where = FALSE, $join_tables = FALSE, $group_by = FALSE){
                
        $this->db->from($table);

        if(is_array($join_tables)){
            foreach($join_tables as $join_table){
                $this->db->join($join_table[0], $join_table[1],(isset($join_table[2])?$join_table[2]:'inner'));
            } 
        }

        if($where != FALSE){
            $this->db->where($where);
        }

        if(!empty($group_by)){
            $this->db->select('count(distinct(' . $group_by . ')) as counter');
        }else{
            $this->db->select('count(1) as counter');
        }

        $query = $this->db->get();

        $row = $query->row_array();

        if(empty($row))
            return 0;
        else
            return $row['counter'];

    }

    public function list_pagination($table , $page, $page_size, $fields = '*', $where = FALSE, $order_by = FALSE, $join_tables = FALSE, $group_by = FALSE){

        $data = array("record_count" => 0, "list_items" => array());

        $data["record_count"] = $this->list_pagination_count($table,$where,$join_tables,$group_by);
        if($data["record_count"]==0){
            return $data; 
        }
 
        $offset = ($page - 1) * $page_size;
        $this->db->select($fields, FALSE)
            ->from($table)
            ->limit($page_size,$offset);

        if(is_array($join_tables)){
            foreach($join_tables as $join_table){
                $this->db->join($join_table[0], $join_table[1],(isset($join_table[2])?$join_table[2]:'inner'));
            } 
        }

        if($where !== FALSE){
            $this->db->where($where);    
        }

        if($order_by !== FALSE){
            $this->db->order_by($order_by);    
        }

        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }

        $query = $this->db->get();

        $data["list_items"] = $query->result_array();
        return $data;
    }
}
    
    
/* End of file crud.php */
/* Location: ./system/application/models/crud.php */