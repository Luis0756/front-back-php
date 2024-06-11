<!DOCTYPE html>
<html lang="en">

<?php
  include('view\common\head.php');
?>

<body>
    <div class="container" style="width: 100%">
      <div class="row" style="width: 100%">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5">
              <h5 class="card-title text-center mb-5 fw-light fs-5">Insira suas credenciais</h5>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="login" name="login" placeholder="name@example.com">
                <label for="floatingInput">Email</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="floatingPassword">Senha</label>
              </div>

              <hr class="my-4">
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" onclick="login()">Login</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
    function login() {
        let user = $('#login').val();
        let pass = $('#password').val();
        let dados = {
            user: user,
            pass: pass
        };

        $.ajax({
            url: 'login.php',
            type: 'POST',
            data: JSON.stringify(dados),
            contentType: 'application/json',
            dataType: 'json',
            success: function (retorno) {
                console.log("Retorno do servidor:", retorno);
                $('#resultado').html(retorno.msg);
                if (retorno.access) {
                    localStorage.setItem('token', retorno.token);
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro:", error); // Log para verificar erros
                $('#resultado').html('Erro na solicitação de login: ' + error);
            }
        });
    }

    $(document).ready(function() {
        let token = localStorage.getItem('token');
        if (token) {
            $.ajax({
                url: 'verifica_token.php',
                type: 'POST',
                data: JSON.stringify({ token: token }),
                contentType: 'application/json',
                dataType: 'json',
                success: function (retorno) {
                    console.log("Verificação de token:", retorno); // Log para verificar a resposta do servidor
                    if (!retorno.access) {
                        localStorage.removeItem('token');
                    } else {
                        $('#resultado').html('Usuário já está logado');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Erro:", error); // Log para verificar erros
                    $('#resultado').html('Erro na verificação de token: ' + error);
                    localStorage.removeItem('token');
                }
            });
        }
    });


  </script>
</html>