        <!-- Small boxes (Stat box) -->
        <div class="row">
        	<div class="col-md-6">
        		<div class="card shadow card-outline card-primary">
        			<div class="card-header">
        				<a class="btn btn-sm btn-secondary" href="<?= base_url(); ?>/profil">
        					<i class="fa fa-backward"></i> Kembali
        				</a>
        			</div>
        			<div class="card-body">
        				<form action="<?= base_url(); ?>/profil/updatepassword" method="post">
        					<input type="hidden" class="form-control" id="id" name="id" value="<?= $this->session->userdata['id_user']; ?>">
        					<div class="form-group">
        						<label for="new_password1">Password Baru</label>
        						<input type="password" class="form-control" id="new_password1" name="new_password1">
        					</div>
        					<div class="form-group">
        						<button type="submit" class="btn btn-block btn-success">Ganti Password</button>
        					</div>
        				</form>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- /.row -->