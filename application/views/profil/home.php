        <!-- Small boxes (Stat box) -->
        <div class="row">
        	<div class="col">
        		<div class="card mb-3 shadow" style="max-width: 540px;">
        			<div class="row g-0">
        				<div class="col-md-4">
        					<?php
							if ($this->session->userdata['image'] == '') {
								$image = 'default.png';
							} else {
								$image = $this->session->userdata['image'];
							}
							?>
        					<img src="<?php echo base_url(); ?>assets/foto/user/<?= $image ?>" class="img-fluid rounded-start" alt="<?= $this->session->userdata['image']; ?>">
        				</div>
        				<div class="col-md-8">
        					<div class="card-body">
        						<h5 class="card-text">Profil User</h5>
        						<p class="card-text">Username: <?= $this->session->userdata['username']; ?></p>
        						<p class="card-text">Nama Lengkap: <?= $this->session->userdata['full_name']; ?></p>
        						<p class="card-text">Email: <?= $this->session->userdata['email']; ?></p>
        						<div class="row">
        							<div class="col">
        								<a href="<?= base_url(); ?>profil/editprofil">Edit Foto Profil</a>
        							</div>
        							<div class="col-ms">
        								<a href="<?= base_url(); ?>profil/changepassword">Ganti Password</a>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<!-- ./col -->
        </div>
        <!-- /.row -->