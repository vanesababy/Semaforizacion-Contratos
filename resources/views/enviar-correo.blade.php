<!DOCTYPE html>
<html>
<head>
    <title>Enviar Correo a Administrativos</title>
</head>
<body>
    <form action="/enviar-correo-personalizado" method="POST">
        @csrf
        <div>
            <label>Asunto:</label>
            <input type="text" name="asunto" required>
        </div>
        <div>
            <label>Mensaje:</label>
            <textarea name="mensaje" required></textarea>
        </div>
        <button type="submit">Enviar Correo</button>
    </form>
</body>
</html>