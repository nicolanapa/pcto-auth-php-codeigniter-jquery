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

	<div>
		<button type="submit" id="edit-form-update-button">Update</button>
		<button type="button" id="edit-form-cancel-button">Cancel</button>
    </div>
	</form>`,
	`<form action="/user" method="post" id="edit-form">
    <label for="is-admin">Is Admin: </label>
    <input id="is_admin" type="hidden" value="false" name="is_admin_hidden">
    <input type="checkbox" id="is-admin" name="is_admin" value="true" />
    
	<div>
		<button type="submit" id="edit-form-update-button">Update</button>
		<button type="button" id="edit-form-cancel-button">Cancel</button>
    </div>
	</form>`,
	`<form action="/user" method="post" id="edit-form">
    <label for="can-access">Can Access: </label>
    <input id="can_access" type="hidden" value="false" name="can_access_hidden">
    <input type="checkbox" id="can-access" name="can_access" value="true" />
    
	<div>
		<button type="submit" id="edit-form-update-button">Update</button>
		<button type="button" id="edit-form-cancel-button">Cancel</button>
    </div>
	</form>`,
];

let currentUserId = 0;

$(() => {
	// ?
});

// e.currentTarget === { currentTarget }
$(".edit-button").on("click", (e) => {
	const data = $(e.currentTarget).data();

	// Check if there's already an existing Form
	if ($(".edit-form-container").find("#edit-form").length === 1) {
		$("#edit-form").remove();
	}

	const container = $(".edit-form-container");

	// Render and display the Form
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

	const finalData = {
		[data[0].name]: data[0].value,
	};

	$.ajax({
		url: "../../user/" + currentUserId,
		method: "PUT",
		data: finalData,
		dataType: "json",
		success: (res) => {
			// console.log(res);
			changeTheTable(currentUserId, data[0].name, data[0].value);
		},
		complete: () => {
			$("#edit-form").remove();
			currentUserId = 0;
		},
	});
});

$(document).on("click", "#edit-form-cancel-button", (e) => {
	$("#edit-form").remove();
});

function changeTheTable(id, type, value) {
	value = typeof value === "string" ? value : value === true ? 1 : 0;

	$(`[data-user-id="${id}"][data-type-of-action="${type}"]`)
		.parent()
		.find("span")
		.text(value);
}

