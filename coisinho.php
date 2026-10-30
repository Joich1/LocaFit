<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Aluguel - Catálogo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 1.2em;
        }
        .search-container, .filter-container {
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        .search-bar, .category-dropdown {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product-list {
            margin: 20px auto;
            width: 80%;
            max-width: 800px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 1.1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-item.hidden {
            display: none;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .product-name {
            font-weight: bold;
            color: #333;
        }
        .product-category {
            font-size: 0.9em;
            color: #999;
        }
        .product-price {
            color: #666;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ta incompleto</h1>
        <p>Encontre itens incríveis para alugar!</p>
    </div>

    <div class="search-container">
        <input 
            type="text" 
            class="search-bar" 
            id="searchBar" 
            placeholder="Digite o nome do produto..." 
            onkeyup="filterProducts()"
        >
    </div>

    <div class="filter-container">
        <select id="categoryDropdown" class="category-dropdown" onchange="filterProducts()">
            <option value="all">Todos</option>
            <option value="eletronico">Eletrônico</option>
            <option value="moda">Moda</option>
            <option value="construcao">Construção</option>
            <option value="tec">Tecnologia</option>
        </select>
    </div>

    <div class="product-list" id="productList">
        <?php
        

        // Buscar produtos no banco
        $sql = "SELECT id, nome, preco, imagem, categoria FROM produtos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($produto = $result->fetch_assoc()) {
                echo "<div class='product-item' data-name='" . htmlspecialchars($produto['nome']) . "' data-category='" . htmlspecialchars($produto['categoria']) . "'>";
                echo "<div>";
                echo "<span class='product-name'>" . htmlspecialchars($produto['nome']) . "</span><br>";
                echo "<span class='product-category'>" . htmlspecialchars($produto['categoria']) . "</span>";
                echo "</div>";
                echo "<span class='product-price'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</span>";
                if (!empty($produto['imagem'])) {
                    echo "<img src='uploads/" . htmlspecialchars($produto['imagem']) . "' alt='" . htmlspecialchars($produto['nome']) . "' style='max-width: 150px; height: auto; margin-left: 10px;'>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>Nenhum produto disponível no momento.</p>";
        }

        $conn->close();
        ?>
    </div>

    <div class="footer">
        <p>&copy; 2024 Loja de Aluguel. Todos os direitos reservados.</p>
    </div>

    <script>
        function filterProducts() {
            const searchInput = document.getElementById("searchBar").value.toLowerCase();
            const selectedCategory = document.getElementById("categoryDropdown").value;
            const productList = document.getElementById("productList");
            const items = productList.querySelectorAll(".product-item");

            items.forEach(item => {
                const productName = item.getAttribute("data-name").toLowerCase();
                const productCategory = item.getAttribute("data-category");

                const matchesSearch = productName.includes(searchInput);
                const matchesCategory = selectedCategory === "all" || productCategory === selectedCategory;

                item.classList.toggle("hidden", !(matchesSearch && matchesCategory));
            });
        }
    </script>
</body>
</html>