import "https://code.jquery.com/jquery-3.7.1.js";

const forms = [
	`<form action="/user" method="post" id="edit-form">
    <label for="username">Username: </label>
    <input
      type="text"
      id="username"
      name="username"
      required
      minlength="4"
      maxlength="128"
    />

    <button type="submit" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
	`<form action="/user" method="post" id="edit-form">
    <label for="is-admin">Is Admin: </label>
    <input id="is_admin" type="hidden" value="false" name="is_admin_hidden">
    <input type="checkbox" id="is-admin" name="is_admin" value="true" />
    
    <button type="submit" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
	`<form action="/user" method="post" id="edit-form">
    <label for="can-access">Can Access: </label>
    <input id="can_access" type="hidden" value="false" name="can_access_hidden">
    <input type="checkbox" id="can-access" name="can_access" value="true" />
    
    <button type="submit" id="edit-form-update-button">Update</button>
    <button type="button" id="edit-form-cancel-button">Cancel</button>
    </form>`,
];

let currentUserId = 0;

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
	currentUserId = data.userId;

	if (data.typeOfAction === "username") {
		container.append(forms[0]);
	} else if (data.typeOfAction === "is_admin") {
		container.append(forms[1]);
	} else if (data.typeOfAction === "can_access") {
		container.append(forms[2]);
	}
});

$(document).on("submit", "#edit-form", (e) => {
	e.preventDefault();

	console.log("Updating...");

	const data = $("#edit-form").serializeArray();

	if (data[0].name === "username") {
		if (data[0].value < 4 && data[0].value > 128) {
			return;
		}
	} else if (data.length === 1 && data[0].name === "is_admin_hidden") {
		data[0].name = "is_admin";
		data[0].value = false;
	} else if (data.length === 1 && data[0].name === "can_access_hidden") {
		data[0].name = "can_access";
		data[0].value = false;
	} else if (data.length === 2 && data[1].name === "is_admin") {
		data[0].name = "is_admin";
		data[0].value = true;

		data.pop();
	} else if (data.length === 2 && data[1].name === "can_access") {
		data[0].name = "can_access";
		data[0].value = true;

		data.pop();
	} else {
		return;
	}

	// console.log(data, { [data[0].name]: data[0].value });

	console.log(
		$.ajax({
			url: "../../user/" + currentUserId,
			method: "PUT",
			data: { [data[0].name]: data[0].value },
			dataType: "json",
			success: (data) => {
				alert("Success!");
				// Implement dynamic updating
				// location.reload();
				console.log(data);
			},
		}).responseText
	);

	currentUserId = 0;

	// $("#edit-form").remove();
});

$(document).on("click", "#edit-form-cancel-button", (e) => {
	$("#edit-form").remove();
});

