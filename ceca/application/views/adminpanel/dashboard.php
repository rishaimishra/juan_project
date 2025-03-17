
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
                <div class="content container-fluid">
					<?php print_r($SESSION['admin_data']);?>

					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">

									<div class="row">
										<div class="col-md-9">
											<h4 class="card-title">View Transactions </h4>
										</div>
										<div class="col-md-3">
											
										</div>
									</div>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table class="datatable table table-stripped">
											<thead>
												<tr>
													<th>#</th>
													<th>Invoice Id</th>
													<th>Operation</th>

													<th>Empresa</th>
													<th>User Name</th>
													<th>User Email</th>
													<th>Amount</th>
													<th>Status</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
								                if (!empty($rows)) {
								                  foreach ($rows as $cols) { ?>
												<tr>
													<td><?php echo ++$count; ?></td>
													<td><?php echo $cols['inv_id']; ?></td>
													<td><?php echo $cols['order_id']; ?></td>
													<td><?php echo $cols['comp_name']; ?></td>
													<td><?php echo $cols['nombre']; ?> <?php echo $cols['apellidos']; ?></td>
													<td><?php echo $cols['email']; ?></td>
													<td>€ <?php echo number_format($cols['amount'],2); ?></td>
													<td>
														<?php if($cols['status'] == 1){ ?>
															<span class="badge badge-success">Success</span>
														<?php } else { ?>
															<span class="badge badge-danger">Failed</span>
														<?php } ?>
													</td>

													<td><?php echo $cols['added_on']; ?></td>
													<td>

														<div class="actions">
															<a class="btn btn-sm bg-danger-light" onclick="deleteCeca(this)" data-key="<?php echo base64_encode($cols['ceca_id']); ?>">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td>
												</tr>
											<?php } } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					


				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		