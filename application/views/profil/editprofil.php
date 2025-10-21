        <!-- Small boxes (Stat box) -->
        <div class="row">
        	<div class="col-md-6">
        		<div class="card shadow card-outline card-primary">
        			<div class="card-header">
        				<a class="btn btn-sm btn-secondary" href="<?= base_url(); ?>profil">
        					<i class="fa fa-backward"></i> Kembali
        				</a>
        			</div>
        			<div class="card-body">
        				<form action="<?= base_url(); ?>/profil/updateprofil" method="post" enctype="multipart/form-data">
        					<input type="hidden" class="form-control" id="id" name="id" value="<?= $this->session->userdata['id_user']; ?>">
        					<input type="hidden" class="form-control" id="image_lama" name="image_lama" value="<?= $this->session->userdata['image']; ?>">
        					<div class="form-group row">
        						<div class="col-sm-2">Foto Profil</div>
        						<div class="col">
        							<div class="row">
        								<div class="col-sm-4">
        									<?php
											if ($this->session->userdata['image'] == '') {
												$image = 'default.png';
											} else {
												$image = $this->session->userdata['image'];
											}
											?>
        									<img src="<?php echo base_url(); ?>assets/foto/user/<?= $image ?>" class="img-thumbnail img-preview">
        								</div>
        								<div class="col">
        									<div class="custom-file">
        										<input type="file" class="custom-file-input" id="image" name="image" onchange="previewImg()">
        										<label class="custom-file-label" for="image">Pilih Foto</label>
        									</div>
        								</div>
        							</div>
        						</div>
        					</div>
        					<div class="form-group">
        						<button type="submit" class="btn btn-block btn-success">Simpan</button>
        					</div>
        				</form>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- /.row -->
        <script>
        	function previewImg() {
        		const image = document.querySelector('#image');
        		const imageLabel = document.querySelector('.custom-file-label');
        		const imgPreview = document.querySelector('.img-preview');

        		imageLabel.textContent = image.files[0].name;
        		const fileImage = new FileReader();
        		fileImage.readAsDataURL(image.files[0]);

        		fileImage.onload = function(e) {
        			imgPreview.src = e.target.result;
        		}
        	}
        </script>