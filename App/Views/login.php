    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Login</h2>
            <form  id="loginForm" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text"   class="form-control" id="username" name="username" placeholder="Introduce tu nombre de usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password"  class="form-label">Contraseña</label>
                    <input type="password"   class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                <div class="mt-3 text-center">
                   <!-- <a href="#">¿Olvidaste tu contraseña?</a> -->
                </div>
            </form>
        </div>
    </div> 