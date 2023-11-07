 #!/bin/bash

# Função para parar o servidor Symfony quando o contêiner é interrompido
stop_server() {
    echo "Parando o servidor Symfony..."
    symfony server:stop
    exit 0
}

# Capturar o sinal de interrupção e chamar a função stop_server
trap stop_server SIGINT

# Iniciar o servidor Symfony
symfony server:start --daemon

# Manter o script em execução para que o trap continue funcionando
while true; do
    sleep 1
done
