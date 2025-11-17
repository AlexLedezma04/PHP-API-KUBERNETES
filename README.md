# Aplicación PHP + API Clima + Docker + Kubernetes

Aplicación web en PHP que consume la API pública de Open-Meteo para mostrar información del clima actual.

## Tecnologías

- PHP 8.2 con Apache
- Docker
- Kubernetes (Minikube)
- API Open-Meteo

## Requisitos

- Debian 13 Bookworm (o superior)
- Docker y Docker Compose instalados
- Minikube instalado
- kubectl instalado

## Instalación y Despliegue

### 1. Clonar el repositorio
```bash
git clone <tu-repositorio>
cd php-clima-k8s
```

### 2. Iniciar Minikube
```bash
minikube start --driver=docker
```

### 3. Construir la imagen Docker
```bash
docker build -t php-clima-api:v1 .
```

### 4. Cargar la imagen en Minikube
```bash
minikube image load php-clima-api:v1
```

### 5. Desplegar en Kubernetes
```bash
kubectl apply -f k8s-deployment.yaml
```

### 6. Verificar el despliegue
```bash
kubectl get pods
kubectl get service php-clima-service
```

### 7. Acceder a la aplicación
```bash
minikube service php-clima-service
```

O usando port-forward:
```bash
kubectl port-forward service/php-clima-service 8080:80
```

Luego abrir: `http://localhost:8080`

## Limpieza
```bash
kubectl delete -f k8s-deployment.yaml
minikube stop
```