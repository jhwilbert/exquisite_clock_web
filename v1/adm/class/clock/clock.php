<?php
class Clock extends ClockRoot{ 

	/* *************** The resources *************** */
	/** image resource object */
	var $image;


	/* *************** Pattern constructor *************** */
	function Clock(){
		parent::ClockRoot();
		/* Image resource initialization */
		$this->image = new ImageResource($this->dbTable, $this->id, 1);
	}

	/* *************** Install functions *************** */
	function install(){
		/* image resource install */
		$this->image->install();
		parent::install();
	}

	function del(){ 
		if(toInt($this->id)>0){ 
			parent::del();
			$strSQL = "DELETE FROM clockTag WHERE clockId = ".$this->id .""; 
			$this->DB->exe("".$this->className." :: function del(".$this->id.") - Clock del ClockTag",$strSQL); 
		} 
	} 
}
?>
