<div class ="panel panel-default">
	<div class="panel-heading">
		<i class = "icon-gear"></i>&nbsp;{l s='Chez Smoke' mod='smoke'}
	</div>

	<div class="panel-body">

	<form id="myform">		
		<div class="col-lg-4" id="saise">
			<label for="id_category">Numero de carte : </label>
			<input type="text" name="id_categoryName" id="id_category" class="form-control" required >
		
			<label for="nbpoints">Nombre de point(s) à ajouter : </label>
			<input type="text" name="nbpoints"  id="nbpoints" class="form-control" required >	
			
	
			<br>
			<br>
			
			<div class="col-lg-4 ">
				<button type="button" value="Valider" id="valide" class="btn btn-success va"  >			
					<i class ="icon_download"></i>&nbsp;{l s='Valider' mod='smoke'}	
				</button>
			
				
				<button type="button" class="btn btn-danger"  name="annuleselect" id="annuleselect">
					<i class ="icon_download"></i>&nbsp;{l s='Annuler' mod='smoke'}				
				</button>
			</div>


		</div>
	</form>

	
	<div class="clearfix" ></div>
		<br><br>
		
 	
		<div id="info"><h4></h4></div>
		</br>
		<div id="cumul"><h4></h4></div>
		
		<div class="col-lg-10 hidden" id="resultdata" >
		 	<div> 
			 	<div class="col-lg-4 ">
					<button type="button" value="Valider" id="btnConf" class="btn btn-success"  >			
						<i class ="icon_download"></i>&nbsp;{l s='Confirmer la transaction' mod='smoke'}	
					</button>
				
					
					<button type="button" class="btn btn-danger"  name="annuletrans" id="annuletrans">
						<i class ="icon_download"></i>&nbsp;{l s='Annuler la transaction' mod='smoke'}				
					</button>
				</div>	
			</div>
		</div >
		
		<div id="messageretour" class=hidden>
		
			<div id="inforetour"></div>
		
			<button type="button" class="btn btn-success"  name="annuletrans" id="annuletrans">
				<i class ="icon_download"></i>&nbsp;{l s='Annuler la transaction' mod='smoke'}				
			</button>
		
		</div>

	</div>
	
	<input type="number" name="id_customer"  id="id_customer" class="form-control hidden"   >	
	
	<div id="ficheClient" class="hidden">
		<a id="link">Voir Fiche Client</a>
	</div>
	
</div>






