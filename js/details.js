$(document).ready(function() {


	// Listening to delete button
	$(".container").on("click", ".delete-button", function(event) {
		event.preventDefault();

		console.log("delete button clicked");

		let $photo_id = $(this).val();

		console.log($photo_id);

		// POST request to delete the photo_id
		postDelete($photo_id);
	});

	function postDelete(photo_id) {
		$.ajax({
			method: "POST",
			url: "backend/delete_backend.php",
			data: {
				photo_id: photo_id
			}
		})
		.done(function(result) {
			console.log(result);
			result = JSON.parse(result);
			
			if (result.message == "delete success") {
				window.location.href = "account.php";
			}
			else {
				alert(result.message);
			}
			
		})
		.fail(function() {
			console.log("fail");
		})
	}
});