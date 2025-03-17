
	<div class="container" style="margin-top: 50px">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="panel panel-default">
				      <div class="panel-heading">Pay Invoice</div>
				      <div class="panel-body">
				      		<FORM ACTION="https://pgw.ceca.es/tpvweb/tpv/compra.action" METHOD="POST" ENCTYPE="application/x-www-form-urlencoded">

				      			<h3>Order Name: <?= $invoice_details[0]['nombre'];?></h3>
				      			<br/>
								<input type="hidden" name="Key_encryption" value="02WLXVR4"> 
								<INPUT NAME="MerchantID" TYPE=hidden VALUE=086941259 id="merchant_id">
								<INPUT NAME="AcquirerBIN" TYPE=hidden VALUE=0000554026 id="AcquirerBIN" >
								<INPUT NAME="TerminalID" TYPE=hidden VALUE=00000003 id="TerminalID" >
								<INPUT NAME="URL_OK" TYPE=hidden VALUE="<?= base_url();?>success/<?= $invoice_details[0]['invoice_id'];?>/<?= $invoice_details[0]['comp_id'];?>/<?= $invoice_details[0]['order_id'];?>/<?= $invoice_details[0]['user_id'];?>/<?= number_format($invoice_details[0]['precio'],2); ?>" id="URL_OK" >
								<INPUT NAME="URL_NOK" TYPE=hidden VALUE="<?= base_url();?>failed/<?= $invoice_details[0]['invoice_id'];?>/<?= $invoice_details[0]['comp_id'];?>/<?= $invoice_details[0]['order_id'];?>/<?= $invoice_details[0]['user_id'];?>/<?= number_format($invoice_details[0]['precio'],2); ?>" id="URL_NOK">
								<INPUT NAME="Firma" TYPE=hidden VALUE="" id="Firma">
								<INPUT NAME="Cifrado" TYPE=hidden VALUE="SHA2" id="Cifrado">

								<label>Order Id:</label>
								<INPUT NAME="Num_operacion" class="form-control" TYPE=text VALUE="<?= $invoice_details[0]['order_id'];?>" id="Num_operacion" readonly >

								<label>Amount: <small>(in Euro)</small></label>
								<INPUT class="form-control" TYPE=text VALUE="<?= number_format($invoice_details[0]['precio'],2) ; ?>" class="form-control" readonly>

								<INPUT class="form-control" NAME="Importe" TYPE=hidden VALUE="<?= round($invoice_details[0]['precio'],2) * 100 ; ?>" id="Importe" readonly >

								<INPUT NAME="TipoMoneda" TYPE=hidden VALUE=978 id="TipoMoneda">
								<INPUT NAME="Exponente" TYPE=hidden VALUE=2 id="Exponente">
								<INPUT NAME="Pago_soportado" TYPE=hidden VALUE=SSL id="Pago_soportado">
								
								<INPUT NAME="Idioma" class="form-control" TYPE=hidden VALUE="6" id="Idioma" readonly>
								<!--<INPUT NAME="datos_acs_20" TYPE=hidden VALUE="datos_acs_20">
								<INPUT NAME="firma_acs_20" TYPE=hidden VALUE="firma_acs_20">-->

								<p style="color: red;margin-top: 15px"><b>Note:</b> Please click on <b>ACCEPT</b> button after completing the transaction</p>
								<CENTER>
								<INPUT TYPE="submit" VALUE="Make Payment" class="btn btn-primary mt-50">
								</CENTER>
							</FORM>
				      </div>
				  </div>

			</div>
		</div>
	</div>
</body>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  	var MerchantID=$("#merchant_id").val();
  	var AcquirerBIN=$("#AcquirerBIN").val();
  	var TerminalID=$("#TerminalID").val();
  	var order_id=$("#Num_operacion").val();
  	var amount=$("#Importe").val();
  	var currency_type=$("#TipoMoneda").val();
  	var Exponent=$("#Exponente").val();
  	var Cifrado=$("#Cifrado").val();
  	var URL_OK=$("#URL_OK").val();
  	var URL_NOK=$("#URL_NOK").val();
  	
  	$.ajax({
        type: "POST",
        url: "<?php echo base_url('Main_controller/generate_hash'); ?>",
        data:{MerchantID: MerchantID,AcquirerBIN:AcquirerBIN,TerminalID:TerminalID,order_id:order_id,amount:amount,currency_type:currency_type,Exponent:Exponent,Cifrado:Cifrado,URL_OK:URL_OK,URL_NOK:URL_NOK},
        dataType:"json",
        success: function(response){
            $("#Firma").val(response.hash);
            console.log(response.hash);
        }
    });
  	

});
</script>

