

@section('style')
<style>
    .bg-transparent{
        background:transparent !important;
        border:none
    }
    .center-items{
        display: flex;
        justify-items: center;
    }
    p{
        color: #ffff !important
    }
</style>
@endsection


		<!-- accordion start-->
		<div class="adminpro-accordion-area">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12"> </div>
				</div>
				<div class="row center-items">
					<div class="col-lg-3">

					</div>
					<div class="col-lg-6 bg-transparent">
						<div class="admin-pro-accordion-wrap mg-b-15 shadow-reset bg-transparent">
							<form action="{{route('accounts.inflows.store')}}" method="POST">
							<div class="panel-group adminpro-custon-design bg-transparent" id="accordion">
								<div class="panel panel-default bg-transparent">
                                                   @csrf
									<div id="form" class="panel-collapse panel-ic collapse in">
										<div class="form admin-panel-content animated bounce" style="border:rgba(0,15,25,0.5) 2px groove;padding:2vw">
                                                <p>Account Name</p>
                                                <div class="">
                                                    <input type="text" name="source_identifier" class="form-control" required="required">
                                                </div>


											<p>Account Balance</p>
											<div class="">
												<input type="number" name="amount" class="form-control" required="required"></div>

											<p></p>
											<div class="">
												<div class="login-horizental login-btn-inner">
													<button class="btn btn-sm btn-primary login-submit-cs" type="submit" name="submit">Make Inflow</button>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default bg-transparent">

										<div id="collapse2" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

											</div>
										</div>
									</div>
									<div class="panel panel-default bg-transparent">

										<div id="collapse3" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

											</div>
										</div>
									</div>
								</div>
							</div>
							</form>
						</div>
						<div class="col-lg-3">

						</div>
					</div>
				</div>
			</div>
			<!-- accordion End-->

