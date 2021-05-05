$(document).ready(function () {

	// Form Related
	const $searchFormContainer = $(".search-form-container");
	const $searchForm = $("#search-form");
	const $searchDate = $("#search-date");

	// Search Result Stuff
	const $searchResult = $(".search-result");

	

	// Event Handlers
	$searchForm.on("submit", function(e) {
		e.preventDefault();


		console.log("form submitted");

		const searchDate = $searchDate.val();

		console.log(searchDate);

		getAjax(searchDate);
	})

	// Listening to favorites button
	$(".search-result").on("click", ".favorite-button", function(event) {
		event.preventDefault();

		console.log("favorites button clicked");

		let favDate = $("#photo-date").html();
		console.log(favDate);
		postAddFavorite(favDate);
	})

	// ajax calls

	function getAjax(searchDate) {
		console.log(searchDate);

		$.ajax({
			method: "GET",
			url: "backend/search_form_backend.php",
			data: {
				searchDate: searchDate
			}
		})
		.done(function(result) {
			console.log(result);

			displayGetResult(result);
			// displayGetResult(result)
		})
		.fail(function() {
			console.log("fail");
			alert("You are only allowed to input dates up to and including today.")
		});
	}

	function postAddFavorite(favDate) {
		console.log(favDate);

		$.ajax({
			method: "POST",
			url: "backend/favorite_backend.php",
			data: {
				favDate: favDate
			}
		})
		.done(function(result) {
			console.log(result);

			displayFavoriteResponse(result);
		})
	}

	function displayFavoriteResponse(result) {
		let parsedMessage = result;
		// TODO: message: success
		if (parsedMessage.message == "success") {
			console.log(parsedMessage.message)
			window.location.href = "search.php";
		}
		// TODO: message: "readding favorites"
		else if (parsedMessage.message == "readding favorites") {
			let alertMessage = "Already added to gallery.";
			alert(alertMessage);
		}
		// TODO: message: "user session is not active
		else {
			let alertMessage = "Must be logged in to favorite image.";
			alert(alertMessage);
		}

	}


	function displayGetResult(result) {

		if (result.message == 'Date is required.') {
			// clear out the existing elements in searchResult
			$searchResult.html("");

			// error message HTML
			let errorHTML = `<div class="col-12 col-sm-12 col-md-12 col-lg-12">
								<h3 class="text-white text-center">Date is required.</h3>
							</div>`;

			// append the HTML element to searchResult
			$searchResult.append(errorHTML);
		}
		else if (result.message == "You are only allowed to input dates up to and including today.") {
			// clear out the existing elements in searchResult
			$searchResult.html("");

			// error message HTML
			let errorHTML = `<div class="col-12 col-sm-12 col-md-12 col-lg-12">
								<h3 class="text-white text-center">You are only allowed to input dates up to and including today.</h3>
							</div>`;

			// append the HTML element to searchResult
			$searchResult.append(errorHTML);
		}
		else {
			// if there is no message from JSON result, then data is good
			// clears out the existing elements in searchResult
			$searchResult.html("");

			// one APOD result is returned in an array
			for (let apod of result) {
				let apodHTML = ``;

				// HTML elements if the media_type is a video
				if (apod.media_type == "video") {
					console.log("media type is video");

					apodHTML =
						`<div class="col-12 col-sm-12 col-md-12 col-lg-7">
				
							<div class="embed-responsive embed-responsive-16by9">
								<iframe class="embed-responsive-item" src="${apod.url}" allowfullscreen></iframe>
							</div>
						</div>
			
						<div class="col-12 col-sm-12 col-md-12 col-lg-5">
							
							<h2 class="picture-title my-3">${apod.title}</h2>
			
							<button type="button" class="btn btn-outline-light favorite-button">Favorite</button>
							
							<h5 id="photo-date" class="picture-title py-2">${apod.date}</h5>
							<h5 class="picture-title">Copyright: ${apod.copyright}</h5>
							<p class="picture-title">${apod.explanation}</p>
						</div>`;
				}
				// HTML elements if the media_type is an image
				else if (apod.media_type == "image") {
					console.log("media type is image")

					apodHTML =
						`<div class="col-12 col-sm-12 col-md-12 col-lg-7">
				
							<a href="${apod.url}" data-lightbox="${apod.title}" data-title="${apod.title}" >
								<img src="${apod.url}" class="img-fluid" alt="${apod.title}">
							</a>
						</div>
		
						<div class="col-12 col-sm-12 col-md-12 col-lg-5">
							
							<h2 class="picture-title my-3">${apod.title}</h2>
							<button type="button" class="btn btn-outline-light favorite-button">Favorite</button>
							
							<h5 id="photo-date" class="picture-title py-2">${apod.date}</h5>
							<h5 class="picture-title">Copyright: ${apod.copyright}</h5>
							<p class="picture-title">${apod.explanation}</p>
						</div>`;
				}

				// append the HTML element to searchResult
				$searchResult.append(apodHTML);
			}

		}

		// hide the search bar/search form
		$searchFormContainer.removeClass("d-block");
		$searchFormContainer.addClass("d-none");

		// display the searchResult (error or valid data)
		$searchResult.removeClass("d-none");
		$searchResult.addClass("d-flex");


	}
})