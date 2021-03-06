<table id="gridCar" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
        	<th>Id</th>
            <th>Modelo</th>
            <th>Opcões</th>
        </tr>
    </thead>
    <tbody id="dadosCar">

    </tbody>
</table>

<script type="text/javascript">

data = [];
data.push({name: 'type', value: 'getCarro'});

$.ajax({
	url: "controls/CarroControl.php",
	type: "post",
	data: data,
	dateType: "json",
	success: function (response) {  
	var carros = JSON.parse(response);
	for(var i = 0; i < carros.length ; i++){
		var id = '<td>'+carros[i].car_id+'</td>';
		var modelo = '<td>'+carros[i].modelo+'</td>';
		var btnAlterarCarro = '<td id="opcoes"><button value="'+carros[i].car_id+'" data-toggle="tooltip" title="Alterar Carro" class="btn btn-warning btnAlterarCarro"><i class="glyphicon glyphicon-pencil"></i></button>';
		var btnDeletarCarro = '<button value="'+carros[i].car_id+'" data-toggle="tooltip" title="Deletar Carro" class="btn btn-danger btnDeletarCarro"><i class="glyphicon glyphicon-remove"></i></button></td>';

		$('#dadosCar').append('<tr>'+id+modelo+btnAlterarCarro+btnDeletarCarro+'</tr>');

	}
	$('#gridCar').DataTable();
	},
	error: function(jqXHR, textStatus, errorThrown) {
	 alert(textStatus, errorThrown);
	}
});

 /*Por conter HTML gerado dinamicamente, evento eh declarado desta forma*/
$(document.body).on("click", ".btnDeletarCarro", function(e){
	if (confirm("Voce deseja apagar este registro?") == true) {
		var id = $(this).val();
		data = [];
		data.push({name: 'car_id',value: id});
		data.push({name: 'type', value: 'deleteCarro'});
		$.ajax({
			url: "controls/CarroControl.php",
			type: "post",
			data: data,
			dateType: "json",
			success: function (response) {  
			alert(response);
	        $('#painelCar').click();  
			},
			error: function(jqXHR, textStatus, errorThrown) {
			 alert(textStatus, errorThrown);
			}
		 });
	}
	//Necessario "matar o evento de click, para que no proximo load, multiplos eventos nao sejam disparados"
	$(this).die('click'); 
});

$(document.body).on("click", ".btnAlterarCarro", function(e){
	var id = $(this).val();
	data = [];
	data.push({name: 'car_id',value: id});
	data.push({name: 'type', value: 'getCarroPorId'});
	$.ajax({
		url: "controls/CarroControl.php",
		type: "post",
		data: data,
		dateType: "json",
		success: function (response) {  
		var carro = JSON.parse(response);
		$('#carPlaca').val(carro[0].placa);
		$('#carChassi').val(carro[0].chassi);
		$('#carModelo').val(carro[0].modelo);
		$('#carMarca').val(carro[0].marca);
		$('#carAno').val(carro[0].ano);
		$('#carCor').val(carro[0].cor);

		$('#btnCadastrarCarro').remove();
		$('#areaBtns').html('');
		$('#areaBtns').append('<button type="submit" id="btnUpdateCarro" value="'+carro[0].car_id+'"class="btn btn-warning">Alterar</button>');
		},
		error: function(jqXHR, textStatus, errorThrown) {
		 alert(textStatus, errorThrown);
		}
	 });
	//Necessario "matar o evento de click, para que no proximo load, multiplos eventos nao sejam disparados"
	$(this).die('click'); 
});

$(document.body).on("click", "#btnUpdateCarro", function(e){
	e.preventDefault();
    var form = $('#cadCar');
    var formData = form.serializeArray();

    var id = $(this).val();
    formData.push({name: 'car_id',value: id});
    formData.push({name: 'type', value: 'putCarro'});

	$.ajax({
		url: "controls/CarroControl.php",
		type: "post",
		data: formData,
		dateType: "json",
		success: function (response) {  
		 alert(response);
        $('#painelCar').click(); 
		},
		error: function(jqXHR, textStatus, errorThrown) {
		 alert(textStatus, errorThrown);
		}
	 });
	//Necessario "matar o evento de click, para que no proximo load, multiplos eventos nao sejam disparados"
	$(this).die('click'); 
});


</script>