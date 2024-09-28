# App Laravel

Este repositório contém uma aplicação Laravel

## 🚀 Instalação

**Para instalar a aplicação em sua máquina, siga os passos abaixo:**

```bash
git clone https://github.com/oGuilherme1/teste-back-end-logzz.git
```

```bash
cd teste-back-end-logzz
```

```bash
composer install
```

```bash
cp .env.example .env
```

```bash
docker-compose up -d
```

```bash
docker exec -it laravel_logzz /bin/bash
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan storage:link
```

```bash
npm run dev
```


**Rodando os commands**
- *Pra importar 1 produto*
```bash
php artisan products:import --id=1
```
- *Pra importar todos os produtos*
```bash
php artisan products:import
```
- *Rode o comando abaixo pra rodar os jobs*
```bash
php artisan horizon
```

Access the api in [http://localhost:8000](http://localhost:8000).




