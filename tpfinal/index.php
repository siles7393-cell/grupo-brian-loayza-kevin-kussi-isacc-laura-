<?php
require 'config.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chat Global LAN</title>
<style>
body{font-family:Arial,sans-serif;max-width:800px;margin:20px auto;}
#messages{border:1px solid #ddd;height:400px;overflow:auto;padding:8px;margin-bottom:10px;background:#fafafa;}
.msg{margin-bottom:8px;padding-bottom:4px;border-bottom:1px dashed #eee;}
.meta{font-size:12px;color:#666;}
form textarea{width:100%;box-sizing:border-box;}
</style>
</head>
<body>
<h1>Chat Global LAN</h1>
<p>
<?php if(isset($_SESSION['user_id'])): ?>
Hola, <strong><?= e($_SESSION['username']) ?></strong> — <a href="logout.php">Cerrar sesión</a>
<?php else: ?>
Eres <strong><?= e($_SESSION['guest_name']) ?></strong> (invitado) — 
<a href="register.php">Crear cuenta</a> | <a href="login.php">Iniciar sesión</a>
<?php endif; ?>
</p>

<div id="messages"></div>

<form id="msgForm">
<textarea id="content" rows="3" placeholder="Escribe tu mensaje..." maxlength="1000"></textarea><br>
<button type="submit">Enviar</button>
</form>

<script>
const messagesEl = document.getElementById('messages');

async function loadMessages(){
    const res = await fetch('get_messages.php');
    const html = await res.text();
    messagesEl.innerHTML = html;
    messagesEl.scrollTop = messagesEl.scrollHeight;
}

// refresco cada 2s
setInterval(loadMessages,2000);
loadMessages();

document.getElementById('msgForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const content = document.getElementById('content').value.trim();
    if(!content) return alert('Escribe algo.');
    const formData = new FormData();
    formData.append('content',content);

    const res = await fetch('post_message.php',{
        method:'POST',
        body: formData
    });
    const text = await res.text();
    if(text.trim()==='OK'){
        document.getElementById('content').value='';
        loadMessages();
    } else {
        alert(text);
    }
});
</script>
</body>
</html>
