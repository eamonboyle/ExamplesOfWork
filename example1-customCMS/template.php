<?	$this->extend('layout/dashboard-new'); ?>

<?	$this->start('page_title'); ?>
		Buyers
<?	$this->stop(); ?>

<?	$this->start('content'); ?>

	<div class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
		<button data-remodal-action="close" class="remodal-close"></button>
		<h1>Remove Buyer?</h1>
		<p>If you delete this buyer, all of the property progress associated with them will be deleted.</p>
		<br>
		<button data-remodal-action="cancel" class="remodal-confirm">Cancel</button>
		<button data-remodal-action="confirm" class="remodal-cancel">Delete</button>
	</div>

	<div class="row grids-container">

<?		if(count($allBuyers)) { ?>

			<div class="col-sm-12 chain-search">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Search:</h3>
					</div>
					<form action="" method="post">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<input type="text" name="searchQuery" placeholder="Enter search term..." value="<?= $searchQuery; ?>">
								</div>
								<div class="search-button-container col-md-7">
									<button class="btn btn-fill confirm-button green-button">
										<i class="fa fa-search"></i>
										Search
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="col-sm-12">
				<a href="/dashboard/buyers/add">
					<button class="btn btn-fill confirm-button green-button margin-bottom-10"><i class="fa fa-plus"></i> Add New</button>
				</a>
			</div>

<?			if($searchQuery) {

				echo '<div class="col-sm-12" style="padding-bottom: 10px;">';
					echo 'Your search returned: <b>' . count($allBuyers) . ' buyer' . (count($allBuyers) > 1 || count($allBuyers) == 0 ? "s</b>. " : "</b>. ") . '<a href="/dashboard/buyers"><button class="btn btn-fill confirm-button" style="padding: 5px;">Clear search</button></a>';
				echo '</div>';

			} // endif ?>

			<div class="col-sm-12">
				<table class="table chain-table buyers-page">
					<thead>
						<tr class="not-this">
							<th>Name:</th>
							<th>Company:</th>
							<th>Email:</th>
							<th>Phone:</th>
							<th>Postcode:</th>
							<th></th>
						</tr>
					</thead>

<?					foreach($allBuyers as $buyer) { ?>

						<tr>
							<td><?= $buyer->first_name . ' ' . $buyer->last_name; ?></td>
							<td><?= (!empty($buyer->company) ? $buyer->company : 'N/A'); ?></td>
							<td><a href="mailto:<?= $buyer->email; ?>"><?= $buyer->email; ?></a></td>
							<td><?= (!empty($buyer->telephone) ? $buyer->telephone : 'N/A'); ?></td>
							<td><?= (!empty($buyer->postcode) ? strtoupper($buyer->postcode) : 'N/A'); ?></td>
							<td>
								<a href="/dashboard/buyers/edit/<?= $buyer->id; ?>">
									<button class="view-button"><i class="fa fa-eye"></i> Edit</button>
								</a>
								<button class="delete-chain" buyer-id="<?= $buyer->id; ?>"><i class="fa fa-trash-o"></i> Delete</button>
							</td>
						</tr>

<?					} // endforeach ?>

				</table>
			</div>

<?		} else { ?>

			<div class="col-sm-12">
				<div class="card">
					<div class="header">
						<h4 class="title">Buyers</h4>
					</div>
					<div class="content">
						<div class="row">
							<div class="col-sm-12">
								<p>You have not added any buyers yet. Add one <a href="/dashboard/buyers/add">here</a>.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

<?		} // endif ?>

	</div>

<?	$this->stop(); ?>

<?	$this->start('additional_scripts'); ?>

		<script src="/js/vendor/remodal.min.js"></script>

		<script>
			$(function() {

				$('BUTTON.delete-chain').on('click', function() {

					$(this).attr('disabled', true);

					var buyerID = $(this).attr('buyer-id');

					var inst = $('[data-remodal-id=modal]').remodal();

					// Set the modal confirm button buyer-id
					$('[data-remodal-id=modal] [data-remodal-action=confirm]').attr('buyer-id', buyerID);

					// Open the modal
					inst.open();

				});

				// When the delete modal is closed
				$(document).on('closed', '.remodal', function (e) {

					// Enable all delete buttons
					$('.delete-chain').each(function() {
						$(this).attr('disabled', false);
					});

				});

				// When the user confirms the delete
				$(document).on('confirmation', '.remodal', function () {

					// Get the Chain ID
					var buyerID = $('[data-remodal-id=modal] [data-remodal-action=confirm]').attr('buyer-id');
					window.location.href = '/dashboard/buyers/delete/' + buyerID;

				});

			});
		</script>

		<script>
			$(function() {
				$('LI#menu7').addClass('active');
			});
		</script>

<?	$this->stop(); ?>

