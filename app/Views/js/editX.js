import "https://code.jquery.com/jquery-3.7.1.js";

console.log(1);

$(() => {
	// ?
});

// e.currentTarget === { currentTarget }
$(".edit-button").on("click", (e) => {
	console.log("Edit", $(e.currentTarget).data());
});

