<?php
 include("conexao.php");
 session_start();
 
 if (!isset($_SESSION['usuario_id'])) {
     echo "<script>alert('Usuário não está logado.'); window.location.href = 'home.php';</script>";
     exit;
 }
 
 $usuario_id = $_SESSION['usuario_id'];
 
 $id = $nome_produto = $categoria_interesse = '';
 $id = null;
 
 if(isset($_GET['id'])){
     $id = intval($_GET['id']); 
 }else{
     echo "<script>alert('ID do produto não fornecido.'); window.location.href = 'area-interesses.php';</script>";
     exit;
 }
 
 $sql = "SELECT * FROM tb_area_interesse WHERE id = $id";
   $result = $conn->query($sql);
 
 if($result->num_rows > 0){
     $data = $result->fetch_assoc();
     $nome_produto = $data['nome_produto'];
     $categoria_interesse = $data['categoria_interesse'];
 }else{
     echo "<script>alert('Produto não encontrado.'); window.location.href = 'area-interesses.php';</script>";
     exit;
 }
 
 if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {
        $nome_produto = $conn->real_escape_string($_POST['produto']);
        $categoria_produto = $conn->real_escape_string($_POST['categoria']);
    }

     if (empty($_POST['produto']) || !isset($_POST['categoria']) || empty($_POST['categoria'])){
         echo "<script>alert('Todos os campos devem ser preenchidos.');</script>";
     }else{
        
         $sql_interesses = "UPDATE tb_area_interesse SET
         nome_produto = '$nome_produto',
         categoria_interesse = '$categoria_produto'
         WHERE id = '$id' AND tb_usuarios_id_usuarios = '$usuario_id'";
 
         if($conn->query($sql_interesses) === TRUE){
             echo "<script>alert('Produto Atualizado com Sucesso.'); window.location.href = 'area-interesses.php';</script>";
         }else{
             echo "<script>alert('Erro ao atualizar Produto.'); window.location.href = 'area-interesses.php';</script>";
         }
     }
 }
 

 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Cadastro de Área de Interresse</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 
     <style>
         body {
             background-color: #FFFAEB;
         }
         .form-container {
             display:flex;
             background-color: white;
             justify-content: center;
             align-items:center;
             border-radius: 10px;
             box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
             width: 40%;
             padding-top:100px;
             padding-bottom:50px
         }
         
         @media (max-width: 770px) {
     .form-container {
         width: 80%; /* Aumenta a largura do formulário para 60% em telas menores */
         padding-top: 80px; /* Ajuste do padding se necessário */
         padding-bottom: 40px; /* Ajuste do padding se necessário */
     }
 }
 
 @media (min-width: 601px) and (max-width: 768px) {
     .container {
         width: 70%;  /* Ajusta a largura para 70% em telas médias */
         padding-top: 40px;
         padding-bottom: 40px;
     }
 }
 @media (min-width: 769px) and (max-width: 1024px) {
     .container {
         width: 100%;  /* Ajusta a largura para 70% em telas médias */
         padding-top: 40px;
         padding-bottom: 40px;
     }
 }
 
     </style>
 </head>
 <body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-white">
         <div class="container-fluid">
             <a class="navbar-brand" href="#">
                 <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
             </a>
             <span class="navbar-text fs-4 fw-bold text-dark position-absolute start-50 translate-middle-x">EDITAR ÁREA DE INTERESSE</span>
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav ms-auto flex-row">
                     <li class="nav-item">
                         <a class="nav-link fs-2 me-2" href="home.php"><i class="bi bi-house"></i></a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link fs-2 me-2" href="meus-produtos.php"><i class="bi bi-box"></i></a>
                     </li>
     
                     <!-- Dropdown do usuário -->
                     <li class="nav-item dropdown">
                         <a class="nav-link fs-2 me-2 dropdown-toggle" href="home.php" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-person"></i>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                             <li><a class="dropdown-item" href="meus-produtos.php">Meus Produtos</a></li>
                             <li><a class="dropdown-item" href="cad-prod.php">Cadastrar Produto</a></li>
                             <li><a class="dropdown-item" href="area-interesses.php">Minha Área de Interesses</a></li>
                             <li><hr class="dropdown-divider"></li>
                             <li><a class="dropdown-item text-danger" href="login.php"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
                         </ul>
                     </li>
                 </ul>
             </div>
         </div>
     </nav>
 
     <!-- Conteúdo Principal -->
     <div class="d-flex justify-content-center align-items-center vh-100">
         <div class="form-container container-fluid">
             <form class="col-12" method="POST" action="">
                 <div class="mb-3">
                     <h4>Digite o nome do produto:</h4>
                     <input type="text" class="form-control" id="nomeProduto" name="produto" value="<?php if(isset($nome_produto)) echo $nome_produto;?>"  placeholder="Insira aqui...">
                 </div>
     
                 <div class="mb-3">
                 <select class="form-select" id="categoriaProduto" name="categoria">
                        <option value="" disabled <?php echo empty($categoria_interesse) ? 'selected' : '';?>>Selecione a categoria do Produto</option>
                        <option value="Cadeiras" <?php echo $categoria_interesse === 'Cadeiras' ? 'selected' : '';?>>Cadeiras</option>
                        <option value="Andadores" <?php echo $categoria_interesse === 'Andadores' ? 'selected' : '';?>>Andadores</option>
                        <option value="Muletas" <?php echo $categoria_interesse === 'Muletas' ? 'selected' : '';?>>Muletas</option>
                        <option value="Outros" <?php echo $categoria_interesse === 'Outros' ? 'selected' : '';?>>Outros</option>
                    </select>
                 </div>
     
                 <div class="d-flex gap-2 justify-content-center">
                     <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
                     <button type="button" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</button>
                 </div>
             </form>
         </div>
     </div>
     <!-- Rodapé -->
     <footer class="text-center py-4 text-white" style="background-color: #001F36;">
         <div class="container">
             <p>&copy;2025 Projeto Integrador III - Todos os direitos reservados.</p>
         </div>
     </footer>
 
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 </body>
 </html>