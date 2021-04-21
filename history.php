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
		<div class="accordion>
		<?php
		if( isset($_REQUEST['d']) ){
			$data = decode( $_REQUEST['d'] );
			$rows = $this -> _ITExt -> select('system__history','*', ['table' => $data['table'],'ref' => $data['id'],'ORDER' => ['date' => 'DESC']]);
			$actual_data = $this -> _ITExt -> get($data['table'],'*', [ $data['table'].'_id' => $data['id'] ]);
			if($rows){
				foreach($rows as $num => $row) {
				//$json_string = json_encode(json_decode($row['data']), JSON_PRETTY_PRINT); 
				//echo "<h4 class=\"mt-3 mb-1\">".$_ITE->funcs->date_format($row['date'],5)."</h4><pre>".$json_string."</pre>";
				?>
				  <div class="card">
				    <div class="card-header" id="heading<?=$num?>">
				      <h2 class="mb-0">
				        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?=$num?>" aria-expanded="true">
				          <?=$this -> _ITE -> funcs -> date_format( $row['date'], 5 )?>
				        </button>
				      </h2>
				    </div>

				    <div id="collapse<?=$num?>" class="collapse">
				      <div class="card-body">
				      	<ul>
				        <?php
						$json_array = json_decode( $row['data'], true );
						foreach( $json_array as $key => $value ){
							
							if( isset( $actual_data[$key] ) && $actual_data[$key] == $value ){
								echo "<li>".$key.': '.$value."</li>\n";
							} else {
								echo "<li>".$key.': <span class="yellow400_bg">'.$value."</span></li>\n";
							}
						}

						$actual_data = $json_array;
				        ?>
			    		</ul>
				      </div>
				    </div>
				  </div>
				<?php
				}
			}
		}
		?>
		</div>
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