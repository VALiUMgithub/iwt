document.addEventListener("DOMContentLoaded", function () {
  // Fetch and display contacts when the page loads
  fetchContacts();

  // Add Contact Form Submit
  document
    .getElementById("add-contact-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      const name = document.getElementById("name").value;
      const email = document.getElementById("email").value;
      const phone = document.getElementById("phone").value;
      const address = document.getElementById("address").value;

      // Send data to the PHP backend for adding a new contact
      fetch("add_contact.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({ name, email, phone, address }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Clear the form and update the contact list
            document.getElementById("add-contact-form").reset();
            fetchContacts();
          } else {
            alert("Error adding contact. Please try again.");
          }
        });
    });

  // Handle "Edit" and "Delete" buttons using event delegation
  document
    .getElementById("contact-table")
    .addEventListener("click", function (e) {
      if (e.target.matches(".edit-button")) {
        // Handle Edit button
        const id = e.target.dataset.id;
        showEditForm(id);
      } else if (e.target.matches(".delete-button")) {
        // Handle Delete button
        const id = e.target.dataset.id;
        deleteContact(id);
      }
    });

  // Edit Contact Form Submit
  document.getElementById("edit-form").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("edit-contact-id").value;
    const name = document.getElementById("edit-name").value;
    const email = document.getElementById("edit-email").value;
    const phone = document.getElementById("edit-phone").value;
    const address = document.getElementById("edit-address").value;

    // Send data to the PHP backend for updating the contact
    fetch("edit_contact.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ id, name, email, phone, address }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Hide the edit form, clear the form, and update the contact list
          hideEditForm();
          document.getElementById("edit-form").reset();
          fetchContacts();
        } else {
          alert("Error updating contact. Please try again.");
        }
      });
  });

  // Cancel Edit Contact
  document.getElementById("cancel-edit").addEventListener("click", function () {
    // Hide the edit form
    hideEditForm();
  });

  function showEditForm(id) {
    // Show the edit form and populate it with contact details
    const editForm = document.getElementById("edit-contact-form");
    editForm.style.display = "block";

    const contact = document.querySelector(
      `#contact-table tr[data-id="${id}"]`
    );

    if (contact) {
      const nameCell = contact.querySelector("td:nth-child(1)");
      const emailCell = contact.querySelector("td:nth-child(2)");
      const phoneCell = contact.querySelector("td:nth-child(3)");
      const addressCell = contact.querySelector("td:nth-child(4)");

      document.getElementById("edit-contact-id").value = id;
      document.getElementById("edit-name").value = nameCell.textContent;
      document.getElementById("edit-email").value = emailCell.textContent;
      document.getElementById("edit-phone").value = phoneCell.textContent;
      document.getElementById("edit-address").value = addressCell.textContent;
    } else {
      console.error("Contact not found.");
    }
  }

  function hideEditForm() {
    // Hide the edit form
    const editForm = document.getElementById("edit-contact-form");
    editForm.style.display = "none";
  }

  // Implement delete functionality
  function deleteContact(id) {
    if (confirm("Are you sure you want to delete this contact?")) {
      // Send an AJAX request to delete the contact
      fetch("delete_contact.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({ id: id }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Contact deleted successfully
            fetchContacts();
          } else {
            alert("Error deleting contact. Please try again.");
          }
        });
    }
  }

  function fetchContacts() {
    fetch("get_contacts.php")
      .then((response) => response.json())
      .then((data) => {
        const contactTable = document.getElementById("contact-table");
        contactTable.innerHTML = "";

        data.contacts.forEach((contact) => {
          console.log(contact.id);
          const row = contactTable.insertRow();
          row.dataset.id = contact.id;
          row.innerHTML = `
                        <td>${contact.name}</td>
                        <td>${contact.email}</td>
                        <td>${contact.phone}</td>
                        <td>${contact.address}</td>
                        <td>
                            <button class="edit-button" data-id="${contact.id}">Edit</button>
                            <button class="delete-button" data-id="${contact.id}">Delete</button>
                        </td>
                    `;
        });
      });
  }
});
