<?php

class AdminModel extends ci_model {

	public function selectAllFromWhere($tableName=null,$condition=null,$getColumn=null) {
		$query = $this->db->get_where($tableName,$condition)->result_array();
		
		if($getColumn==null) {
		    return $this->db->affected_rows()?$query:FALSE;
		} else {
		 	return $this->db->affected_rows()?$query[0][$getColumn]:FALSE;
		}
	}

	public function selectAllFromTableOrderBy($tableName=null,$columnName=null,$orderBy=null,$condition=null)
	{
		$this->db->order_by($columnName,$orderBy);
		if($condition!='')
		{
			$query = $this->db->get_where($tableName,$condition)->result_array();
            return $this->db->affected_rows()?$query:FALSE;
		}
		else
		{
			$query = $this->db->get($tableName)->result_array();
            return $this->db->affected_rows()?$query:FALSE;
		}
	}
	

	public function selectAllFromTable($tableName=null) {
		$query = $this->db->get($tableName);
		$result=$query->result_array();
		return $this->db->affected_rows()?$result:FALSE;
	}

	public function insertInto($tableName=null, $data=null) {
		$this->db->insert($tableName, $data);
		return $this->db->affected_rows() ? TRUE:FALSE;
	}

	public function updateWhere($tableName=null,$data=null,$condition=null){	
		$this->db->trans_start();
		$this->db->where($condition);
		$this->db->update($tableName, $data); 
		$this->db->trans_complete();
		return $this->db->trans_status();
		//	$this->db->where($condition);
		//	$this->db->update($tableName, $data); 
		//	return $this->db->affected_rows()?TRUE:FALSE;
	}

	public function deleteFromTable($tableName=null,$condition=null)
	{
		$this->db->delete($tableName,$condition);
		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function selectAllFromTableGroupBy($tableName=null,$condition=[],$groupBy=null)
	{
		$this->db->group_by($groupBy);
		$this->db->where($condition);
		$q = $this->db->get($tableName)->result_array();

		if($this->db->affected_rows())
		{
			return $q;
		}
		else
		{
			return false;
		}
	}
	

	public function invoice_detail($inv_id){

		 $this->db->select('*, facturas.id as invoice_id,facturas.fk_empresa as comp_id,facturas.fk_usuario as user_id,facturas.fk_orden_compra as order_id  ');
		 $this->db->from('facturas'); 
		 $this->db->join('ordenes_compra', 'ordenes_compra.id = facturas.fk_orden_compra');
		 $this->db->where('facturas.id', $inv_id);
		 $query = $this->db->get();
		 $result=$query->result_array();
		return $this->db->affected_rows()?$result:FALSE;

	}


	public function all_transactions() {
    $this->db->select('*, b.nombre as comp_name,a.id as ceca_id ');
    $this->db->from('ceca_gateway a'); 
    $this->db->join('empresa as b', 'b.id=a.empresa_id', 'left');
    $this->db->join('usuarios c', 'c.id=a.user_id', 'left');
    $this->db->order_by('a.id','desc');         
    $query = $this->db->get(); 
    if($query->num_rows() != 0)
    {
        return $query->result_array();
    }
    else
    {
        return false;
    }


}




}