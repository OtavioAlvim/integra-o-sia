<?php
include('../../login/verifica_login.php');
include('../../DB/conexao.php');

$busca_cliente_ja_cadastrado = $conn->query("SELECT c.cnpj,c.fantasia FROM registro_criacao c");
$resultado_busca = $busca_cliente_ja_cadastrado->fetchAll(PDO::FETCH_ASSOC);

?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMINISTRAÇÃO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="../../api/sweetalert2.js"></script>
</head>

<body>


<ul class="nav nav-tabs" id="myTab" role="tablist">
<a class="btn btn-primary" href="../index.php" role="button">Pagina Inicial</a>
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" name="" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Cadastrar empresa</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" name="" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">cadastrar vendedor pré venda</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" name="" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Manutenção</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <div class="container">

<!-- modal cliente ja cadastrado no sistema -->


    <?php
if(isset($_SESSION['errorr'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Base ja cadastrada para esse CNPJ',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['errorr']);
?>
<!-- ************************************************************* -->
<?php
if(isset($_SESSION['base_aprovada'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Base cadastrada com sucesso, necessario inserir vendedor na base!',
  showConfirmButton: false,
  timer: 3500
})
</script>
 <?php
endif;
unset($_SESSION['base_aprovada']);
?>
        <h2>Dados Gerais</h2>
        <form action="processa_nova_empresa.php" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">FANTASIA</label>
                <input name="fantasia" type="text" class="form-control" id="exampleFormControlInput1" placeholder="MEU LORO DO BRASIL" required>
                <label for="exampleFormControlInput1" class="form-label">TELEFONE</label>
                <input name="telefone" type="number" class="form-control" id="exampleFormControlInput1" placeholder="(99)9999-9999" required>
                <label for="exampleFormControlInput1" class="form-label">ENDEREÇO ABREVIADO</label>
                <input name="endereco" type="text" class="form-control" id="exampleFormControlInput1" placeholder="AVENIDA PREFEITO OLAVO GOMES DE OLIVEIRA" required>
                <label for="exampleFormControlInput1" class="form-label">CNPJ</label>
                <input name="cnpj" type="number" class="form-control" id="exampleFormControlInput1" placeholder="00.000.000/000-00" required>
                <label for="exampleFormControlInput1" class="form-label">DADOS-ADICIONAIS</label>
                <input name="dadosAdicionais" type="text" class="form-control" id="exampleFormControlInput1" placeholder="VOLTE SEMPRE!" required>
                <label for="exampleFormControlInput1" class="form-label">ID_TIPOPEDIDO</label>
                <input name="id_tipopedido" type="number" class="form-control" id="exampleFormControlInput1" placeholder="ID TIPO PEDIDO SIA" required>
                <label for="exampleFormControlInput1" class="form-label">DESCRIÇÃO_TIPOPEDIDO</label>
                <input name="descricao_tipopedido" type="text" class="form-control" id="exampleFormControlInput1" placeholder="DESCRICAO TIPO PEDIDO SIA" required>
                <label for="exampleFormControlInput1" class="form-label">ID_CLIENTE SIA</label>
                <input name="idClienteSia" type="number" class="form-control" id="exampleFormControlInput1" placeholder="ID_CLIENTE SIA" required>
                <label for="exampleFormControlInput1" class="form-label">DESCRIÇÃO_CLIENTE_PADRAO SIA</label>
                <input name="nomeClientePadrao" type="text" class="form-control" id="exampleFormControlInput1" placeholder="DESCRIÇÃO_CLIENTE_PADRAO SIA" required>

                <label for="exampleFormControlInput1" class="form-label">ID_ULTIMO_PEDIDO_VENDEDOR</label>
                <input name="pedido_vendedor" type="number" class="form-control" id="exampleFormControlInput1" placeholder="ID_ULTIMO_PEDIDO">
                <label for="exampleFormControlInput1" class="form-label">ID_VENDEDOR</label>
                <input name="idVendedor" type="number" class="form-control" id="exampleFormControlInput1" placeholder="ID_VENDEDOR" required>
                <label for="exampleFormControlInput1" class="form-label">NOME_VENDEDOR</label>
                <input name="nomeVendedor" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NOME_VENDEDOR" required>
                <label for="exampleFormControlInput1" class="form-label">EMAIL DE ACESSO</label>
                <input name="email" type="text" class="form-control" id="exampleFormControlInput1" placeholder="EMAIL" required>
                <label for="exampleFormControlInput1" class="form-label">SENHA DE ACESSO</label>
                <input name="senha" type="text" class="form-control" id="exampleFormControlInput1" placeholder="SENHA" required>
            </div>
            <button  type="button" class="btn btn-danger">CANCELAR</button>
            <button  type="submit" class="btn btn-success">CADASTRAR</button>
        </form>
    </div>    
    </div>
  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    <div class="container">
        <br>

<!-- modal cliente ja cadastrado no sistema -->


<?php
if(isset($_SESSION['usuario_ja_cadastrado'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Usuario ja cadastrado nesta empresa',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['usuario_ja_cadastrado']);
?>
<!-- ************************************************************* -->
<?php
if(isset($_SESSION['usuario_cadastrado'])):
?>

<script>
Swal.fire({
  icon: 'success',
  title: 'Usuario vinculado com sucesso!',
  showConfirmButton: false,
  timer: 3500
})
</script>
 <?php
endif;
unset($_SESSION['usuario_cadastrado']);
?>

<!-- modal selecione empresa -->


<?php
if(isset($_SESSION['selecione_empresa'])):
?>

<script>
Swal.fire({
  icon: 'error',
  title: 'ERRO...',
  text: 'Empresa não inserida!',
//   footer: '<a href="">Why do I have this issue?</a>'
})
</script>
 <?php
endif;
unset($_SESSION['selecione_empresa']);
?>
        <h2>Selecione a Empresa</h2>
        <form action="processa_usuario.php" method="post">
        <select name="cnpj_empresa" class="form-select" aria-label="Default select example">
              <option selected>SELECIONAR EMPRESA</option>
              <?php
              foreach($resultado_busca as $row=> $registro){?>
                    <option value="<?php echo $registro['cnpj']?>"><?php echo $registro['fantasia'] ." - ".$registro['cnpj']?></option>
              <?php }
              ?>
          </select><br>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">EMAIL</label>
            <input name="email" type="text" class="form-control" id="exampleFormControlInput1" placeholder="MEU_LORO@GMAIL.COM" required>
            <label for="exampleFormControlInput1" class="form-label">SENHA</label>
            <input name="senha" type="pass" class="form-control" id="exampleFormControlInput1" placeholder="123" required>
            <label for="exampleFormControlInput1" class="form-label">ID_VENDEDOR SIA</label>
            <input name="id_vendedor_sia" type="number" class="form-control" id="exampleFormControlInput1" placeholder="1" required>
            <label for="exampleFormControlInput1" class="form-label">NOME VENDEDOR SIA</label>
            <input name="nome_vendedor_sia" type="text" class="form-control" id="exampleFormControlInput1" placeholder="TESTE" required>
            <label for="exampleFormControlInput1" class="form-label">ID_ULTIMO PEDIDO</label>
            <input name="id_ultimo_pedido" type="number" class="form-control" id="exampleFormControlInput1" placeholder="1">
        </div>
        <button type="button" class="btn btn-danger">CANCELAR</button>
        <button type="submit" class="btn btn-success">CADASTRAR</button>
    </form>
    </div>
  </div>
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
    <br>
  <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Restaurar Base</h5>
                        <p class="card-text">procedimento usado para trocar a base completa do cliente sendo necessario refazer a configuração.</p>
                        <a href="#" class="btn btn-primary">Restaurar</a>
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Excluir Base</h5>
                        <p class="card-text">procedimento usado para Excluir a base completa do cliente sendo necessario refazer a configuração.</p>
                        <a href="#" class="btn btn-primary">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>