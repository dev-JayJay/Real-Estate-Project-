<?php include 'header.php'; ?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Contact</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="contact-form">
                    <form action="<?php echo BASE_URL; ?>ajax-contact.php" method="post" class="form_contact">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Message</label>
                            <textarea class="form-control" rows="3" name="message"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-website">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="map">
                    <?php
                    // $statement = $pdo->prepare("SELECT * FROM settings WHERE id=1");
                    // $statement->execute();
                    // $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <!-- <?php echo $result[0]['map']; ?> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function($){
	"use strict";
	$(document).ready(function(){
		$(".form_contact").on('submit', function(e){
			e.preventDefault();
			let formData = new FormData(this);
			let form = this;
			$.ajax({
				url: this.action,
	            type: 'POST',
	            data: formData,
				success: function(data) {
					data = JSON.parse(data);
					if(data.error_message) {
                        iziToast.show({
                            message: data.error_message,
                            position: 'topRight',
                            color: 'red',
                        });
					} else {
						form.reset();
                        iziToast.show({
                            message: data.success_message,
                            position: 'topRight',
                            color: 'green',
                        });
					}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		});
	});
})(jQuery);
</script>

<?php include 'footer.php'; ?>