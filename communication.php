<?php

$servername = "localhost";
$username = "username";
$password = "password";
$database = "my_shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["action"] == "get_products") {
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        } else {
            echo "0 results";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PutInCart</title>
</head>
<body>
    <h1>PutInCart</h1>
    <div id="products"></div>

    <script>
    
        function getData(url, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    callback(JSON.parse(xhr.responseText));
                }
            };
            xhr.open("GET", url, true);
            xhr.send();
        }

        getData("backend.php?action=get_products", function(products) {
            var productsContainer = document.getElementById("products");
            products.forEach(function(product) {
                var productElement = document.createElement("div");
                productElement.innerHTML = "<h2>" + product.name + "</h2><p>Price: " + product.price + "</p>";
                productsContainer.appendChild(productElement);
            });
        });
    </script>
</body>
</html>
