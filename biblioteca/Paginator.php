<?php
namespace biblioteca;
use biblioteca\Mysqli;
 
class Paginator extends Mysqli {
 
     private $_conn;
     private $_limit;
     private $_page;
     private $_query;
     private $_total;
	 private $mysqli;
		
	public function __construct($query) {
		$this->mysqli = new \biblioteca\Mysqli(); 
		$this->mysqli->init();
		
	 
		$rs = $this->mysqli->Conectar()->SelectDb()->FetchAll($query);
		$this->_total = count($rs);

	}
	
	public function __get($prop) {
        return $this->$prop;
    }
        
    public function __set($prop, $val) {
        $this->$prop = $val;
    }	
	
	public function getData( $limit = 10, $page = 1 ,$query) : ?array { 
		$this->_limit   = $limit;
		$this->_page    = $page;
		
		if(!is_numeric($page) or !is_numeric($this->_limit)){
			echo "Não é númerico";
			exit;
			
		}
		$p = ( ( $this->_page - 1 ) * $this->_limit );
				
		
		$rs  = $this->mysqli->Conectar()->SelectDb()->FetchAll("{$query} LIMIT {$p},{$this->_limit}"); 

		return $rs;
	}

	public function createLinks( $links, $list_class ): ?string{
		if ( $this->_limit == 'all' ) {
			return '';
		}
	 
		$last       = ceil( $this->_total / $this->_limit );
	 
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
	 
		$html       = '<ul class="' . $list_class . '">';
		
		if($this->_page == 1){
			
		}else{
			$class      = ( $this->_page == 1 ) ? "disabled" : "";
			$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
		}
		if ( $start > 1 ) {
			$html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}
	 
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
		}
	 
		if ( $end < $last ) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
		}
	 
		$class      = ( $this->_page == $last ) ? "disabled" : "";
		
		if( ($this->_page != $last) && $last!=0){
			$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
		}
		$html       .= '</ul>';
	 
		return $html;
	}	
 
}