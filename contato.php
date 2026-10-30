
<!DOCTYPE html>
<html lang="pt-bt" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="main.css">
</head>

<body class="d-flex flex-column vh-100">
<header class="text-center mb-5 mt-3 d-flex justify-content-between w-100">
<button class="btn" onclick="history.back()">Voltar</button>
           
       
        <button id="toggle-theme-btn" style="width: 40px; height: 40px; border-radius: 100%;" class="btn">
            <i id="theme-icon" class="bi bi-moon-fill"></i>
        </button>
        </header>
        <main class="container py-5">
        <h1 class="text-center display-4 mb-4">Fale Conosco</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
        
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-envelope-fill display-1 text-primary"></i>
                        <h5 class="card-title mt-3">E-mail</h5>
                        <p class="card-text">Para suporte, envie um e-mail para:</p>
                        <p><strong>contato@exemplo.com</strong></p>
                    </div>
                </div>
            </div>
       
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-whatsapp display-1 text-success"></i>
                        <h5 class="card-title mt-3">WhatsApp</h5>
                        <p class="card-text">Converse conosco diretamente pelo WhatsApp:</p>
                        <p><strong>+55 99 99999-9999</strong></p>
                    </div>
                </div>
            </div>
 
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-instagram display-1 text-danger"></i>
                        <h5 class="card-title mt-3">Instagram</h5>
                        <p class="card-text">Siga-nos no Instagram para novidades:</p>
                        <p><strong>@exemplo_perfil</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-auto border-top py-3">
        <p class="text-center">&copyLocaFit - 2024 - Todos os direitos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="main.js"></script>
</body>

</html>