$(document).ready(function () {
	ScrollReveal({reset: false});

	const $cardRow = $(".card-row");


	// call backend to get an array of photo urls and photo_id
	// for each item, create a card with photo url and photo_id
	getFavorites();


	// add event listener to cards
	$(".card-row").on("click", ".card", function(event) {
		event.preventDefault();

		let photo_id = $(this).children(".photo-id").html();

		window.location.href = "details.php?photo_id=" + photo_id;
	});


	function getFavorites() {
		$.ajax({
			method: "GET",
			url: "backend/account_backend.php"
		})
		.done(function(result) {
			displayGetFavorites(result);
		})
		.fail(function() {
			console.log('fail');
		})
	}

	function displayGetFavorites(result) {
		console.log(result);

		$cardRow.html("");

		for (let i = 0; i < result.length; i++) {
			let fav = result[i];
			let cardHTML = ``;
			if (fav.media_type == "image") {
				cardHTML = 
					`<div class="col-12 col-sm-12 col-md-6 col-lg-4 my-4 card-div" >
						<div class="card card-transparent">
							<a href=""><img src="${fav.url}" class="img-fluid" alt="${fav.title}"></a>
							<span class="photo-id d-none">${fav.photo_id}</span>
							<div class="card-body text-center">
								<h5 class="card-title text-white">${fav.title}</h5>
								<p class="card-text">${fav.photo_date}</p>
								<a href="#" class="btn btn-outline-light">See Details</a>
							</div>
						</div>
					</div>`;
			}
			else if (fav.media_type == "video") {
				cardHTML =
					`<div class="col-12 col-sm-12 col-md-6 col-lg-4 my-4 card-div" >
						<div class="card card-transparent">
							<iframe class="embed-responsive-item" src="${fav.url}" allowfullscreen></iframe>
							<span class="photo-id d-none">${fav.photo_id}</span>
							<div class="card-body text-center">
								<h5 class="card-title text-white">${fav.title}</h5>
								<p class="card-text">${fav.photo_date}</p>
								<a href="#" class="btn btn-outline-light">See Details</a>
							</div>
						</div>
						
					</div>`;
			}

			$cardRow.append(cardHTML);
		}

		$cardRow.removeClass("d-none");
		ScrollReveal().reveal('.card');
	}

});
