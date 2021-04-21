<?php
/**
 * Componente text
 */

class history extends base_component implements components_interface {

	public function make_history() : string {
		$html = '';

		ob_start();
		?>
		<div class="p-3">
		<p class="small alert alert-warning">* En amarillo, el valor previo de los campos que han sido cambiados.</p>
		<?php
		if( isset($_REQUEST['d']) ){
			$data = decode( $_REQUEST['d'] );
			$rows = $this -> _ITExt -> select('system__history','*', ['table' => $data['table'],'ref' => $data['id'],'ORDER' => ['date' => 'DESC']]);
			$actual_data = $this -> _ITExt -> get($data['table'],'*', [ $data['table'].'_id' => $data['id'] ]);

			if($rows){foreach($rows as $num => $row){
				//$json_string = json_encode(json_decode($row['data']), JSON_PRETTY_PRINT); 
				//echo "<h4 class=\"mt-3 mb-1\">".$_ITE->funcs->date_format($row['date'],5)."</h4><pre>".$json_string."</pre>";
				echo "<h5 class=\"mt-3 mb-1\">".$this -> _ITE -> funcs -> date_format($row['date'],5)."</h5><ul>";
				$json_array = json_decode( $row['data'], true );
				foreach( $json_array as $key => $value ){
					
					if( isset( $actual_data[$key] ) && $actual_data[$key] == $value ){
						echo "<li>".$key.': '.$value."</li>\n";
					} else {
						echo "<li>".$key.': <span class="yellow400_bg">'.$value."</span></li>\n";
					}
				}
				echo '</ul>';

				$actual_data = $json_array;
			}}
		}
		?>
		</div>
		<?php

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	public function gen_content( ) : string {		
		return $this -> make_history();
	}
}