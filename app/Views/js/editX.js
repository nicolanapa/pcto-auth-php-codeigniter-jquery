import "https://code.jquery.com/jquery-3.7.1.js";

const forms = [
	`<form action="/user/id" method="post" id="edit-form">
    <label for="username">Username: </label>
    <input
      type="text"
      id="username"
      name="username"
      required
      minlength="4"
      maxlength="128"
    />

    <button type="button" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
	`<form action="/user/id" method="post" id="edit-form">
    <label for="is-admin">Is Admin: </label>
    <input type="checkbox" id="is-admin" name="is_admin" value="true" required />
    
    <button type="button" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
	`<form action="/user/id" method="post" id="edit-form">
    <label for="can-access">Can Access: </label>
    <input type="checkbox" id="can-access" name="can_access" value="true" required />
    
    <button type="button" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
];

$(() => {
	// ?
});

// e.currentTarget === { currentTarget }
$(".edit-button").on("click", (e) => {
	const data = $(e.currentTarget).data();

	console.log("Edit", data);

	// Check if there's already an existing Form
	if ($(".edit-form-container").find("#edit-form").length === 1) {
		$("#edit-form").remove();
	}

	const container = $(".edit-form-container");

	// Render and display the Form
	// (Another Function) Then handle the submitting of the Form
	// And send requests to the REST routes
	if (data.typeOfAction === "username") {
		container.append(forms[0]);
	} else if (data.typeOfAction === "is_admin") {
		container.append(forms[1]);
	} else if (data.typeOfAction === "can_access") {
		container.append(forms[2]);
	}
});

$(document).on("click", "#edit-form-update-button", (e) => {
	console.log("Updating...");
	// $("#edit-form").remove();
});

$(document).on("click", "#edit-form-cancel-button", (e) => {
	$("#edit-form").remove();
});

