<?php

// Configurações do banco de dados
$host = 'localhost';
$user = 'root'; // usuário padrão do XAMPP
$password = ''; // senha padrão do XAMPP (vazia)
$database = 'login'; // substitua pelo nome do seu banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Receber dados do forms
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Acessar o IF quando o usuario clicar no botão de acesso do formulario
if (!empty($dados["Sendlogin"])) {
    // Preparar a consulta SQL
    $query_usuario = "SELECT id, senha FROM usuarios WHERE usuario = ? LIMIT 1";
    $stmt = $conn->prepare($query_usuario);
    $stmt->bind_param("s", $dados["usuario"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 1) {
        // Usuário encontrado, verificar senha
        $row_usuario = $resultado->fetch_assoc();
        if (md5($dados["senha_usuario"], $row_usuario['senha'])) {
            // Senha correta - iniciar sessão e redirecionar
            session_start();
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['usuario'] = $dados["usuario"];
            
            header("Location: dashboard.php"); // redireciona para página restrita
            exit();
        } else {
            echo "<p style='color: red'>Erro: Senha incorreta!</p>";
        }
    } else {
        echo "<p style='color: red'>Erro: Usuário não encontrado!</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="index.css">
<title>Lucky's Store</title>
</head>
<body>
<header>
  <div class="header-content" role="banner">
    <a href="#" class="logo" aria-label="Loja Inspirada na OLX"><span>Lucky's</span> Store</a>

    <form class="search-bar" role="search" aria-label="Buscar produtos">
      <input
        type="search"
        placeholder="Buscar produtos, marcas e mais..."
        aria-label="Campo de busca"
        id="searchInput"
        autocomplete="off"
      />
      <span class="material-icons" aria-hidden="true">search</span>
    </form>

    <div class="auth-buttons">
      <a href="login.html" class="login-btn" aria-label="Login">Login</a>
      <a href="cadastro.html" class="register-btn" aria-label="Cadastro">Cadastro</a>
    </div>
  </div>
  <nav class="filters" aria-label="Filtros de categorias" role="navigation">
    <button class="filter-btn active" data-filter="all" aria-pressed="true" type="button">Todos</button>
    <button class="filter-btn" data-filter="electronics" aria-pressed="false" type="button">Eletrônicos</button>
    <button class="filter-btn" data-filter="cars" aria-pressed="false" type="button">Carros</button>
    <button class="filter-btn" data-filter="furniture" aria-pressed="false" type="button">Móveis</button>
    <button class="filter-btn" data-filter="fashion" aria-pressed="false" type="button">Moda</button>
    <button class="filter-btn" data-filter="sports" aria-pressed="false" type="button">Esportes</button>
  </nav>
</header>

<main class="container" aria-live="polite" aria-label="Lista de produtos">
  <section class="product-grid" id="productContainer" tabindex="-1">
    <!-- Products dynamically inserted here -->
  </section>
</main>

<footer role="contentinfo">
  &copy; 2024 Loja Inspirada na OLX - Todos os direitos reservados.
</footer>

<script>
  // Sample product data simulating OLX store products
  const products = [
    {
      id: '1',
      title: 'Smartphone Samsung Galaxy A54 5G',
      description: 'Celular com câmera de alta resolução e bateria duradoura, ótimo para quem gosta de jogar.',
      price: 'R$ 3.200,00',
      category: 'electronics',
      imageUrl: 'https://images.tcdn.com.br/img/img_prod/1233679/celular_galaxy_a54_5g_128gb_preto_zf_samsung_4965_1_4562121d8b061b0bae0681f0886c1cd9.jpg',
      link: 'a54.html'
    },
    {
      id: '2',
      title: 'Honda Civic Type-r',
      description: 'Carro esportivo de tração dianteira com design aerodinâmico, tecnologia avançada e segurança de alto nível.',
      price: 'R$ 490.000,00',
      category: 'cars',
      imageUrl: 'https://i.pinimg.com/736x/a1/4d/6a/a14d6a53fcc0840f1430e8eb732ad2d6.jpg',
      link: 'civic.html'
    },
    {
      id: '3',
      title: 'Sofá de Couro 3 Lugares',
      description: 'Sofá confortável com design moderno e cor preta.',
      price: 'R$ 1.200,00',
      category: 'furniture',
      imageUrl: 'https://a-static.mlcdn.com.br/1500x1500/sofa-3-lugares-net-jobim-assento-retratil-e-reclinavel-areia-205m-l-netsofas/netsofas02/job030102/6d520566ae7e4deef4ef9750bd753585.jpeg',
      link: 'sofa.html'
    },
    {
      id: '4',
      title: 'Tênis Nike Air Max',
      description: 'Calçado esportivo para corrida com amortecimento avançado.',
      price: 'R$ 450,00',
      category: 'fashion',
      imageUrl: 'https://imgcentauro-a.akamaihd.net/400x400/98840051A1.jpg',
      link: 'tenis.html' 
    },
    {
      id: '5',
      title: 'Raquete de Tênis Wilson',
      description: 'Raquete leve e resistente para jogadores intermediários.',
      price: 'R$ 350,00',
      category: 'sports',
      imageUrl: 'https://contents.mediadecathlon.com/p2468004/k$7180d77501b2cd6b4ed7d7e2194e277a/picture.jpg?format=auto&f=3000x0.png',
      link: 'raquete.html' 
    },
    {
      id: '6',
      title: 'Notebook Acer Nitro V15',
      description: 'Notebook com processador i7, 16GB RAM, SSD 512GB.',
      price: 'R$ 4.500,00',
      category: 'electronics',
      imageUrl: 'https://windowsarea.de/wp-content/uploads/2019/05/Acer-Nitro-5-AN515-43-wp-03.jpg',
      link: 'pc.html' 
    }
  ];

  const productContainer = document.getElementById('productContainer');
  const filterButtons = document.querySelectorAll('.filter-btn');
  const searchInput = document.getElementById('searchInput');

  // Render product cards based on given list
  function renderProducts(productList) {
    if (productList.length === 0) {
      productContainer.innerHTML = '<p style="font-size: 1.2rem; margin-top: 32px; text-align:center; color:#999;">Nenhum produto encontrado.</p>';
      return;
    }
    productContainer.innerHTML = productList.map(product => /*html*/`
      <a href="${product.link}" class="product-card" tabindex="0" role="article" aria-labelledby="product-title-${product.id}" aria-describedby="product-desc-${product.id}">
        <div class="product-image">
          <img
            src="${product.imageUrl}"
            alt="Imagem do produto: ${product.title}"
            loading="lazy"
            width="400"
            height="300"
            onerror="this.onerror=null;this.src='https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/552bf1ba-66f3-4aee-839e-fa2ba09a4fec.png';"
            />
        </div>
        <div class="product-info">
          <h2 class="product-title" id="product-title-${product.id}">${product.title}</h2>
          <p class="product-description" id="product-desc-${product.id}">${product.description}</p>
          <div class="product-price" aria-label="Preço do produto">${product.price}</div>
        </div>
      </a>
    `).join('');
  }

  // Filter products by category and search term
  function filterProducts() {
    const activeFilterBtn = document.querySelector('.filter-btn.active');
    const categoryFilter = activeFilterBtn ? activeFilterBtn.dataset.filter : 'all';
    const searchTerm = searchInput.value.trim().toLowerCase();

    let filtered = products.filter(p => categoryFilter === 'all' || p.category === categoryFilter);

    if (searchTerm) {
      filtered = filtered.filter(p =>
        p.title.toLowerCase().includes(searchTerm) ||
        p.description.toLowerCase().includes(searchTerm)
      );
    }

    renderProducts(filtered);
  }

  // Handle filter button clicks
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      filterButtons.forEach(btn => {
        btn.classList.remove('active');
        btn.setAttribute('aria-pressed', 'false');
      });
      button.classList.add('active');
      button.setAttribute('aria-pressed', 'true');
      filterProducts();
      searchInput.focus();
    });
  });

  // Search input event with debounce for performance
  let searchTimeout = null;
  searchInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(filterProducts, 250);
  });

  // Initial render all products
  renderProducts(products);
</script>
</body>
</html>
