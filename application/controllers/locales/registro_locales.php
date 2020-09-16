<?php
class Registro_locales extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('rlocales_model');
	}
	
	public function index(){
		$data['field'] = $this->rlocales_model->campos();
		$data['dpto'] = $this->rlocales_model->ubigeo_cdepart();
		$this->load->view('template/header');
		$this->load->view('locales/index', $data);
		$this->load->view('template/footer');
	}
	public function datos_locales(){
		$num_set = count($_REQUEST);
		$calc = $num_set/2;
		for($i=1; $i<=$calc; $i++)
		{
			echo $this->input->post('t'.$i)." = ".$this->input->post('v'.$i). "<br>";
		}
	}
	
	public function codprov($dpto){
		$prov = $this->rlocales_model->ubigeo_codprov($dpto);
		echo "<option> -- <option>";	
		foreach($prov as $row){
			if($row['codprov'] == 0){
				
			}else{
				echo "<option value='".$row['codprov']."'>".$row['nombre'] ."</option>";	
			}
		}
	}
	
	public function coddist($dpto, $prov){
		$dist = $this->rlocales_model->ubigeo_coddist($dpto, $prov);
		echo "<option> -- <option>";	
		foreach($dist as $row){
			if($row['coddist']==1){
				
			}else{
				echo "<option value='".$row['coddist']."'>".$row['nombre'] ."</option>";	
			}
		}
	}

}