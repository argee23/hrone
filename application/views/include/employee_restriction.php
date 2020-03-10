<?php

		/*
		validate access rights		
		*/
		if($this->session->userdata('serttech_account')=="1"){
			$location_rights="";
			$classification_rights="";
		}else{
			if($this->session->userdata('location_rights')!=""){
				$location_rights="AND (".$this->session->userdata('location_rights').")";
			}else{
				$location_rights="AND a.location='0'";//force no result as no access rights yet.
			}
			if($this->session->userdata('classification_rights')!=""){
				$classification_rights="AND (".$this->session->userdata('classification_rights').")";
			}else{
				$classification_rights="AND a.classification='0'";//force no result as no access rights yet.
			}
			//echo " $classification_rights | $location_rights";
		}
		

?>