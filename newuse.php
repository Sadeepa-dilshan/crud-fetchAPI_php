<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Data Display</title>
</head>
<body>
    <h1>Data from API</h1>
    <ul id="dataList">
        <!-- Data will be inserted here -->
    </ul>

    <h1>Insert Data</h1>
    <form id="insertForm">
        <input type="hidden" id="itemId" name="id"> <!-- Hidden field to store item ID for updates -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br>
        <button type="submit">Submit</button>
    </form>

    <h1>Update Data</h1>
    <form id="updateForm">
        <label for="updateName">Name:</label>
        <input type="text" id="updateName" name="name" required>
        <br>
        <label for="updatePrice">Price:</label>
        <input type="text" id="updatePrice" name="price" required>
        <br>
        <button type="submit">Update</button>
    </form>

    <script>
        // Function to fetch and display data
        function fetchDataAndDisplay() {
            const apiUrl = 'api.php'; // Replace with your API URL

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    const dataList = document.getElementById('dataList');

                    // Clear existing content
                    dataList.innerHTML = '';

                    // Loop through the data and create list items with Update and Delete buttons
                    data.forEach(item => {
                        const listItem = document.createElement('li');
                        listItem.textContent = `ID: ${item.id}, Name: ${item.name}, Price: ${item.price}`;

                        const updateButton = document.createElement('button');
                        updateButton.textContent = 'Update';
                        
                        updateButton.addEventListener('click', () => {
                            // Populate the update form with item details for editing
                            document.getElementById('updateName').value = item.name;
                            document.getElementById('updatePrice').value = item.price;

                            // Set the item's ID in the update form
                            document.getElementById('itemId').value = item.id;
                        });

                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete';
                        
                        deleteButton.addEventListener('click', () => {
                            deleteItem(item.id);
                        });

                        listItem.appendChild(updateButton);
                        listItem.appendChild(deleteButton);
                        dataList.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

            // Event listener for form submission
        document.getElementById('insertForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const name = document.getElementById('name').value;
            const price = document.getElementById('price').value;
            const data = {
                id: id,
                name: name,
                price: price,
            };

            fetch('post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                fetchDataAndDisplay(); // Refresh data after insertion
            })
            .catch(error => {
                console.error('Error:', error);
            });
        

        
            // If there's an ID, update the existing data; otherwise, insert new data
            // if (id) {
            //     updateItem(data);
            // } else {
            //     insertItem(data);
            // }
        });

        // Event listener for form submission (for updating)
        document.getElementById('updateForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('itemId').value;
            const name = document.getElementById('updateName').value;
            const price = document.getElementById('updatePrice').value;
            const data = {
                id: id,
                name: name,
                price: price
            };

            if (id) {
                updateItem(data);
            }
        });

        // Function to send a PUT request to update an item
        function updateItem(data) {
            const apiUrl = 'update.php'; // Replace with your UPDATE API URL

            fetch(apiUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                fetchDataAndDisplay(); // Refresh data after update
                document.getElementById('updateForm').reset(); // Reset the update form
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to send a DELETE request to delete an item
        function deleteItem(itemId) {
            const apiUrl = 'delete.php'; // Replace with your DELETE API URL

            fetch(apiUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: itemId }),
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                fetchDataAndDisplay(); // Refresh data after deletion
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Call the function to fetch and display data when the page loads
        window.addEventListener('load', fetchDataAndDisplay);
    </script>
</body>
</html>
