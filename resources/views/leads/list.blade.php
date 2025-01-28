@extends('layouts.home')

@section('content')
<style>
    ul{
        list-style-type: none;
    }
    .opp_list li a{
        color: #0772b1;
    }
    .opp_list li a:hover{
        color: #0772b1;
    }
</style>
  <!-- Success Message -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

      <!-- Validation Errors -->

<section>
      <div>
        <section class="text-center bg_color login_section">
          <!-- <h3 class="white fz36 mb-0 font_bold">{{__('lang.text_ventas')}}</h3> -->
          <h3 class="white fz36 mb-0 font_bold">{{__('lang.contractor_area') }}</h3>
        </section>
        <div class="login_form p-5 font_bold c-form">
            <form action="" method="POST">
              @csrf
              <div class="container">
                  <div class="row">
                      <div class="col-md-4">
                        <ul class="opp_list">
                            <li><a href="{{ route('users-dashboard') }}">{{ __('lang.text_opportunity_list') }}</a></li>
                            <li><a href="{{ route('invoice-list') }}">{{ __('lang.text_facturas') }}</a></li>
                        </ul>
                    </div>  
                    <div class="col-md-8">
                        <!-- <h1>{{__('lang.text_purchase_order_list')}}</h1> -->
                        <h1>{{ __('lang.text_facturas') }}</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                <!-- <th scope="col">{{ __('lang.text_branch') }}</th> -->
                                <th scope="col">Name</th>
                                <!-- <th scope="col">{{ __('lang.text_email') }}</th>
                                <th scope="col">{{ __('lang.text_po_name') }}</th>-->
                                <th scope="col">{{ __('lang.text_status') }}</th> 
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Leads as $opp)
                                   <tr>
                                <td>{{ $opp->opportunity->opportunity_name ?? "" }}</td>
                                <!-- <td>{{ Auth::user()->email }}</td>
                                <td>{{ $opp->window_with_name }}</td>-->
                                <td>{{ $opp->status }}</td>
                                    <td>
                                        <a href="{{ route('paypal.payment',['amount'=>$opp->amount,'id'=>$opp->id]) }}" class="btn btn-primary">{{ __('lang.pay_invoice') }}</a>
                                        <form action="https://pgw.ceca.es/tpvweb/tpv/compra.action" method="POST" style="display: inline">
                                            @csrf
                                            <input type="hidden" name="Key_encryption" value="02WLXVR4"> 
								<input name="MerchantID" type="hidden" value=086941259 id="merchant_id">
								<input name="AcquirerBIN" type="hidden" value=0000554026 id="AcquirerBIN" >
								<input name="TerminalID" type="hidden" value=00000003 id="TerminalID" >
								<input name="URL_OK" type="hidden" value="https://www.bidinline.com/ceca/success/356/5/1154/1/1.05" id="URL_OK" >
								<input name="URL_NOK" type="hidden" value="https://www.bidinline.com/ceca/success/356/5/1154/1/1.05" id="URL_NOK">
								<input name="Firma" type="hidden" value="" id="Firma">
								<input name="Cifrado" type="hidden" value="SHA2" id="Cifrado">

								{{--  <label>Order Id:</label>  --}}
								<input name="Num_operacion" class="form-control" type="hidden" value="16" id="Num_operacion"  >

								{{--  <label>Amount: <small>(in Euro)</small></label>  --}}
								<input class="form-control" type="hidden" value="10" class="form-control" >

								<input class="form-control" name="Importe" type="hidden" value="10.01" id="Importe"  >

								<input name="TipoMoneda" type="hidden" value=978 id="TipoMoneda">
								<input name="Exponente" type="hidden" value=2 id="Exponente">
								<input name="Pago_soportado" type="hidden" value=SSL id="Pago_soportado">
								
								<input name="Idioma" class="form-control" type="hidden" value="6" id="Idioma">
                                            {{--  <button type="submit" class="btn btn-primary">Card Payment</button>  --}}
                                        </form>
                                        {{--  <a href="{{ route('paypal.card-payment',['amount'=>$opp->amount,'id'=>$opp->id]) }}" class="btn btn-primary">Pay with card</a>  --}}
                                        <a href="{{ asset('public/'.$opp->invoice_path) }}" download>
    <svg style="width:30px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
    </svg>
</a>
  <a href="{{ route('contractor-message-opportunity', ['id' => $opp->id, 'oppId' => $opp->opportunity_id]) }}" class="btn btn-primary">{{ __('lang.message') }}</a>
                                        <!-- <a href="#" class="btn btn-success" onclick="showSimpleModal('approve')">{{ __('lang.text_approve') }}</a>
                                        <a href="#" class="btn btn-danger" onclick="showSimpleModal('reject')">{{ __('lang.text_reject') }}</a> -->
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                            </table>
                    </div>
                  </div>
              </div>
            </form>
        </div>
      </div>
      <div class="modal fade" id="simpleConfirmModal" tabindex="-1" aria-labelledby="simpleConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="simpleConfirmModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="simpleModalMessage">
                    <!-- Message will be set dynamically -->
                </div>
                <div class="modal-footer">
                    <!-- No Button -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                    <!-- Yes Button -->
                    <a href="#" id="confirmAction" class="btn">Yes</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function showSimpleModal(action) {
        const modalMessage = document.getElementById('simpleModalMessage');
        const confirmAction = document.getElementById('confirmAction');

        // Set modal message and action URL based on the button clicked
        if (action === 'approve') {
            modalMessage.textContent = "Are you sure you want to approve this item?";
            confirmAction.href = "{{ url('admin/approve') }}"; // Set the URL for approve action
            confirmAction.className = "btn btn-success";  // Set button style for approve
        } else if (action === 'reject') {
            modalMessage.textContent = "Are you sure you want to reject this item?";
            confirmAction.href = "{{ url('admin/reject') }}"; // Set the URL for reject action
            confirmAction.className = "btn btn-danger";  // Set button style for reject
        }

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('simpleConfirmModal'));
        modal.show();
    }
</script>
@endsection
