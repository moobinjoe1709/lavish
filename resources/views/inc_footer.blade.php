<div class="flash-message">
	@if(Session::has('alert-insert'))
		<button type="button" id="miniSuccessTitle_insert" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-update'))
		<button type="button" id="miniSuccessTitle_update" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	elseif(Session::has('alert-approve'))
		<button type="button" id="miniSuccessTitle_approve" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-delete'))
		<button type="button" id="miniSuccessTitle_delete" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@endif
</div>
<script>
	$(document).ready(function(){
		$( ".miniSuccessTitle:first" ).trigger( "click" );
		
		$('.number').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
	});
</script>